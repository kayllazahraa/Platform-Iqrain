<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameStatic extends Model
{
    use HasFactory;

    protected $primaryKey = 'game_static_id';

    protected $fillable = [
        'tingkatan_id',
        'jenis_game_id',
        'nama_game',
        'data_json',
    ];

    protected $casts = [
        'data_json' => 'array',
    ];

    public function tingkatanIqra()
    {
        return $this->belongsTo(TingkatanIqra::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function jenisGame()
    {
        return $this->belongsTo(JenisGame::class, 'jenis_game_id', 'jenis_game_id');
    }

    public function hasilGames()
    {
        return $this->hasMany(HasilGame::class, 'game_static_id', 'game_static_id');
    }
}
