<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'id_petugas',
        'nisn',
        'tgl_bayar',
        'bulan_bayar',
        'tahun_bayar',
        'id_spp',
        'jumlah_bayar',
    ];

    protected function casts(): array
    {
        return [
            'tgl_bayar' => 'date',
        ];
    }

    /**
     * Get the officer who processed this payment.
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }

    /**
     * Get the student for this payment.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'nisn', 'nisn');
    }

    /**
     * Get the SPP rate for this payment.
     */
    public function spp(): BelongsTo
    {
        return $this->belongsTo(Spp::class, 'id_spp');
    }

    /**
     * Get formatted payment amount.
     */
    public function getFormattedJumlahAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah_bayar, 0, ',', '.');
    }
}
