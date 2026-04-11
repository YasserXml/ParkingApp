<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kendaraan extends Model
{
    protected $fillable = [
        'plat_nomor',
        'jenis_kendaraan',
        'warna',
        'pemilik',
    ];

    protected $casts = [
        'jenis_kendaraan' => 'string',
    ];


    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'kendaraan_id');
    }

    /**
     * Transaksi yang sedang aktif (kendaraan masih di dalam).
     */
    public function transaksiAktif(): HasOne
    {
        return $this->hasOne(Transaksi::class, 'kendaraan_id')
            ->where('status', 'masuk')
            ->latestOfMany();
    }

    /**
     * Filter by jenis kendaraan.
     */
    public function scopeMotor($query)
    {
        return $query->where('jenis_kendaraan', 'motor');
    }

    public function scopeMobil($query)
    {
        return $query->where('jenis_kendaraan', 'mobil');
    }

    /**
     * Cari kendaraan by plat nomor (case-insensitive).
     */
    public function scopeCariPlat($query, string $plat)
    {
        return $query->whereRaw('LOWER(plat_nomor) = ?', [strtolower(trim($plat))]);
    }


    /**
     * Cek apakah kendaraan sedang parkir.
     */
    public function getSedangParkirAttribute(): bool
    {
        return $this->transaksis()
            ->where('status', 'masuk')
            ->exists();
    }

    /**
     * Label jenis kendaraan yang ramah untuk UI.
     */
    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis_kendaraan) {
            'motor' => '🛵 Motor',
            'mobil' => '🚗 Mobil',
            default => ucfirst($this->jenis_kendaraan),
        };
    }

    /**
     * Format plat nomor ke uppercase.
     */
    public function getPlatNomorFormatAttribute(): string
    {
        return strtoupper($this->plat_nomor);
    }
}
