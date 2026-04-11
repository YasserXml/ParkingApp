<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarif extends Model
{
    protected $fillable = [
        'area_id',
        'jenis_kendaraan',
        'tarif_per_jam',
    ];

    protected $casts = [
        'tarif_per_jam' => 'decimal:2',
    ];


    public function areaParkir(): BelongsTo
    {
        return $this->belongsTo(AreaParkir::class, 'area_id');
    }


    /**
     * Cari tarif berdasarkan area dan jenis kendaraan.
     * Digunakan saat kendaraan masuk untuk snapshot tarif.
     */
    public function scopeUntukKendaraan($query, int $areaParkirId, string $jenisKendaraan)
    {
        return $query
            ->where('area_id', $areaParkirId)
            ->where('jenis_kendaraan', $jenisKendaraan);
    }

    /**
     * Format tarif ke rupiah untuk ditampilkan di UI.
     * Contoh: 5000 → "Rp 5.000/jam"
     */
    public function getTarifFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->tarif_per_jam, 0, ',', '.') . '/jam';
    }

    /**
     * Label jenis kendaraan yang lebih ramah untuk UI.
     */
    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis_kendaraan) {
            'motor' => ' Motor',
            'mobil' => ' Mobil',
            default => ucfirst($this->jenis_kendaraan),
        };
    }
}
