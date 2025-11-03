<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriPembelajaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'materi_id';

    protected $fillable = [
        'tingkatan_id',
        'judul_materi',
        'deskripsi',
        'urutan',
    ];

    public function tingkatanIqra()
    {
        return $this->belongsTo(TingkatanIqra::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function moduls()
    {
        return $this->hasMany(Modul::class, 'materi_id', 'materi_id');
    }
}
