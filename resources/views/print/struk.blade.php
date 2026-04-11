<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Keluar — {{ strtoupper($transaksi->kendaraan->plat_nomor) }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Source+Sans+3:wght@400;600;700;900&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Source Sans 3', sans-serif;
            padding: 2rem;
        }

        .struk-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        /* ── Struk Container ─────────────────────── */
        .struk {
            width: 360px;
            background: #fff;
            border: 3px solid #000;
            box-shadow: 6px 6px 0 #000;
            overflow: hidden;
        }

        /* ── Header ────────────────────────────────── */
        .struk-header {
            background: #000;
            color: #fff;
            padding: 18px 20px;
            text-align: center;
        }
        .struk-header-title {
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #9ca3af;
        }
        .struk-header-org {
            font-family: 'Oswald', sans-serif;
            font-size: 22px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 2px;
        }
        .struk-header-sub {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            margin-top: 4px;
        }

        /* ── Divider ─────────────────────────────── */
        .divider {
            border: none;
            border-top: 2px dashed #000;
            margin: 0;
        }
        .divider-solid {
            border: none;
            border-top: 3px solid #000;
            margin: 0;
        }

        /* ── Body ────────────────────────────────── */
        .struk-body { padding: 16px 20px; }

        .struk-meta {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 14px;
        }

        /* Plat box */
        .plat-center {
            text-align: center;
            border: 3px solid #000;
            padding: 10px;
            margin-bottom: 14px;
            background: #f9fafb;
        }
        .plat-center-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #9ca3af;
            margin-bottom: 3px;
        }
        .plat-center-value {
            font-family: 'Oswald', sans-serif;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.12em;
        }
        .plat-center-pemilik {
            font-size: 12px;
            font-weight: 700;
            color: #374151;
            margin-top: 3px;
        }

        /* Row items */
        .struk-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 7px 0;
            border-bottom: 1px dashed #e5e7eb;
        }
        .struk-row:last-child { border-bottom: none; }
        .struk-row-label {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .struk-row-value {
            font-size: 12px;
            font-weight: 700;
            text-align: right;
        }

        /* ── Total Box ───────────────────────────── */
        .total-box {
            background: #000;
            color: #fff;
            padding: 16px 20px;
            text-align: center;
        }
        .total-label {
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #9ca3af;
        }
        .total-value {
            font-family: 'Oswald', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: #4ade80;
            line-height: 1.1;
            margin-top: 4px;
        }
        .total-detail {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            margin-top: 6px;
        }

        /* ── Footer ──────────────────────────────── */
        .struk-footer {
            padding: 14px 20px;
            text-align: center;
            border-top: 2px dashed #000;
        }
        .struk-footer-text {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .struk-footer-thanks {
            font-family: 'Oswald', sans-serif;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 4px;
        }

        /* ── Print ───────────────────────────────── */
        @media print {
            body { background: #fff; padding: 0; display: block; }
            .struk { box-shadow: none; margin: 0 auto; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

@php
    $masuk     = \Illuminate\Support\Carbon::parse($transaksi->waktu_masuk);
    $keluar    = \Illuminate\Support\Carbon::parse($transaksi->waktu_keluar);
    $menit     = (int) $masuk->diffInMinutes($keluar);
    $jam       = intdiv($menit, 60);
    $sisaMenit = $menit % 60;
    $durasiJam = (int) ceil($menit / 60);
    $durasiStr = $jam > 0
        ? ($sisaMenit > 0 ? "{$jam} jam {$sisaMenit} menit" : "{$jam} jam")
        : "{$menit} menit";
@endphp

<div class="struk-wrapper">

    {{-- Tombol --}}
    <div class="no-print" style="display:flex;gap:12px;margin-bottom:8px;">
        <button onclick="window.print()"
                style="background:#000;color:#fff;border:2px solid #000;padding:10px 28px;font-weight:900;font-size:14px;text-transform:uppercase;letter-spacing:.05em;cursor:pointer;box-shadow:4px 4px 0 #374151;">
            🖨 Cetak Struk
        </button>
        <button onclick="window.close()"
                style="background:#fff;color:#000;border:2px solid #000;padding:10px 20px;font-weight:900;font-size:14px;text-transform:uppercase;letter-spacing:.05em;cursor:pointer;box-shadow:4px 4px 0 #000;">
            ✕ Tutup
        </button>
    </div>

    {{-- ── STRUK ──────────────────────────────────── --}}
    <div class="struk">

        {{-- Header --}}
        <div class="struk-header">
            <div class="struk-header-title">Struk Pembayaran Parkir</div>
            <div class="struk-header-org">ParkFlow</div>
            <div class="struk-header-sub">Sistem Parkir Digital</div>
        </div>

        <hr class="divider-solid">

        {{-- Body --}}
        <div class="struk-body">

            {{-- Meta --}}
            <div class="struk-meta">
                <span>No. #{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</span>
                <span>{{ $keluar->format('d M Y, H:i') }}</span>
            </div>

            {{-- Plat & Pemilik --}}
            <div class="plat-center">
                <div class="plat-center-label">Nomor Polisi</div>
                <div class="plat-center-value">{{ strtoupper($transaksi->kendaraan->plat_nomor) }}</div>
                <div class="plat-center-pemilik">{{ $transaksi->kendaraan->pemilik }}</div>
            </div>

            {{-- Detail Rows --}}
            <div class="struk-row">
                <span class="struk-row-label">Jenis</span>
                <span class="struk-row-value">
                    {{ $transaksi->kendaraan->jenis_kendaraan === 'motor' ? '🛵 Motor' : '🚗 Mobil' }}
                    · {{ $transaksi->kendaraan->warna }}
                </span>
            </div>

            <div class="struk-row">
                <span class="struk-row-label">Area Parkir</span>
                <span class="struk-row-value">{{ $transaksi->areaParkir->nama_area }}</span>
            </div>

            <div class="struk-row">
                <span class="struk-row-label">Waktu Masuk</span>
                <span class="struk-row-value">{{ $masuk->format('H:i') }} · {{ $masuk->format('d M Y') }}</span>
            </div>

            <div class="struk-row">
                <span class="struk-row-label">Waktu Keluar</span>
                <span class="struk-row-value">{{ $keluar->format('H:i') }} · {{ $keluar->format('d M Y') }}</span>
            </div>

            <div class="struk-row">
                <span class="struk-row-label">Durasi</span>
                <span class="struk-row-value">{{ $durasiStr }}</span>
            </div>

            <div class="struk-row">
                <span class="struk-row-label">Dibulatkan</span>
                <span class="struk-row-value">{{ $durasiJam }} jam</span>
            </div>

            <div class="struk-row">
                <span class="struk-row-label">Tarif/jam</span>
                <span class="struk-row-value">Rp {{ number_format($transaksi->tarif, 0, ',', '.') }}</span>
            </div>

        </div>

        <hr class="divider-solid">

        {{-- Total --}}
        <div class="total-box">
            <div class="total-label">Total Pembayaran</div>
            <div class="total-value">
                Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
            </div>
            <div class="total-detail">
                {{ $durasiJam }} jam × Rp {{ number_format($transaksi->tarif, 0, ',', '.') }}
            </div>
        </div>

        {{-- Footer --}}
        <div class="struk-footer">
            <div class="struk-footer-text">Terima kasih telah menggunakan layanan kami</div>
            <div class="struk-footer-thanks">Selamat Jalan! 🙏</div>
        </div>

    </div>

    <div class="no-print" style="font-size:12px;color:#6b7280;font-weight:700;text-align:center;">
        Struk No. #{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }} · {{ now()->format('d M Y, H:i') }}
    </div>

</div>

<script>
    window.addEventListener('load', function () {
        setTimeout(() => window.print(), 500);
    });
</script>

</body>
</html>
