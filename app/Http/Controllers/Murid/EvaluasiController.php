<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\TingkatanIqra;
use App\Models\Leaderboard;
use App\Models\HasilGame;
use App\Models\JenisGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluasiController extends Controller
{
    public function index($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
        $murid = Auth::user()->murid;
        $leaderboardType = request()->get('type', 'global');

        // ============================================================
        // 1. LOGIKA FILTER YANG TEGAS (ANTI-BOCOR)
        // ============================================================
        
        // Default kosong dulu
        $leaderboards = collect([]); 

        if ($leaderboardType === 'mentor') {
            // --- KASUS: USER MINTA RANKING MENTOR ---
            
            if ($murid->mentor_id) {
                // HANYA JIKA user punya mentor, kita ambil datanya
                $leaderboards = Leaderboard::with('murid.user')
                    ->where('mentor_id', $murid->mentor_id) 
                    ->orderBy('total_poin_semua_game', 'desc')
                    ->get();
            } 
            // Jika user pilih 'mentor' TAPI 'mentor_id' dia null,
            // variabel $leaderboards tetap kosong (collect([])).
            // Jadi tampilannya nanti "Belum ada data", BUKAN Global.

        } else {
            // --- KASUS: USER MINTA RANKING GLOBAL ---
            
            $leaderboards = Leaderboard::with('murid.user')
                ->orderBy('total_poin_semua_game', 'desc')
                ->get();
        }

        // ============================================================
        // 2. HITUNG RANKING DADAKAN (1, 2, 3...)
        // ============================================================
        // Kode ini aman dijalankan walaupun $leaderboards kosong
        $leaderboards = $leaderboards->map(function ($item, $index) {
            $item->ranking_display = $index + 1;
            return $item;
        });

        // 3. Cari data 'Saya' di dalam list yang sedang aktif
        // Kalau list kosong (karena gak punya mentor), $myRanking juga null (aman)
        $myRanking = $leaderboards->firstWhere('murid_id', $murid->murid_id);

        // ============================================================
        // EVALUASI 
        // ============================================================
        $jenisGames = JenisGame::all();
        $evaluasiData = [];

       foreach ($jenisGames as $game) {

            // --- LOGIKA BARU ---

            // 1. Ambil semua hasil permainan untuk game ini
            $allResults = HasilGame::where('murid_id', $murid->murid_id)
                ->where('jenis_game_id', $game->jenis_game_id)
                ->get();

            // 2. Hitung total poin dan total jumlah main
            $totalPoinGameIni = $allResults->sum('total_poin');
            $jumlahMain       = $allResults->count();

            // Siapkan variabel default
            $ulasan         = null;
            $resultForView  = null;

            if ($jumlahMain > 0) {
                // Buat objek sederhana agar mudah dibaca di Blade
                $resultForView = (object) [
                    'total_poin' => $totalPoinGameIni, // total semua poin
                    'skor'       => $jumlahMain        // jumlah bermain
                ];

                // Hitung rata-rata dan persentase
                $poinMaksimal = $game->poin_maksimal ?? 100;
                $rataRata     = $totalPoinGameIni / $jumlahMain;
                $persen       = ($rataRata / $poinMaksimal) * 100;

                // Tentukan ulasan berdasarkan persentase rata-rata
                if ($persen >= 90) {
                    $ulasan = 'Luar biasa! Kamu konsisten hebat! 🌟';
                } elseif ($persen >= 75) {
                    $ulasan = 'Bagus sekali! Rata-rata skormu tinggi! 💪';
                } elseif ($persen >= 60) {
                    $ulasan = 'Cukup baik! Terus tingkatkan! 😊';
                } else {
                    $ulasan = 'Tetap semangat! Latihan lagi ya! 🔥';
                }
            }

            // Masukkan ke array evaluasi
            $evaluasiData[] = [
                'game'   => $game,
                'result' => $resultForView,
                'ulasan' => $ulasan,
            ];
        }


        return view('pages.murid.evaluasi.index', compact(
            'tingkatan',
            'leaderboards',
            'myRanking',
            'leaderboardType',
            'evaluasiData'
        ));
    }
}
