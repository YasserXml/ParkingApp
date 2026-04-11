<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    protected $fillable = [
        'judul',
        'jenis_laporan',
        'periode_dari',
        'periode_sampai',
        'area_id',
        'total_transaksi',
        'total_kendaraan_masuk',
        'total_kendaraan_keluar',
        'total_pendapatan',
        'rata_rata_durasi_menit',
        'ringkasan_per_jenis',
        'ringkasan_per_area',
        'generated_at',
        'generated_by',
    ];

    protected $casts = [
        'periode_dari'          => 'date',
        'periode_sampai'        => 'date',
        'total_pendapatan'      => 'decimal:2',
        'rata_rata_durasi_menit' => 'decimal:2',
        'ringkasan_per_jenis'   => 'array',
        'ringkasan_per_area'    => 'array',
        'generated_at'          => 'datetime',
    ];


    /**
     * Area parkir yang dilaporkan (null = semua area).
     */
    public function areaParkir(): BelongsTo
    {
        return $this->belongsTo(AreaParkir::class, 'area_id');
    }


    public function scopeHarian($query)
    {
        return $query->where('jenis_laporan', 'harian');
    }

    public function scopeBulanan($query)
    {
        return $query->where('jenis_laporan', 'bulanan');
    }

    public function scopeUntukArea($query, int $areaId)
    {
        return $query->where('area_id', $areaId);
    }

    public function scopeSemuaArea($query)
    {
        return $query->whereNull('area_id');
    }

    /**
     * Laporan dalam bulan tertentu.
     */
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('periode_dari', now()->month)
            ->whereYear('periode_dari',  now()->year);
    }


    /**
     * Format total pendapatan ke rupiah.
     * Contoh: 430000 → "Rp 430.000"
     */
    public function getTotalPendapatanFormatAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->total_pendapatan, 0, ',', '.');
    }

    /**
     * Format rata-rata durasi parkir ke teks ramah.
     * Contoh: 95.5 menit → "1 jam 35 menit"
     */
    public function getRataRataDurasiFormatAttribute(): string
    {
        $menit = (int) $this->rata_rata_durasi_menit;
        $jam   = intdiv($menit, 60);
        $sisa  = $menit % 60;

        if ($jam > 0 && $sisa > 0) {
            return "{$jam} jam {$sisa} menit";
        }

        return $jam > 0 ? "{$jam} jam" : "{$menit} menit";
    }

    /**
     * Format rentang periode untuk ditampilkan.
     * Contoh: "1 Apr 2025 – 30 Apr 2025"
     */
    public function getPeriodeFormatAttribute(): string
    {
        $dari    = $this->periode_dari->translatedFormat('d M Y');
        $sampai  = $this->periode_sampai->translatedFormat('d M Y');

        return $dari === $sampai ? $dari : "{$dari} – {$sampai}";
    }

    /**
     * Persentase kendaraan yang sudah keluar vs masuk.
     */
    public function getPersentaseKeluarAttribute(): float
    {
        if ($this->total_kendaraan_masuk === 0) {
            return 0;
        }

        return round(($this->total_kendaraan_keluar / $this->total_kendaraan_masuk) * 100, 1);
    }


    /**
     * Generate laporan harian untuk tanggal tertentu.
     *
     * @param  Carbon        $tanggal
     * @param  AreaParkir|null $area   null = semua area
     * @return static
     */
    public static function generateHarian(Carbon $tanggal, ?AreaParkir $area = null): static
    {
        $query = Transaksi::hariIni()
            ->when($area, fn($q) => $q->where('area_id', $area->id));

        return static::buatDariQuery(
            query: $query,
            judul: 'Laporan Harian ' . $tanggal->translatedFormat('d F Y'),
            jenisLaporan: 'harian',
            dari: $tanggal->copy()->startOfDay(),
            sampai: $tanggal->copy()->endOfDay(),
            area: $area,
        );
    }

    /**
     * Generate laporan bulanan.
     *
     * @param  int           $bulan  1–12
     * @param  int           $tahun
     * @param  AreaParkir|null $area
     * @return static
     */
    public static function generateBulanan(int $bulan, int $tahun, ?AreaParkir $area = null): static
    {
        $dari   = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $sampai = $dari->copy()->endOfMonth();

        $query = Transaksi::rentangTanggal($dari, $sampai)
            ->when($area, fn($q) => $q->where('area_id', $area->id));

        return static::buatDariQuery(
            query: $query,
            judul: 'Laporan Bulanan ' . $dari->translatedFormat('F Y'),
            jenisLaporan: 'bulanan',
            dari: $dari,
            sampai: $sampai,
            area: $area,
        );
    }

    /**
     * Generate laporan rentang tanggal kustom.
     */
    public static function generateKustom(
        Carbon $dari,
        Carbon $sampai,
        ?AreaParkir $area = null
    ): static {
        $query = Transaksi::rentangTanggal($dari, $sampai)
            ->when($area, fn($q) => $q->where('area_id', $area->id));

        return static::buatDariQuery(
            query: $query,
            judul: 'Laporan ' . $dari->translatedFormat('d M Y') . ' – ' . $sampai->translatedFormat('d M Y'),
            jenisLaporan: 'custom',
            dari: $dari,
            sampai: $sampai,
            area: $area,
        );
    }

    /**
     * Inti kalkulasi: hitung semua agregat dari query transaksi
     * lalu simpan sebagai record Laporan baru.
     */
    protected static function buatDariQuery(
        $query,
        string $judul,
        string $jenisLaporan,
        Carbon $dari,
        Carbon $sampai,
        ?AreaParkir $area,
    ): static {
        // Ambil semua transaksi selesai untuk dihitung
        $transaksis = (clone $query)->selesai()->with(['kendaraan', 'areaParkir'])->get();
        $semua      = (clone $query)->get();

        // ── Agregat utama ──────────────────────────────────────────────
        $totalMasuk  = $semua->count();
        $totalKeluar = $transaksis->count();
        $pendapatan  = $transaksis->sum('total_bayar');
        $rataRata    = $transaksis->avg(fn($t) => $t->durasi_menit) ?? 0;

        // ── Ringkasan per jenis kendaraan ──────────────────────────────
        $perJenis = $transaksis
            ->groupBy(fn($t) => $t->kendaraan->jenis_kendaraan ?? 'unknown')
            ->map(fn($grup, $jenis) => [
                'masuk'      => $semua->filter(fn($t) => ($t->kendaraan->jenis_kendaraan ?? '') === $jenis)->count(),
                'keluar'     => $grup->count(),
                'pendapatan' => (float) $grup->sum('total_bayar'),
            ])
            ->toArray();

        // ── Ringkasan per area (hanya jika laporan semua area) ─────────
        $perArea = null;
        if (! $area) {
            $perArea = $transaksis
                ->groupBy('area_id')
                ->map(fn($grup) => [
                    'area_id'          => $grup->first()->area_id,
                    'nama_area'        => $grup->first()->areaParkir?->nama_area ?? '-',
                    'total_transaksi'  => $grup->count(),
                    'pendapatan'       => (float) $grup->sum('total_bayar'),
                ])
                ->values()
                ->toArray();
        }

        return static::create([
            'judul'                   => $judul,
            'jenis_laporan'           => $jenisLaporan,
            'periode_dari'            => $dari->toDateString(),
            'periode_sampai'          => $sampai->toDateString(),
            'area_id'                 => $area?->id,
            'total_transaksi'         => $totalMasuk,
            'total_kendaraan_masuk'   => $totalMasuk,
            'total_kendaraan_keluar'  => $totalKeluar,
            'total_pendapatan'        => $pendapatan,
            'rata_rata_durasi_menit'  => round($rataRata, 2),
            'ringkasan_per_jenis'     => $perJenis,
            'ringkasan_per_area'      => $perArea,
            'generated_at'            => now(),
        ]);
    }
}
