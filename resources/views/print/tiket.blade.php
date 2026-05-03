<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: sans-serif;
        font-size: 12px;
        color: #000;
        background: #fff;
    }

    .ticket-table {
        width: 100%;
        height: 100%;
        border-collapse: collapse;
        border: 3px solid #000;
    }

    /* Stub kiri */
    .stub {
        width: 30%;
        border-right: 3px dashed #000;
        padding: 14px 12px;
        vertical-align: top;
        background: #fff;
    }
    .stub-org {
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px dashed #000;
        padding-bottom: 8px;
        margin-bottom: 8px;
    }
    .stub-title {
        font-size: 18px;
        font-weight: 900;
        text-transform: uppercase;
        line-height: 1.2;
        margin-bottom: 6px;
    }
    .stub-price {
        font-size: 15px;
        font-weight: 900;
        color: #dc2626;
        margin-bottom: 10px;
    }
    .stub-label {
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6b7280;
        margin-bottom: 3px;
    }
    .stub-plat {
        border: 2px solid #000;
        padding: 6px 8px;
        font-size: 16px;
        font-weight: 900;
        letter-spacing: 0.1em;
        text-align: center;
    }
    .stub-trx {
        font-size: 11px;
        font-weight: bold;
        margin-top: 10px;
    }

    /* Main tiket */
    .main {
        width: 70%;
        padding: 14px 16px;
        vertical-align: top;
    }
    .main-header-table {
        width: 100%;
        border-collapse: collapse;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
    .main-org {
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        color: #374151;
    }
    .main-title {
        font-size: 20px;
        font-weight: 900;
        text-transform: uppercase;
        line-height: 1.1;
        margin-top: 4px;
    }
    .main-price-box {
        border: 2px solid #dc2626;
        padding: 4px 10px;
        font-size: 20px;
        font-weight: 900;
        color: #dc2626;
        text-align: center;
        white-space: nowrap;
    }

    .plat-box {
        border: 2px solid #000;
        padding: 8px 12px;
        margin-bottom: 10px;
    }
    .plat-box-label {
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
        color: #6b7280;
        letter-spacing: 0.1em;
    }
    .plat-box-value {
        font-size: 22px;
        font-weight: 900;
        letter-spacing: 0.12em;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    .info-table td {
        padding: 4px 6px 4px 0;
        vertical-align: top;
        width: 50%;
    }
    .info-label {
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #9ca3af;
    }
    .info-value {
        font-size: 12px;
        font-weight: bold;
        color: #111;
    }

    .footer-note {
        border-top: 2px dashed #000;
        padding-top: 8px;
        font-size: 9px;
        color: #6b7280;
        line-height: 1.5;
    }
    .footer-note ol { padding-left: 12px; }
</style>
</head>
<body>
@php
    $tarif = number_format($transaksi->tarif, 0, ',', '.');
    $trxNo = str_pad($transaksi->id, 6, '0', STR_PAD_LEFT);
@endphp

<table class="ticket-table">
    <tr>
        {{-- STUB KIRI --}}
        <td class="stub">
            <div class="stub-org">ParkFlow<br>Sistem Parkir</div>
            <div class="stub-title">
                KARCIS<br>PARKIR<br>
                {{ strtoupper($transaksi->kendaraan->jenis_kendaraan) }}
            </div>
            <div class="stub-price">Rp {{ $tarif }}/jam</div>

            <div class="stub-label">Nopol.</div>
            <div class="stub-plat">{{ strtoupper($transaksi->kendaraan->plat_nomor) }}</div>

            <div class="stub-trx">No. #{{ $trxNo }}</div>
        </td>

        {{-- MAIN TIKET --}}
        <td class="main">
            {{-- Header --}}
            <table class="main-header-table" style="margin-bottom:10px;">
                <tr>
                    <td>
                        <div class="main-org">ParkFlow · Sistem Parkir Digital</div>
                        <div class="main-title">
                            KARCIS PARKIR<br>
                            {{ strtoupper($transaksi->kendaraan->jenis_kendaraan) }}
                        </div>
                    </td>
                    <td style="text-align:right;vertical-align:top;">
                        <div class="main-price-box">Rp {{ $tarif }}/jam</div>
                    </td>
                </tr>
            </table>

            {{-- Plat --}}
            <div class="plat-box">
                <div class="plat-box-label">Nopol.</div>
                <div class="plat-box-value">{{ strtoupper($transaksi->kendaraan->plat_nomor) }}</div>
            </div>

            {{-- Info --}}
            <table class="info-table">
                <tr>
                    <td>
                        <div class="info-label">Pemilik</div>
                        <div class="info-value">{{ $transaksi->kendaraan->pemilik }}</div>
                    </td>
                    <td>
                        <div class="info-label">Jenis Kendaraan</div>
                        <div class="info-value">
                            {{ $transaksi->kendaraan->jenis_kendaraan === 'motor' ? 'Motor' : 'Mobil' }}
                            · {{ $transaksi->kendaraan->warna }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="info-label">Area Parkir</div>
                        <div class="info-value">{{ $transaksi->areaParkir->nama_area }}</div>
                    </td>
                    <td>
                        <div class="info-label">Waktu Masuk</div>
                        <div class="info-value">
                            {{ $transaksi->waktu_masuk->format('H:i') }} ·
                            {{ $transaksi->waktu_masuk->format('d M Y') }}
                        </div>
                    </td>
                </tr>
            </table>

            {{-- Catatan --}}
            <div class="footer-note">
                <strong>Untuk Pengendara:</strong>
                <ol>
                    <li>Kendaraan harus dikunci ganda.</li>
                    <li>Kehilangan/kerusakan kendaraan adalah risiko pengendara.</li>
                    <li>Karcis hanya berlaku satu kali parkir.</li>
                    <li>Jangan tinggalkan karcis di kendaraan.</li>
                    <li>Karcis jangan sampai hilang.</li>
                </ol>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
