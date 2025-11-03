<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MateriPembelajaran;
use App\Models\Modul;

class MateriIqra1Seeder extends Seeder
{
    public function run()
    {
        $materis = [
            ['judul' => 'Alif', 'latin' => 'A', 'urutan' => 1],
            ['judul' => 'Ba', 'latin' => 'B', 'urutan' => 2],
            ['judul' => 'Ta', 'latin' => 'T', 'urutan' => 3],
            ['judul' => 'Tsa', 'latin' => 'Ts', 'urutan' => 4],
            ['judul' => 'Jim', 'latin' => 'J', 'urutan' => 5],
            ['judul' => 'Ha', 'latin' => 'H', 'urutan' => 6],
            ['judul' => 'Kha', 'latin' => 'Kh', 'urutan' => 7],
            ['judul' => 'Dal', 'latin' => 'D', 'urutan' => 8],
            ['judul' => 'Dzal', 'latin' => 'Dz', 'urutan' => 9],
            ['judul' => 'Ra', 'latin' => 'R', 'urutan' => 10],
            ['judul' => 'Zai', 'latin' => 'Z', 'urutan' => 11],
            ['judul' => 'Sin', 'latin' => 'S', 'urutan' => 12],
            ['judul' => 'Syin', 'latin' => 'Sy', 'urutan' => 13],
            ['judul' => 'Sad', 'latin' => 'Sh', 'urutan' => 14],
            ['judul' => 'Dhad', 'latin' => 'Dh', 'urutan' => 15],
            ['judul' => 'Tha', 'latin' => 'Th', 'urutan' => 16],
            ['judul' => 'Dha', 'latin' => 'Zh', 'urutan' => 17],
            ['judul' => 'Ain', 'latin' => 'A', 'urutan' => 18],
            ['judul' => 'Ghain', 'latin' => 'Gh', 'urutan' => 19],
            ['judul' => 'Fa', 'latin' => 'F', 'urutan' => 20],
            ['judul' => 'Qaf', 'latin' => 'Q', 'urutan' => 21],
            ['judul' => 'Kaf', 'latin' => 'K', 'urutan' => 22],
            ['judul' => 'Lam', 'latin' => 'L', 'urutan' => 23],
            ['judul' => 'Mim', 'latin' => 'M', 'urutan' => 24],
            ['judul' => 'Nun', 'latin' => 'N', 'urutan' => 25],
            ['judul' => 'Waw', 'latin' => 'W', 'urutan' => 26],
            ['judul' => 'Ha', 'latin' => 'H', 'urutan' => 27],
            ['judul' => 'LamAlif', 'latin' => 'LamAlif', 'urutan' => 28],
            ['judul' => 'Hamzah', 'latin' => 'Hamzah', 'urutan' => 29],
            ['judul' => 'Ya', 'latin' => 'Y', 'urutan' => 30],
        ];

        foreach ($materis as $materiData) {
            $materi = MateriPembelajaran::create([
                'tingkatan_id' => 1, // Iqra 1
                'judul_materi' => $materiData['judul'],
                'deskripsi' => 'Huruf ' . $materiData['judul'] . ' dalam hijaiyah',
                'urutan' => $materiData['urutan'],
            ]);

            // Create basic module for each materi
            Modul::create([
                'materi_id' => $materi->materi_id,
                'judul_modul' => 'Pengenalan Huruf ' . $materiData['judul'],
                'konten_teks' => 'Belajar menulis dan membaca huruf ' . $materiData['judul'],
                'teks_latin' => $materiData['latin'],
                'urutan' => 1,
            ]);
        }
    }
}
