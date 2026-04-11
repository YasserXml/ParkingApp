<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $fillable = [
        'kendaraan_id',
        'area_id',
        'waktu_masuk',
        'waktu_keluar',
        'tarif',
        'total_bayar',
        'status',
    ];

    protected $casts = [
        'waktu_masuk'  => 'datetime',
        'waktu_keluar' => 'datetime',
        'tarif'        => 'decimal:2',
        'total_bayar'  => 'decimal:2',
    ];


    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function areaParkir(): BelongsTo
    {
        return $this->belongsTo(AreaParkir::class, 'area_id');
    }


    /**
     * Transaksi yang masih aktif (kendaraan belum keluar).
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'masuk');
    }

    /**
     * Transaksi yang sudah selesai (kendaraan sudah keluar).
     */
    public function scopeSelesai($query)
    {
        return $query->where('status', 'keluar');
    }

    /**
     * Transaksi hari ini.
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('waktu_masuk', today());
    }

    /**
     * Transaksi dalam rentang tanggal tertentu.
     */
    public function scopeRentangTanggal($query, Carbon $dari, Carbon $sampai)
    {
        return $query->whereBetween('waktu_masuk', [$dari->startOfDay(), $sampai->endOfDay()]);
    }

    /**
     * Hitung durasi parkir dalam menit.
     * Jika masih aktif, hitung dari waktu masuk sampai sekarang.
     */
    public function getDurasiMenitAttribute(): int
    {
        $masuk   = Carbon::parse($this->waktu_masuk);
        $selesai = $this->waktu_keluar ? Carbon::parse($this->waktu_keluar) : now();

        return (int) $masuk->diffInMinutes($selesai);
    }

    /**
     * Hitung durasi dalam jam — dibulatkan ke atas.
     * Contoh: 2 jam 5 menit → 3 jam (yang dipakai untuk hitung biaya).
     */
    public function getDurasiJamAttribute(): int
    {
        return (int) ceil($this->durasi_menit / 60);
    }

    /**
     * Format durasi yang ramah untuk ditampilkan di UI.
     * Contoh: "2 jam 35 menit" atau "45 menit"
     */
    public function getDurasiFormatAttribute(): string
    {
        $menit = $this->durasi_menit;
        $jam   = intdiv($menit, 60);
        $sisa  = $menit % 60;

        if ($jam > 0 && $sisa > 0) {
            return "{$jam} jam {$sisa} menit";
        }

        if ($jam > 0) {
            return "{$jam} jam";
        }

        return "{$menit} menit";
    }

    /**
     * Hitung total bayar berdasarkan durasi (jam, dibulatkan ke atas) × tarif.
     * Digunakan untuk preview sebelum konfirmasi keluar.
     */
    public function getHitungTotalBayarAttribute(): float
    {
        return $this->durasi_jam * (float) $this->tarif;
    }

    /**
     * Format tarif ke rupiah.
     * Contoh: 5000 → "Rp 5.000/jam"
     */
    public function getTarifFormatAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->tarif, 0, ',', '.') . '/jam';
    }

    /**
     * Format total bayar ke rupiah.
     * Contoh: 20000 → "Rp 20.000"
     */
    public function getTotalBayarFormatAttribute(): string
    {
        $nilai = $this->total_bayar ?? $this->hitung_total_bayar;

        return 'Rp ' . number_format((float) $nilai, 0, ',', '.');
    }

    /**
     * Apakah transaksi ini masih aktif.
     */
    public function getMasihAktifAttribute(): bool
    {
        return $this->status === 'masuk';
    }

    /**
     * Warna badge status untuk Filament.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'masuk'  => 'success',
            'keluar' => 'gray',
            default  => 'gray',
        };
    }

    /**
     * Label status yang ramah untuk UI.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'masuk'  => 'Sedang Parkir',
            'keluar' => 'Selesai',
            default  => ucfirst($this->status),
        };
    }

    // ─── Business Logic Methods ───────────────────────────

    /**
     * Proses kendaraan masuk.
     * - Simpan waktu masuk
     * - Snapshot tarif dari tabel tarif
     * - Increment terisi di area parkir
     *
     * @param  Kendaraan  $kendaraan
     * @param  AreaParkir $area
     * @return static
     */
    public static function prosesKendaraanMasuk(
        Kendaraan $kendaraan,
        AreaParkir $area,
        ?Carbon $waktuMasuk = null
    ): static {
        // Cek area masih tersedia
        if (! $area->masih_tersedia) {
            throw new \RuntimeException("Area parkir {$area->nama_area} sudah penuh.");
        }

        // Lookup & snapshot tarif
        $tarif = $area->getTarifUntuk($kendaraan->jenis_kendaraan);

        if (! $tarif) {
            throw new \RuntimeException(
                "Tarif untuk {$kendaraan->jenis_kendaraan} di area {$area->nama_area} belum diatur."
            );
        }

        // Simpan transaksi
        $transaksi = static::create([
            'kendaraan_id' => $kendaraan->id,
            'area_id'      => $area->id,
            'waktu_masuk'  => $waktuMasuk ?? now(),
            'tarif'        => $tarif->tarif_per_jam,
            'status'       => 'masuk',
        ]);

        // Increment slot terisi di area
        $area->tambahKendaraan();

        return $transaksi;
    }

    /**
     * Proses kendaraan keluar.
     * - Catat waktu keluar
     * - Hitung & simpan total bayar
     * - Decrement terisi di area parkir
     * - Update status ke 'keluar'
     *
     * @param  Carbon|null $waktuKeluar
     * @return $this
     */
    public function prosesKendaraanKeluar(?Carbon $waktuKeluar = null): static
    {
        if ($this->status === 'keluar') {
            throw new \RuntimeException('Transaksi ini sudah selesai.');
        }

        $this->waktu_keluar = $waktuKeluar ?? now();

        // Hitung total bayar berdasarkan durasi jam (dibulatkan ke atas) × tarif
        $masuk     = Carbon::parse($this->waktu_masuk);
        $keluar    = Carbon::parse($this->waktu_keluar);
        $durasiJam = (int) ceil($masuk->diffInMinutes($keluar) / 60);
        $this->total_bayar = $durasiJam * (float) $this->tarif;
        $this->status      = 'keluar';

        $this->save();

        // Decrement slot terisi di area
        $this->areaParkir->kurangiKendaraan();

        return $this;
    }
}
