<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spp extends Model
{
    use HasFactory;

    protected $table = 'spp';

    protected $fillable = [
        'tahun',
        'nominal',
    ];

    /**
     * Get all students with this SPP rate.
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'id_spp');
    }

    /**
     * Get all payments using this SPP rate.
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_spp');
    }

    /**
     * Get formatted nominal.
     */
    public function getFormattedNominalAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }
}
