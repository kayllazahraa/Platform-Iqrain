<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalDragDrop extends Model
{
    use HasFactory;

    protected $primaryKey = 'soal_id';

    protected $fillable = [
        'tingkatan_id',
        'mentor_id',
        'admin_id',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawaban_benar',
        'status_approval',
    ];

    public function tingkatanIqra()
    {
        return $this->belongsTo(TingkatanIqra::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id', 'mentor_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    public function hasilGames()
    {
        return $this->hasMany(HasilGame::class, 'soal_id', 'soal_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status_approval', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status_approval', 'pending');
    }
}
