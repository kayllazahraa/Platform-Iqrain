<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;

    protected $primaryKey = 'modul_id';

    protected $fillable = [
        'materi_id',
        'judul_modul',
        'konten_teks',
        'gambar_path',
        'teks_latin',
        'urutan',
    ];

    public function materiPembelajaran()
    {
        return $this->belongsTo(MateriPembelajaran::class, 'materi_id', 'materi_id');
    }

    public function progressModuls()
    {
        return $this->hasMany(ProgressModul::class, 'modul_id', 'modul_id');
    }

    public function getGambarUrlAttribute()
    {
        return $this->gambar_path ? asset('storage/' . $this->gambar_path) : null;
    }
}
