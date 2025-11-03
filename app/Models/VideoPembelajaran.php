<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPembelajaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'video_id';

    protected $fillable = [
        'tingkatan_id',
        'judul_video',
        'video_path',
        'subtitle_path',
        'deskripsi',
    ];

    public function tingkatanIqra()
    {
        return $this->belongsTo(TingkatanIqra::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function getVideoUrlAttribute()
    {
        return $this->video_path ? asset('storage/' . $this->video_path) : null;
    }

    public function getSubtitleUrlAttribute()
    {
        return $this->subtitle_path ? asset('storage/' . $this->subtitle_path) : null;
    }
}
