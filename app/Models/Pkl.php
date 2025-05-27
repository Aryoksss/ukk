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
        'guru_id',
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

    // relasi dengan guru
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // relasi dengan industri
    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }

    // relasi dengan siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
