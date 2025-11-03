<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisGame;

class JenisGameSeeder extends Seeder
{
    public function run()
    {
        $games = [
            [
                'nama_game' => 'Tracking',
                'poin_maksimal' => 100,
                'deskripsi' => 'Menelusuri bentuk huruf hijaiyah'
            ],
            [
                'nama_game' => 'Kuis Drag & Drop',
                'poin_maksimal' => 100,
                'deskripsi' => 'Mencocokkan huruf dengan jawaban yang benar'
            ],
            [
                'nama_game' => 'Labirin',
                'poin_maksimal' => 100,
                'deskripsi' => 'Menemukan jalan keluar dengan huruf yang benar'
            ],
            [
                'nama_game' => 'Memory Card',
                'poin_maksimal' => 100,
                'deskripsi' => 'Mengingat dan mencocokkan pasangan huruf'
            ],
        ];

        foreach ($games as $game) {
            JenisGame::create($game);
        }
    }
}
