<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'nama',
        'nip',
        'gender',
        'alamat',
        'kontak',
        'email',
    ];

    public function industris(): HasMany
    {
        return $this->hasMany(Industri::class, 'guru_id');
    }
}
