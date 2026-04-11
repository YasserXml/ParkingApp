<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Parkir — {{ strtoupper($transaksi->kendaraan->plat_nomor) }}</title>
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

        .ticket-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }

        /* ── Ticket Container ─────────────────── */
        .ticket {
            width: 680px;
            display: flex;
            background: #fff;
            border: 3px solid #000;
            box-shadow: 6px 6px 0 #000;
            position: relative;
            overflow: hidden;
        }

        /* ── Tear Line ─────────────────────────── */
        .tear-line {
            width: 3px;
            background: repeating-linear-gradient(
                to bottom,
                #000 0px,
                #000 8px,
                transparent 8px,
                transparent 16px
            );
            position: relative;
            flex-shrink: 0;
        }
        .tear-circle-top,
        .tear-circle-bottom {
            position: absolute;
            width: 20px;
            height: 20px;
            background: #f0f0f0;
            border-radius: 50%;
            border: 3px solid #000;
            left: 50%;
            transform: translateX(-50%);
        }
        .tear-circle-top    { top: -12px; }
        .tear-circle-bottom { bottom: -12px; }

        /* ── Stub Kiri (30%) ───────────────────── */
        .stub {
            width: 200px;
            flex-shrink: 0;
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            border-right: none;
        }

        .stub-header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 4px;
        }
        .stub-org {
            font-family: 'Oswald', sans-serif;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            line-height: 1.3;
        }
        .stub-title {
            font-family: 'Oswald', sans-serif;
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            line-height: 1.1;
            margin-top: 6px;
        }
        .stub-price {
            font-family: 'Oswald', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: #dc2626;
            margin-top: 4px;
        }
        .stub-plat-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6b7280;
            margin-top: 6px;
        }
        .stub-plat-box {
            border: 2px solid #000;
            padding: 6px 10px;
            font-family: 'Oswald', sans-serif;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-align: center;
            margin-top: 3px;
            min-height: 34px;
        }

        /* ── Main Tiket (70%) ──────────────────── */
        .main {
            flex: 1;
            padding: 18px 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #000;
            padding-bottom: 12px;
        }
        .main-org {
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            line-height: 1.3;
            color: #374151;
        }
        .main-title {
            font-family: 'Oswald', sans-serif;
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            line-height: 1.1;
            margin-top: 4px;
        }
        .main-price {
            font-family: 'Oswald', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #dc2626;
            background: rgba(220,38,38,0.08);
            border: 2px solid #dc2626;
            padding: 4px 12px;
            text-align: center;
            align-self: flex-start;
        }

        /* Vehicle icon area */
        .vehicle-icon {
            position: absolute;
            right: 20px;
            top: 60px;
            opacity: 0.12;
            font-size: 80px;
            line-height: 1;
        }

        /* Info rows */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            position: relative;
            z-index: 1;
        }
        .info-item { display: flex; flex-direction: column; gap: 1px; }
        .info-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #9ca3af;
        }
        .info-value {
            font-size: 13px;
            font-weight: 700;
            color: #111;
        }
        .info-value-lg {
            font-family: 'Oswald', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        /* Plat nomor box */
        .plat-box {
            border: 2px solid #000;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 4px;
        }
        .plat-label-sm {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #6b7280;
            flex-shrink: 0;
        }
        .plat-value {
            font-family: 'Oswald', sans-serif;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.12em;
        }

        /* Footer note */
        .ticket-footer {
            border-top: 2px dashed #000;
            padding-top: 10px;
            font-size: 9px;
            color: #6b7280;
            line-height: 1.5;
        }
        .ticket-footer ol { padding-left: 14px; }

        /* Perhatian box */
        .perhatian-box {
            border: 2px solid #000;
            padding: 8px 10px;
            background: #fafafa;
        }
        .perhatian-title {
            font-family: 'Oswald', sans-serif;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 4px;
        }
        .perhatian-text {
            font-size: 9px;
            line-height: 1.5;
            color: #374151;
        }

        /* ── Print Styles ──────────────────────── */
        @media print {
            body {
                background: #fff;
                padding: 0;
                display: block;
            }
            .ticket {
                box-shadow: none;
                border: 2px solid #000;
                width: 100%;
                max-width: 680px;
                margin: 0 auto;
            }
            .no-print { display: none !important; }
            .tear-circle-top,
            .tear-circle-bottom { background: #fff; }
        }
    </style>
</head>
<body>

<div class="ticket-wrapper">

    {{-- ── Tombol Cetak (disembunyikan saat print) ── --}}
    <div class="no-print" style="display:flex;gap:12px;margin-bottom:8px;">
        <button onclick="window.print()"
                style="background:#000;color:#fff;border:2px solid #000;padding:10px 28px;font-weight:900;font-size:14px;text-transform:uppercase;letter-spacing:.05em;cursor:pointer;box-shadow:4px 4px 0 #374151;">
            🖨 Cetak Tiket
        </button>
        <button onclick="window.close()"
                style="background:#fff;color:#000;border:2px solid #000;padding:10px 20px;font-weight:900;font-size:14px;text-transform:uppercase;letter-spacing:.05em;cursor:pointer;box-shadow:4px 4px 0 #000;">
            ✕ Tutup
        </button>
    </div>

    {{-- ── TIKET ─────────────────────────────────── --}}
    <div class="ticket">

        {{-- STUB KIRI --}}
        <div class="stub">
            <div class="stub-header">
                <div class="stub-org">
                    ParkFlow<br>Sistem Parkir
                </div>
                <div class="stub-title">
                    KARCIS<br>PARKIR<br>
                    {{ strtoupper($transaksi->kendaraan->jenis_kendaraan) }}
                </div>
                <div class="stub-price">
                    Rp {{ number_format($transaksi->tarif, 0, ',', '.') }}/jam
                </div>
            </div>

            <div>
                <div class="stub-plat-label">Nopol.</div>
                <div class="stub-plat-box">
                    {{ strtoupper($transaksi->kendaraan->plat_nomor) }}
                </div>
            </div>

            <div style="margin-top:auto;">
                <div class="stub-plat-label">No. Transaksi</div>
                <div style="font-size:11px;font-weight:700;margin-top:2px;">#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>

        {{-- TEAR LINE --}}
        <div class="tear-line">
            <div class="tear-circle-top"></div>
            <div class="tear-circle-bottom"></div>
        </div>

        {{-- MAIN TIKET --}}
        <div class="main">

            {{-- Icon kendaraan (background) --}}
            <div class="vehicle-icon">
                {{ $transaksi->kendaraan->jenis_kendaraan === 'motor' ? '🛵' : '🚗' }}
            </div>

            {{-- Header --}}
            <div class="main-header">
                <div>
                    <div class="main-org">ParkFlow · Sistem Parkir Digital</div>
                    <div class="main-title">
                        KARCIS PARKIR<br>
                        {{ strtoupper($transaksi->kendaraan->jenis_kendaraan) }}
                    </div>
                </div>
                <div class="main-price">
                    Rp {{ number_format($transaksi->tarif, 0, ',', '.') }}/jam
                </div>
            </div>

            {{-- Plat Nomor --}}
            <div class="plat-box">
                <span class="plat-label-sm">Nopol.</span>
                <span class="plat-value">{{ strtoupper($transaksi->kendaraan->plat_nomor) }}</span>
            </div>

            {{-- Info Grid --}}
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Pemilik</span>
                    <span class="info-value">{{ $transaksi->kendaraan->pemilik }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jenis Kendaraan</span>
                    <span class="info-value">
                        {{ $transaksi->kendaraan->jenis_kendaraan === 'motor' ? '🛵 Motor' : '🚗 Mobil' }}
                        · {{ $transaksi->kendaraan->warna }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Area Parkir</span>
                    <span class="info-value">{{ $transaksi->areaParkir->nama_area }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Waktu Masuk</span>
                    <span class="info-value">{{ $transaksi->waktu_masuk->format('H:i') }} · {{ $transaksi->waktu_masuk->format('d M Y') }}</span>
                </div>
            </div>

            {{-- Catatan --}}
            <div class="ticket-footer">
                <strong>Untuk Pengendara:</strong>
                <ol>
                    <li>Kendaraan harus dikunci ganda.</li>
                    <li>Segala bentuk kehilangan / kerusakan atas kendaraan yang diparkir dan barang-barang di dalamnya adalah resiko pengendara (tidak ada pertanggungan).</li>
                    <li>Karcis parkir hanya berlaku satu kali parkir.</li>
                    <li>Karcis ini harap jangan di tinggal di kendaraan.</li>
                    <li>Karcis jangan sampai hilang.</li>
                </ol>
            </div>

        </div>
    </div>

    {{-- ── INFO TAMBAHAN (no print) ───────────────── --}}
    <div class="no-print" style="font-size:12px;color:#6b7280;font-weight:700;text-align:center;">
        Tiket berhasil dibuat · No. #{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }} · {{ now()->format('d M Y, H:i') }}
    </div>

</div>

<script>
    // Auto print saat halaman terbuka
    window.addEventListener('load', function () {
        setTimeout(() => window.print(), 500);
    });
</script>

</body>
</html>
