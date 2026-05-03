<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: sans-serif;
        font-size: 11px;
        color: #000;
        background: #fff;
        width: 226px;
    }

    .struk { width: 100%; }

    .header {
        background: #000;
        color: #fff;
        padding: 14px 16px;
        text-align: center;
    }
    .header-title {
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #9ca3af;
    }
    .header-org {
        font-size: 20px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 2px;
    }
    .header-sub {
        font-size: 10px;
        color: #6b7280;
        margin-top: 3px;
    }

    .divider-dashed {
        border: none;
        border-top: 2px dashed #000;
    }
    .divider-solid {
        border: none;
        border-top: 2px solid #000;
    }

    .body { padding: 12px 14px; }

    .meta-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    .meta-table td {
        font-size: 9px;
        font-weight: bold;
        color: #6b7280;
        text-transform: uppercase;
        padding: 0;
    }
    .meta-right { text-align: right; }

    .plat-box {
        border: 2px solid #000;
        padding: 8px;
        text-align: center;
        margin-bottom: 10px;
        background: #f9fafb;
    }
    .plat-label {
        font-size: 8px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #9ca3af;
        margin-bottom: 2px;
    }
    .plat-value {
        font-size: 22px;
        font-weight: 900;
        letter-spacing: 0.12em;
    }
    .plat-pemilik {
        font-size: 11px;
        font-weight: bold;
        color: #374151;
        margin-top: 2px;
    }

    .row-table {
        width: 100%;
        border-collapse: collapse;
    }
    .row-table tr {
        border-bottom: 1px dashed #e5e7eb;
    }
    .row-table tr:last-child {
        border-bottom: none;
    }
    .row-table td {
        padding: 5px 0;
        vertical-align: middle;
    }
    .row-label {
        font-size: 10px;
        font-weight: bold;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .row-value {
        font-size: 11px;
        font-weight: bold;
        text-align: right;
    }

    .total-box {
        background: #000;
        color: #fff;
        padding: 14px 16px;
        text-align: center;
    }
    .total-label {
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #9ca3af;
    }
    .total-value {
        font-size: 28px;
        font-weight: 900;
        color: #4ade80;
        line-height: 1.1;
        margin-top: 3px;
    }
    .total-detail {
        font-size: 10px;
        font-weight: bold;
        color: #6b7280;
        margin-top: 4px;
    }

    .footer {
        padding: 12px 14px;
        text-align: center;
        border-top: 2px dashed #000;
    }
    .footer-text {
        font-size: 10px;
        font-weight: bold;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .footer-thanks {
        font-size: 14px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-top: 3px;
    }
</style>
</head>
<body>
@php
    $masuk     = \Carbon\Carbon::parse($transaksi->waktu_masuk);
    $keluar    = \Carbon\Carbon::parse($transaksi->waktu_keluar);
    $menit     = (int) $masuk->diffInMinutes($keluar);
    $jam       = intdiv($menit, 60);
    $sisaMenit = $menit % 60;
    $durasiJam = (int) ceil($menit / 60);
    $durasiStr = $jam > 0
        ? ($sisaMenit > 0 ? "{$jam} jam {$sisaMenit} menit" : "{$jam} jam")
        : "{$menit} menit";
    $trxNo = str_pad($transaksi->id, 6, '0', STR_PAD_LEFT);
@endphp

<div class="struk">

    <div class="header">
        <div class="header-title">Struk Pembayaran Parkir</div>
        <div class="header-org">ParkFlow</div>
        <div class="header-sub">Sistem Parkir Digital</div>
    </div>

    <hr class="divider-solid">

    <div class="body">
        <table class="meta-table">
            <tr>
                <td>No. #{{ $trxNo }}</td>
                <td class="meta-right">{{ $keluar->format('d M Y, H:i') }}</td>
            </tr>
        </table>

        <div class="plat-box">
            <div class="plat-label">Nomor Polisi</div>
            <div class="plat-value">{{ strtoupper($transaksi->kendaraan->plat_nomor) }}</div>
            <div class="plat-pemilik">{{ $transaksi->kendaraan->pemilik }}</div>
        </div>

        <table class="row-table">
            <tr>
                <td class="row-label">Jenis</td>
                <td class="row-value">
                    {{ $transaksi->kendaraan->jenis_kendaraan === 'motor' ? 'Motor' : 'Mobil' }}
                    · {{ $transaksi->kendaraan->warna }}
                </td>
            </tr>
            <tr>
                <td class="row-label">Area</td>
                <td class="row-value">{{ $transaksi->areaParkir->nama_area }}</td>
            </tr>
            <tr>
                <td class="row-label">Masuk</td>
                <td class="row-value">{{ $masuk->format('H:i') }} · {{ $masuk->format('d M') }}</td>
            </tr>
            <tr>
                <td class="row-label">Keluar</td>
                <td class="row-value">{{ $keluar->format('H:i') }} · {{ $keluar->format('d M') }}</td>
            </tr>
            <tr>
                <td class="row-label">Durasi</td>
                <td class="row-value">{{ $durasiStr }}</td>
            </tr>
            <tr>
                <td class="row-label">Dibulatkan</td>
                <td class="row-value">{{ $durasiJam }} jam</td>
            </tr>
            <tr>
                <td class="row-label">Tarif/jam</td>
                <td class="row-value">Rp {{ number_format($transaksi->tarif, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <hr class="divider-solid">

    <div class="total-box">
        <div class="total-label">Total Pembayaran</div>
        <div class="total-value">
            Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
        </div>
        <div class="total-detail">
            {{ $durasiJam }} jam x Rp {{ number_format($transaksi->tarif, 0, ',', '.') }}
        </div>
    </div>

    <div class="footer">
        <div class="footer-text">Terima kasih telah menggunakan layanan kami</div>
        <div class="footer-thanks">Selamat Jalan!</div>
    </div>

</div>
</body>
</html>
