<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nama',
        'nis',
        'rombel',
        'gender',
        'alamat',
        'kontak',
        'email',
        'foto',
        'status_lapor_pkl',
    ];

    public function pkl()
    {
        return $this->hasMany(Pkl::class);
    }    
}
