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

    // relasi dengan pkl
    public function pkls()
    {
        return $this->hasMany(Pkl::class);
    }
}
