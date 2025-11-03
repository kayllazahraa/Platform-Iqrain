<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TingkatanIqra extends Model
{
    use HasFactory;

    protected $primaryKey = 'tingkatan_id';

    protected $fillable = [
        'level',
        'nama_tingkatan',
        'deskripsi',
    ];

    public function materiPembelajarans()
    {
        return $this->hasMany(MateriPembelajaran::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function videoPembelajarans()
    {
        return $this->hasMany(VideoPembelajaran::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function gameStatics()
    {
        return $this->hasMany(GameStatic::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function soalDragDrops()
    {
        return $this->hasMany(SoalDragDrop::class, 'tingkatan_id', 'tingkatan_id');
    }
}
