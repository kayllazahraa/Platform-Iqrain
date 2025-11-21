<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\TingkatanIqra;
use App\Models\MateriPembelajaran;
use App\Models\VideoPembelajaran;
use App\Models\ProgressModul;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModulController extends Controller
{
    public function index($tingkatan_id){
        // 1. Fetch data dasar (Paling aman: gunakan findOrFail)
        $tingkatan = TingkatanIqra::with('materiPembelajarans')->findOrFail($tingkatan_id);
        $videos = VideoPembelajaran::where('tingkatan_id', $tingkatan_id)->get();
        
        // --- INISIALISASI VARIABEL PROGRESS (Default ke 0) ---
        $progressPercentage = 0;
        $completedMaterialsCount = 0;
        $totalMaterials = $tingkatan->materiPembelajarans->count();

        // 2. Ambil User dan Profil Murid
        $user = Auth::user(); 
        
        // Gunakan pengecekan ganda yang sangat aman
        if ($user && $user->murid) {
            $murid_id = $user->murid->murid_id;
            
            // Cek apakah ada materi yang bisa dilacak
            if ($totalMaterials > 0) {
                // Ambil ID Materi yang relevan
                $materiIds = $tingkatan->materiPembelajarans->pluck('materi_id');
                
                // Hitung progress di database
                $completedMaterialsCount = ProgressModul::where('murid_id', $murid_id)
                    ->whereIn('materi_id', $materiIds)
                    ->distinct('materi_id')
                    ->count();

                $progressPercentage = round(($completedMaterialsCount / $totalMaterials) * 100);
            }
        }
        
        // 3. Kirim variabel ke view
        return view('pages.murid.modul.index', compact('tingkatan', 'videos', 'progressPercentage', 'completedMaterialsCount', 'totalMaterials'));
    }

    public function video($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
        $videos = VideoPembelajaran::where('tingkatan_id', $tingkatan_id)->get();

        return view('pages.murid.modul.index', compact('tingkatan', 'videos'));
    }

    public function materi($tingkatan_id, $materi_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
        $materi = MateriPembelajaran::with('moduls')->findOrFail($materi_id);
        $allMateris = MateriPembelajaran::where('tingkatan_id', $tingkatan_id)
            ->orderBy('urutan')
            ->get();

        // Get previous and next materi
        $currentIndex = $allMateris->search(function ($item) use ($materi_id) {
            return $item->materi_id == $materi_id;
        });

        $prevMateri = $currentIndex > 0 ? $allMateris[$currentIndex - 1] : null;
        $nextMateri = $currentIndex < $allMateris->count() - 1 ? $allMateris[$currentIndex + 1] : null;

        return response()->json([
            'materi' => $materi,
            'prev' => $prevMateri,
            'next' => $nextMateri,
            'current' => $currentIndex + 1,
            'total' => $allMateris->count()
        ]);
    }

    public function updateProgress(Request $request)
    {
        $request->validate([
            'materi_id' => 'required|integer'
        ]);

        $user = Auth::user();

        if ($user && $user->murid) {
            // Simpan atau Update Progress
            ProgressModul::updateOrCreate(
                [
                    'murid_id' => $user->murid->murid_id,
                    'materi_id' => $request->materi_id,
                ],
                [
                    'waktu_selesai' => now(),
                    // Jika tabel progress_moduls butuh modul_id, kamu mungkin perlu
                    // mengambilnya dari tabel materi_pembelajarans dulu, 
                    // tapi jika nullable atau tidak strict, ini cukup.
                ]
            );

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }
}
