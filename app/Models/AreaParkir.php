<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AreaParkir extends Model
{
    protected $fillable = [
        'nama_area',
        'kapasitas',
        'terisi',
    ];

    protected $casts = [
        'kapasitas' => 'integer',
        'terisi'    => 'integer',
    ];


    public function tarifs(): HasMany
    {
        return $this->hasMany(Tarif::class, 'area_id');
    }

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'area_id');
    }

    /**
     * Transaksi yang masih aktif di area ini.
     */
    public function transaksiAktif(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'area_id')
            ->where('status', 'masuk');
    }


    /**
     * Hanya area yang masih tersedia (belum penuh).
     */
    public function scopeTersedia($query)
    {
        return $query->whereColumn('terisi', '<', 'kapasitas');
    }

    /**
     * Area yang sudah penuh.
     */
    public function scopePenuh($query)
    {
        return $query->whereColumn('terisi', '>=', 'kapasitas');
    }

    /**
     * Slot yang masih tersedia.
     */
    public function getSisaSlotAttribute(): int
    {
        return max(0, ($this->kapasitas ?? 0) - ($this->terisi ?? 0));
    }

    /**
     * Persentase kepadatan area (0–100).
     */
    public function getPersentaseTerisiAttribute(): float
    {
        if (! $this->kapasitas || $this->kapasitas === 0) {
            return 0;
        }

        return round(($this->terisi / $this->kapasitas) * 100, 1);
    }

    /**
     * Status kepadatan area: tersedia | padat | penuh
     */
    public function getStatusKepadatanAttribute(): string
    {
        $persen = $this->persentase_terisi;

        return match (true) {
            $persen >= 100          => 'penuh',
            $persen >= 80           => 'padat',
            default                 => 'tersedia',
        };
    }

    /**
     * Warna badge sesuai status kepadatan (untuk Filament).
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status_kepadatan) {
            'penuh'    => 'danger',
            'padat'    => 'warning',
            'tersedia' => 'success',
            default    => 'gray',
        };
    }

    /**
     * Apakah area masih bisa menerima kendaraan.
     */
    public function getMasihTersediaAttribute(): bool
    {
        return $this->sisa_slot > 0;
    }

    /**
     * Tambah jumlah kendaraan terisi (+1).
     * Dipanggil saat kendaraan masuk.
     */
    public function tambahKendaraan(): void
    {
        $this->increment('terisi');
    }

    /**
     * Kurangi jumlah kendaraan terisi (-1).
     * Dipanggil saat kendaraan keluar.
     */
    public function kurangiKendaraan(): void
    {
        if ($this->terisi > 0) {
            $this->decrement('terisi');
        }
    }

    /**
     * Ambil tarif untuk jenis kendaraan tertentu di area ini.
     */
    public function getTarifUntuk(string $jenisKendaraan): ?Tarif
    {
        return $this->tarifs()
            ->where('jenis_kendaraan', $jenisKendaraan)
            ->first();
    }
}
