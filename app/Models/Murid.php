<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    protected $primaryKey = 'murid_id';

    protected $fillable = [
        'user_id',
        'mentor_id',
        'sekolah',
        'preferensi_terisi',
    ];

    protected $casts = [
        'preferensi_terisi' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id', 'mentor_id');
    }

    public function hasilGames()
    {
        return $this->hasMany(HasilGame::class, 'murid_id', 'murid_id');
    }

    public function progressModuls()
    {
        return $this->hasMany(ProgressModul::class, 'murid_id', 'murid_id');
    }

    public function leaderboards()
    {
        return $this->hasMany(Leaderboard::class, 'murid_id', 'murid_id');
    }

    public function preferensiPertanyaan()
    {
        return $this->hasOne(PreferensiPertanyaan::class, 'murid_id', 'murid_id');
    }

    public function permintaanBimbingans()
    {
        return $this->hasMany(PermintaanBimbingan::class, 'murid_id', 'murid_id');
    }

    // Helper methods
    public function getTotalPoinAttribute()
    {
        return $this->hasilGames()->sum('total_poin');
    }

    public function hasMentor()
    {
        return !is_null($this->mentor_id);
    }
}
