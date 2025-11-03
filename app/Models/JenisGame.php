<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisGame extends Model
{
    use HasFactory;

    protected $primaryKey = 'jenis_game_id';

    protected $fillable = [
        'nama_game',
        'poin_maksimal',
        'deskripsi',
    ];

    public function gameStatics()
    {
        return $this->hasMany(GameStatic::class, 'jenis_game_id', 'jenis_game_id');
    }

    public function hasilGames()
    {
        return $this->hasMany(HasilGame::class, 'jenis_game_id', 'jenis_game_id');
    }
}
