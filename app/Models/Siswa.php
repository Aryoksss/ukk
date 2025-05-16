<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nama',
        'nis',
        'gender',
        'alamat',
        'kontak',
        'email',
        'foto',
        'status_lapor_pkl',
        'user_id',
    ];
    
    protected $attributes = [
        'status_lapor_pkl' => 'False', // Default "Belum Melapor"
    ];
    
    protected $casts = [
        'status_lapor_pkl' => 'string',
    ];

    /**
     * Boot method untuk model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Saat model diambil dari database
        static::retrieved(function ($siswa) {
            // Cek apakah siswa memiliki data PKL
            if ($siswa->pkl()->exists() && $siswa->status_lapor_pkl !== 'True') {
                $siswa->status_lapor_pkl = 'True';
                $siswa->saveQuietly();
            }
        });
    }

    public function pkl(): HasOne
    {
        return $this->hasOne(Pkl::class, 'siswa_id');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // Accessor untuk memastikan status_lapor_pkl selalu memiliki nilai
    public function getStatusLaporPklAttribute($value)
    {
        if ($value === null) {
            return 'False';
        }
        
        // Normalisasi nilai-nilai lama
        if ($value === '0') {
            return 'False';
        } elseif ($value === '1') {
            return 'True';
        }
        
        return $value;
    }
}
