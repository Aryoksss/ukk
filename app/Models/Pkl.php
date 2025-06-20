<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Pkl extends Model
{
    use HasFactory;

    protected $table = 'pkls';

    protected $fillable = [
        'siswa_id',
        'industri_id',
        'mulai',
        'selesai',
    ];

    protected $casts = [
        'mulai' => 'date',
        'selesai' => 'date',
    ];
    
    // Accessor untuk mendapatkan tanggal mulai dalam format Indonesia
    public function getMulaiIndonesiaAttribute()
    {
        return $this->mulai ? Carbon::parse($this->mulai)->locale('id')->isoFormat('DD MMMM YYYY') : null;
    }
    
    // Accessor untuk mendapatkan tanggal selesai dalam format Indonesia
    public function getSelesaiIndonesiaAttribute()
    {
        return $this->selesai ? Carbon::parse($this->selesai)->locale('id')->isoFormat('DD MMMM YYYY') : null;
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function industri(): BelongsTo
    {
        return $this->belongsTo(Industri::class, 'industri_id');
    }
}
