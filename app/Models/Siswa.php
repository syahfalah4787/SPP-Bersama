<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nisn',
        'nis',
        'nama',
        'alamat',
        'no_telp',
        'id_kelas',
        'id_spp',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'nisn';
    }

    /**
     * Get the class for this student.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    /**
     * Get the SPP rate for this student.
     */
    public function spp(): BelongsTo
    {
        return $this->belongsTo(Spp::class, 'id_spp');
    }

    /**
     * Get all payments for this student.
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'nisn', 'nisn');
    }

    /**
     * Get paid months for a given year.
     */
    public function getPaidMonths(string $year): array
    {
        return $this->pembayaran()
            ->where('tahun_bayar', $year)
            ->pluck('bulan_bayar')
            ->toArray();
    }
}
