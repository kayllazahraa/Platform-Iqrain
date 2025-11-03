<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;

    protected $primaryKey = 'leaderboard_id';

    protected $fillable = [
        'murid_id',
        'mentor_id',
        'total_poin_semua_game',
        'ranking_global',
        'ranking_mentor',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id', 'murid_id');
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id', 'mentor_id');
    }

    // Scopes
    public function scopeGlobal($query)
    {
        return $query->whereNull('mentor_id');
    }

    public function scopeByMentor($query, $mentorId)
    {
        return $query->where('mentor_id', $mentorId);
    }

    public function scopeTopRanking($query, $limit = 10)
    {
        return $query->orderBy('ranking_global')->limit($limit);
    }
}
