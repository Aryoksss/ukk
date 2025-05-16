<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Industri extends Model
{
    use HasFactory;

    protected $table = 'industris';

    protected $fillable = [
        'nama',
        'bidang_usaha',
        'alamat',
        'kontak',
        'email',
        'website',
        'guru_id',
    ];

    public function setWebsiteAttribute($value)
    {
        if ($value) {
            // Hapus http:// atau https:// jika ada
            $this->attributes['website'] = preg_replace('#^https?://#', '', $value);
        } else {
            $this->attributes['website'] = null;
        }
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function pkls(): HasMany
    {
        return $this->hasMany(Pkl::class, 'industri_id');
    }
}
