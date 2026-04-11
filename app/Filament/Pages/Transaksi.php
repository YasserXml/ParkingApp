<?php

namespace App\Filament\Pages;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use App\Models\Transaksi as TransaksiModel;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Carbon\Carbon;
use Livewire\Attributes\Computed;

class Transaksi extends Page
{
    use HasPageShield;

    protected string $view = 'filament.pages.transaksi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;

    protected static ?int $navigationSort = 1;

    // ─── State: Tab aktif ─────────────────────────────────

    public string $tab = 'aktif'; // aktif | selesai | semua

    // ─── State: Search tabel ──────────────────────────────

    public string $search = '';

    // ─── State: Modal Kendaraan Masuk ─────────────────────

    public bool $showModalMasuk = false;

    // Form masuk
    public string $masuk_plat_nomor   = '';
    public ?int   $masuk_kendaraan_id = null;
    public bool   $masuk_kendaraan_baru = false;
    public string $masuk_jenis_kendaraan = '';
    public string $masuk_warna          = '';
    public string $masuk_pemilik        = '';
    public ?int   $masuk_area_id        = null;
    public string $masuk_tarif_preview  = '';
    public string $masuk_waktu_masuk    = '';

    // ─── State: Modal Cari Kendaraan Keluar ───────────────

    public bool   $showModalCari        = false;
    public string $cari_plat_nomor      = '';
    public ?int   $cari_transaksi_id    = null;

    // ─── State: Slide-over Proses Keluar ──────────────────

    public bool   $showSlideover        = false;
    public ?int   $keluar_transaksi_id  = null;
    public string $keluar_waktu_keluar  = '';

    // ─── Lifecycle ────────────────────────────────────────

    public function mount(): void
    {
        $this->masuk_waktu_masuk  = now()->format('Y-m-d\TH:i');
        $this->keluar_waktu_keluar = now()->format('Y-m-d\TH:i');
    }

    // ─── Computed: Data tabel ─────────────────────────────

    #[Computed]
    public function transaksis()
    {
        $query = TransaksiModel::with(['kendaraan', 'areaParkir'])
            ->when($this->search, function ($q) {
                $q->whereHas('kendaraan', fn ($k) =>
                    $k->where('plat_nomor', 'ilike', "%{$this->search}%")
                      ->orWhere('pemilik', 'ilike', "%{$this->search}%")
                );
            })
            ->when($this->tab === 'aktif',   fn ($q) => $q->aktif())
            ->when($this->tab === 'selesai', fn ($q) => $q->selesai())
            ->latest('waktu_masuk');

        return $query->paginate(10);
    }

    // ─── Computed: Stats ──────────────────────────────────

    #[Computed]
    public function statSedangParkir(): int
    {
        return TransaksiModel::aktif()->count();
    }

    #[Computed]
    public function statMasukHariIni(): int
    {
        return TransaksiModel::hariIni()->count();
    }

    #[Computed]
    public function statPendapatanHariIni(): string
    {
        $total = TransaksiModel::selesai()->hariIni()->sum('total_bayar');

        return 'Rp ' . number_format($total, 0, ',', '.');
    }

    // ─── Computed: Area parkir untuk panel kiri ───────────

    #[Computed]
    public function areaParkirs()
    {
        return AreaParkir::all();
    }

    // ─── Actions: Tab ─────────────────────────────────────

    public function setTab(string $tab): void
    {
        $this->tab    = $tab;
        $this->search = '';
        unset($this->transaksis);
    }

    // ─── Actions: Modal Masuk ─────────────────────────────

    public function bukaModalMasuk(): void
    {
        $this->resetModalMasuk();
        $this->showModalMasuk = true;
    }

    public function tutupModalMasuk(): void
    {
        $this->showModalMasuk = false;
        $this->resetModalMasuk();
    }

    public function resetModalMasuk(): void
    {
        $this->masuk_plat_nomor      = '';
        $this->masuk_kendaraan_id    = null;
        $this->masuk_kendaraan_baru  = false;
        $this->masuk_jenis_kendaraan = '';
        $this->masuk_warna           = '';
        $this->masuk_pemilik         = '';
        $this->masuk_area_id         = null;
        $this->masuk_tarif_preview   = '';
        $this->masuk_waktu_masuk     = now()->format('Y-m-d\TH:i');
    }

    /**
     * Dipanggil saat petugas mengetik plat nomor di modal masuk.
     * Live search ke database.
     */
    public function cariKendaraanMasuk(): void
    {
        $plat = strtoupper(trim($this->masuk_plat_nomor));

        if (strlen($plat) < 2) {
            $this->masuk_kendaraan_id   = null;
            $this->masuk_kendaraan_baru = false;
            return;
        }

        $kendaraan = Kendaraan::scopeCariPlat(Kendaraan::query(), $plat)->first();

        if ($kendaraan) {
            $this->masuk_kendaraan_id    = $kendaraan->id;
            $this->masuk_jenis_kendaraan = $kendaraan->jenis_kendaraan;
            $this->masuk_warna           = $kendaraan->warna;
            $this->masuk_pemilik         = $kendaraan->pemilik;
            $this->masuk_kendaraan_baru  = false;
        } else {
            $this->masuk_kendaraan_id    = null;
            $this->masuk_jenis_kendaraan = '';
            $this->masuk_warna           = '';
            $this->masuk_pemilik         = '';
            $this->masuk_kendaraan_baru  = true;
        }

        // Reset tarif preview saat kendaraan berubah
        $this->masuk_tarif_preview = '';
        $this->hitungTarifPreview();
    }

    /**
     * Dipanggil saat area atau jenis kendaraan berubah.
     * Auto-fill tarif preview.
     */
    public function hitungTarifPreview(): void
    {
        if (! $this->masuk_area_id || ! $this->masuk_jenis_kendaraan) {
            $this->masuk_tarif_preview = '';
            return;
        }

        $area  = AreaParkir::find($this->masuk_area_id);
        $tarif = $area?->getTarifUntuk($this->masuk_jenis_kendaraan);

        $this->masuk_tarif_preview = $tarif
            ? 'Rp ' . number_format($tarif->tarif_per_jam, 0, ',', '.') . '/jam'
            : '⚠ Tarif belum diatur untuk kombinasi ini';
    }

    /**
     * Simpan transaksi kendaraan masuk.
     */
    public function simpanKendaraanMasuk(): void
    {
        $this->validate([
            'masuk_plat_nomor'      => 'required',
            'masuk_jenis_kendaraan' => 'required|in:motor,mobil',
            'masuk_warna'           => 'required',
            'masuk_pemilik'         => 'required',
            'masuk_area_id'         => 'required|exists:area_parkirs,id',
            'masuk_waktu_masuk'     => 'required|date',
        ], [
            'masuk_plat_nomor.required'      => 'Plat nomor wajib diisi.',
            'masuk_jenis_kendaraan.required' => 'Jenis kendaraan wajib dipilih.',
            'masuk_warna.required'           => 'Warna kendaraan wajib diisi.',
            'masuk_pemilik.required'         => 'Nama pemilik wajib diisi.',
            'masuk_area_id.required'         => 'Area parkir wajib dipilih.',
            'masuk_waktu_masuk.required'     => 'Waktu masuk wajib diisi.',
        ]);

        try {
            // Jika kendaraan baru, daftarkan dulu
            if ($this->masuk_kendaraan_baru || ! $this->masuk_kendaraan_id) {
                $kendaraan = Kendaraan::create([
                    'plat_nomor'      => strtoupper(trim($this->masuk_plat_nomor)),
                    'jenis_kendaraan' => $this->masuk_jenis_kendaraan,
                    'warna'           => $this->masuk_warna,
                    'pemilik'         => $this->masuk_pemilik,
                ]);
            } else {
                $kendaraan = Kendaraan::findOrFail($this->masuk_kendaraan_id);
            }

            $area = AreaParkir::findOrFail($this->masuk_area_id);

            // Tangkap return value agar bisa dipakai untuk cetak tiket
            $transaksi = TransaksiModel::prosesKendaraanMasuk(
                kendaraan: $kendaraan,
                area: $area,
                waktuMasuk: Carbon::parse($this->masuk_waktu_masuk),
            );

            $this->tutupModalMasuk();
            unset($this->transaksis, $this->statSedangParkir, $this->statMasukHariIni, $this->areaParkirs);

            // Buka halaman cetak tiket di tab baru
            $this->dispatch('buka-cetak', url: route('print.tiket', $transaksi->id));

            Notification::make()
                ->title('Kendaraan berhasil masuk')
                ->body("Plat {$kendaraan->plat_nomor} — {$area->nama_area}")
                ->success()
                ->send();

        } catch (\RuntimeException $e) {
            Notification::make()
                ->title('Gagal memproses')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    // ─── Actions: Modal Cari Keluar ───────────────────────

    public function bukaModalCari(): void
    {
        $this->cari_plat_nomor   = '';
        $this->cari_transaksi_id = null;
        $this->showModalCari     = true;
        unset($this->transaksiAktifList);
    }

    public function tutupModalCari(): void
    {
        $this->showModalCari     = false;
        $this->cari_plat_nomor   = '';
        $this->cari_transaksi_id = null;
    }

    /**
     * Daftar semua transaksi aktif untuk ditampilkan di select modal cari.
     * Di-filter live berdasarkan input pencarian.
     */
    #[Computed]
    public function transaksiAktifList()
    {
        return TransaksiModel::aktif()
            ->with(['kendaraan', 'areaParkir'])
            ->when($this->cari_plat_nomor, fn ($q) =>
                $q->whereHas('kendaraan', fn ($k) =>
                    $k->where('plat_nomor', 'ilike', "%{$this->cari_plat_nomor}%")
                      ->orWhere('pemilik', 'ilike', "%{$this->cari_plat_nomor}%")
                )
            )
            ->latest('waktu_masuk')
            ->get();
    }

    /**
     * Dipanggil saat user memilih transaksi dari list.
     * Langsung set transaksi yang dipilih.
     */
    public function pilihTransaksiKeluar(int $transaksiId): void
    {
        $this->cari_transaksi_id = $transaksiId;
    }

    /**
     * Lanjut dari modal cari ke slide-over konfirmasi keluar.
     */
    public function lanjutProsesKeluar(): void
    {
        if (! $this->cari_transaksi_id) {
            return;
        }

        $this->keluar_transaksi_id  = $this->cari_transaksi_id;
        $this->keluar_waktu_keluar  = now()->format('Y-m-d\TH:i');
        $this->showModalCari        = false;
        $this->showSlideover        = true;
        unset($this->transaksiKeluar, $this->previewTotalBayar, $this->previewDurasi);
    }

    /**
     * Dipanggil dari tombol "Keluar" di baris tabel.
     * Langsung buka slide-over tanpa modal cari.
     */
    public function prosesKeluarDariTabel(int $transaksiId): void
    {
        $this->keluar_transaksi_id = $transaksiId;
        $this->keluar_waktu_keluar = now()->format('Y-m-d\TH:i');
        $this->showSlideover       = true;
        unset($this->transaksiKeluar, $this->previewTotalBayar, $this->previewDurasi);
    }

    // ─── Actions: Slide-over Keluar ───────────────────────

    public function tutupSlideover(): void
    {
        $this->showSlideover       = false;
        $this->keluar_transaksi_id = null;
        $this->keluar_waktu_keluar = '';
    }

    /**
     * Ambil data transaksi yang sedang diproses keluar.
     */
    #[Computed]
    public function transaksiKeluar(): ?TransaksiModel
    {
        if (! $this->keluar_transaksi_id) {
            return null;
        }

        return TransaksiModel::with(['kendaraan', 'areaParkir'])
            ->find($this->keluar_transaksi_id);
    }

    /**
     * Hitung preview total bayar di slide-over secara real-time.
     */
    #[Computed]
    public function previewTotalBayar(): string
    {
        $transaksi = $this->transaksiKeluar;

        if (! $transaksi || ! $this->keluar_waktu_keluar) {
            return 'Rp 0';
        }

        $masuk     = Carbon::parse($transaksi->waktu_masuk);
        $keluar    = Carbon::parse($this->keluar_waktu_keluar);
        $durasiJam = (int) ceil($masuk->diffInMinutes($keluar) / 60);
        $total     = $durasiJam * (float) $transaksi->tarif;

        return 'Rp ' . number_format($total, 0, ',', '.');
    }

    /**
     * Hitung preview durasi di slide-over.
     */
    #[Computed]
    public function previewDurasi(): string
    {
        $transaksi = $this->transaksiKeluar;

        if (! $transaksi || ! $this->keluar_waktu_keluar) {
            return '—';
        }

        $masuk  = Carbon::parse($transaksi->waktu_masuk);
        $keluar = Carbon::parse($this->keluar_waktu_keluar);
        $menit  = (int) $masuk->diffInMinutes($keluar);
        $jam    = intdiv($menit, 60);
        $sisa   = $menit % 60;

        if ($jam > 0 && $sisa > 0) {
            return "{$jam} jam {$sisa} menit";
        }

        return $jam > 0 ? "{$jam} jam" : "{$menit} menit";
    }

    /**
     * Konfirmasi dan simpan proses kendaraan keluar.
     */
    public function konfirmasiKeluar(): void
    {
        $this->validate([
            'keluar_waktu_keluar' => 'required|date',
        ], [
            'keluar_waktu_keluar.required' => 'Waktu keluar wajib diisi.',
        ]);

        try {
            $transaksi = TransaksiModel::with(['kendaraan', 'areaParkir'])
                ->findOrFail($this->keluar_transaksi_id);
            $transaksi->prosesKendaraanKeluar(Carbon::parse($this->keluar_waktu_keluar));

            unset($this->transaksis, $this->transaksiKeluar, $this->previewTotalBayar, $this->previewDurasi);
            unset($this->statSedangParkir, $this->statPendapatanHariIni, $this->areaParkirs);

            $this->tutupSlideover();

            // Buka halaman cetak struk di tab baru
            $this->dispatch('buka-cetak', url: route('print.struk', $transaksi->id));

            Notification::make()
                ->title('Kendaraan berhasil keluar')
                ->body("Plat {$transaksi->kendaraan->plat_nomor} — Total: Rp " . number_format($transaksi->total_bayar, 0, ',', '.'))
                ->success()
                ->send();

        } catch (\RuntimeException $e) {
            Notification::make()
                ->title('Gagal memproses')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
