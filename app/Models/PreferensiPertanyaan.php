<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiPertanyaan extends Model
{
    use HasFactory;

    protected $primaryKey = 'preferensi_id';

    protected $fillable = [
        'murid_id',
        'pertanyaan_1',
        'jawaban_1',
        'pertanyaan_2',
        'jawaban_2',
        'pertanyaan_3',
        'jawaban_3',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id', 'murid_id');
    }

    public function verifyAnswers($answers)
    {
        $correctCount = 0;

        if (strtolower($answers[0]) === strtolower($this->jawaban_1)) {
            $correctCount++;
        }
        if (strtolower($answers[1]) === strtolower($this->jawaban_2)) {
            $correctCount++;
        }
        if (strtolower($answers[2]) === strtolower($this->jawaban_3)) {
            $correctCount++;
        }

        return $correctCount >= 2; 
    }
}
