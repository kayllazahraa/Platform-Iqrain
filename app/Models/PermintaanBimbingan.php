<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBimbingan extends Model
{
    use HasFactory;

    protected $primaryKey = 'permintaan_id';

    protected $fillable = [
        'murid_id',
        'mentor_id',
        'status',
        'tanggal_permintaan',
        'tanggal_respons',
        'catatan',
    ];

    protected $casts = [
        'tanggal_permintaan' => 'datetime',
        'tanggal_respons' => 'datetime',
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
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
