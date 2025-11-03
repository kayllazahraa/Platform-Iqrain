<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TingkatanIqra;

class TingkatanIqraSeeder extends Seeder
{
    public function run()
    {
        $tingkatans = [
            [
                'level' => 1,
                'nama_tingkatan' => 'Iqra 1',
                'deskripsi' => 'Pengenalan huruf hijaiyah dasar'
            ],
            [
                'level' => 2,
                'nama_tingkatan' => 'Iqra 2',
                'deskripsi' => 'Huruf hijaiyah dengan harakat'
            ],
            [
                'level' => 3,
                'nama_tingkatan' => 'Iqra 3',
                'deskripsi' => 'Penggabungan huruf sederhana'
            ],
            [
                'level' => 4,
                'nama_tingkatan' => 'Iqra 4',
                'deskripsi' => 'Kata-kata pendek'
            ],
            [
                'level' => 5,
                'nama_tingkatan' => 'Iqra 5',
                'deskripsi' => 'Kalimat sederhana'
            ],
            [
                'level' => 6,
                'nama_tingkatan' => 'Iqra 6',
                'deskripsi' => 'Bacaan Al-Qur\'an dasar'
            ],
        ];

        foreach ($tingkatans as $tingkatan) {
            TingkatanIqra::create($tingkatan);
        }
    }
}
