<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $laporan->judul }}</title>

    <style>
        /* ── Reset & Base ────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            background: #fff;
            padding: 0;
        }

        /* ── Layout halaman ─────────────────────────────── */
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 14mm 16mm 14mm 16mm;
            background: #fff;
        }

        /* ── Header ──────────────────────────────────────── */
        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 3px solid #1e293b;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: #1e293b;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .brand-sub {
            font-size: 10px;
            color: #64748b;
            font-weight: 500;
            margin-top: 2px;
        }

        .header-meta {
            text-align: right;
        }

        .header-meta .doc-type {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            margin-bottom: 2px;
        }

        .header-meta .doc-date {
            font-size: 11px;
            color: #1e293b;
            font-weight: 600;
        }

        /* ── Judul laporan ───────────────────────────────── */
        .laporan-title-section {
            background: #1e293b;
            color: #fff;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .laporan-title {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .laporan-badge {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 3px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        /* ── Info grid ───────────────────────────────────── */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 14px;
        }

        .info-card {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 12px;
        }

        .info-card-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            margin-bottom: 4px;
        }

        .info-card-value {
            font-size: 18px;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
        }

        .info-card-value-sm {
            font-size: 13px;
            font-weight: 800;
            color: #1e293b;
            line-height: 1.2;
        }

        .info-card-sub {
            font-size: 9px;
            color: #94a3b8;
            margin-top: 3px;
            font-weight: 600;
        }

        .info-card-green {
            border-left: 3px solid #22c55e;
        }

        .info-card-blue {
            border-left: 3px solid #3b82f6;
        }

        .info-card-yellow {
            border-left: 3px solid #f59e0b;
        }

        .info-card-purple {
            border-left: 3px solid #a855f7;
        }

        /* ── Section heading ─────────────────────────────── */
        .section-heading {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #1e293b;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1.5px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .section-heading::before {
            content: '';
            display: inline-block;
            width: 3px;
            height: 12px;
            background: #1e293b;
            border-radius: 2px;
        }

        /* ── Tabel Transaksi ─────────────────────────────── */
        .table-section {
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        thead tr {
            background: #1e293b;
            color: #fff;
        }

        thead th {
            padding: 8px 10px;
            font-weight: 700;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            text-align: left;
            white-space: nowrap;
        }

        thead th.text-right {
            text-align: right;
        }

        thead th.text-center {
            text-align: center;
        }

        tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody td {
            padding: 7px 10px;
            vertical-align: middle;
            color: #334155;
        }

        tbody td.text-right {
            text-align: right;
        }

        tbody td.text-center {
            text-align: center;
        }

        .td-bold {
            font-weight: 700;
            color: #1e293b;
        }

        .td-muted {
            color: #94a3b8;
            font-size: 10px;
        }

        tfoot tr {
            background: #f1f5f9;
            border-top: 2px solid #1e293b;
        }

        tfoot td {
            padding: 8px 10px;
            font-weight: 800;
            font-size: 11px;
            color: #1e293b;
        }

        tfoot td.text-right {
            text-align: right;
        }

        /* ── Badge jenis kendaraan ───────────────────────── */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-motor {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde047;
        }

        .badge-mobil {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }

        .badge-masuk {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .badge-keluar {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        /* ── Ringkasan per jenis ─────────────────────────── */
        .ringkasan-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 16px;
        }

        .ringkasan-card {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }

        .ringkasan-card-header {
            background: #f8fafc;
            padding: 7px 12px;
            font-weight: 700;
            font-size: 11px;
            color: #1e293b;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ringkasan-card-body {
            padding: 10px 12px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px;
        }

        .ringkasan-item-label {
            font-size: 9px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .ringkasan-item-value {
            font-size: 16px;
            font-weight: 800;
            color: #1e293b;
        }

        .ringkasan-item-value-sm {
            font-size: 12px;
            font-weight: 800;
            color: #16a34a;
        }

        /* ── Ringkasan per area ──────────────────────────── */
        .area-table td {
            padding: 6px 10px;
        }

        /* ── Footer ──────────────────────────────────────── */
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #94a3b8;
            font-size: 9.5px;
        }

        .footer-left {}

        .footer-right {
            text-align: right;
        }

        /* ── Tanda tangan ────────────────────────────────── */
        .ttd-section {
            margin-top: 24px;
            display: flex;
            justify-content: flex-end;
        }

        .ttd-box {
            text-align: center;
            width: 160px;
        }

        .ttd-label {
            font-size: 10px;
            color: #475569;
            font-weight: 600;
            margin-bottom: 48px;
            /* ruang tanda tangan */
        }

        .ttd-line {
            border-top: 1px solid #1e293b;
            padding-top: 4px;
            font-size: 10px;
            font-weight: 700;
            color: #1e293b;
        }

        .ttd-jabatan {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }

        /* ── Print styles ────────────────────────────────── */
        @media print {
            body {
                padding: 0;
            }

            .page {
                width: 100%;
                padding: 10mm 12mm;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A4;
                margin: 0;
            }
        }

        /* ── Toolbar (tidak ikut print) ───────────────────── */
        .print-toolbar {
            position: fixed;
            top: 16px;
            right: 16px;
            display: flex;
            gap: 8px;
            z-index: 9999;
        }

        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .print-btn:hover {
            opacity: 0.85;
        }

        .print-btn-print {
            background: #1e293b;
            color: #fff;
        }

        .print-btn-back {
            background: #e2e8f0;
            color: #1e293b;
        }
    </style>
</head>

<body>

    {{-- ── Toolbar (tidak ikut cetak) ─────────────────────────── --}}
    <div class="print-toolbar no-print">
        <button class="print-btn print-btn-back" onclick="window.close()">
            ← Tutup
        </button>
        <button class="print-btn print-btn-print" onclick="window.print()">
            🖨 Cetak / Simpan PDF
        </button>
    </div>

    <div class="page">

        {{-- ── Header ──────────────────────────────────────────── --}}
        <div class="header">
            <div class="header-brand">
                <div class="brand-icon">
                    <img src="{{ asset('images/iconpark.png') }}" alt="Logo Brand">
                </div>
                <div>
                    <div class="brand-name">ParkFlow</div>
                    <div class="brand-sub">Sistem Manajemen Parkir</div>
                </div>
            </div>
            <div class="header-meta">
                <div class="doc-type">Laporan Parkir</div>
                <div class="doc-date">
                    Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}
                </div>
                @if ($laporan->generated_by)
                    <div class="doc-date" style="color:#94a3b8;">
                        Oleh: {{ $laporan->generated_by }}
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Judul & Badge ────────────────────────────────────── --}}
        <div class="laporan-title-section">
            <span class="laporan-title">{{ $laporan->judul }}</span>
            <span class="laporan-badge">{{ $laporan->periode_format }}</span>
        </div>

        {{-- ── Info cards ringkasan ────────────────────────────── --}}
        <div class="info-grid">
            <div class="info-card info-card-blue">
                <div class="info-card-label">Periode</div>
                <div class="info-card-value-sm">{{ $laporan->periode_format }}</div>
                <div class="info-card-sub">
                    {{ $laporan->areaParkir?->nama_area ?? 'Semua Area' }}
                </div>
            </div>

            <div class="info-card info-card-green">
                <div class="info-card-label">Total Transaksi</div>
                <div class="info-card-value">{{ number_format($laporan->total_transaksi) }}</div>
                <div class="info-card-sub">
                    {{ $laporan->total_kendaraan_keluar }} selesai,
                    {{ $laporan->total_kendaraan_masuk - $laporan->total_kendaraan_keluar }} aktif
                </div>
            </div>

            <div class="info-card info-card-yellow">
                <div class="info-card-label">Total Pendapatan</div>
                <div class="info-card-value-sm">{{ $laporan->total_pendapatan_format }}</div>
                <div class="info-card-sub">dari transaksi selesai</div>
            </div>

            <div class="info-card info-card-purple">
                <div class="info-card-label">Rata-rata Durasi</div>
                <div class="info-card-value-sm">{{ $laporan->rata_rata_durasi_format }}</div>
                <div class="info-card-sub">per kendaraan</div>
            </div>
        </div>

        {{-- ── Ringkasan per Jenis Kendaraan ───────────────────── --}}
        @if ($laporan->ringkasan_per_jenis && count($laporan->ringkasan_per_jenis) > 0)
            <div class="table-section">
                <div class="section-heading">Ringkasan per Jenis Kendaraan</div>
                <div class="ringkasan-grid">
                    @foreach ($laporan->ringkasan_per_jenis as $jenis => $data)
                        <div class="ringkasan-card">
                            <div class="ringkasan-card-header">
                                <span>
                                    {{ $jenis === 'motor' ? '🛵 Motor' : ($jenis === 'mobil' ? '🚗 Mobil' : ucfirst($jenis)) }}
                                </span>
                                <span class="badge {{ $jenis === 'motor' ? 'badge-motor' : 'badge-mobil' }}">
                                    {{ ucfirst($jenis) }}
                                </span>
                            </div>
                            <div class="ringkasan-card-body">
                                <div>
                                    <div class="ringkasan-item-label">Masuk</div>
                                    <div class="ringkasan-item-value">{{ $data['masuk'] ?? 0 }}</div>
                                </div>
                                <div>
                                    <div class="ringkasan-item-label">Keluar</div>
                                    <div class="ringkasan-item-value">{{ $data['keluar'] ?? 0 }}</div>
                                </div>
                                <div>
                                    <div class="ringkasan-item-label">Pendapatan</div>
                                    <div class="ringkasan-item-value-sm">
                                        Rp {{ number_format($data['pendapatan'] ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── Ringkasan per Area (jika laporan semua area) ───── --}}
        @if ($laporan->ringkasan_per_area && count($laporan->ringkasan_per_area) > 0)
            <div class="table-section">
                <div class="section-heading">Ringkasan per Area Parkir</div>
                <table class="area-table">
                    <thead>
                        <tr>
                            <th>Area</th>
                            <th class="text-center">Transaksi</th>
                            <th class="text-right">Pendapatan</th>
                            <th class="text-right">Kontribusi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan->ringkasan_per_area as $area)
                            <tr>
                                <td class="td-bold">{{ $area['nama_area'] }}</td>
                                <td class="text-center">{{ $area['total_transaksi'] }}</td>
                                <td class="text-right td-bold">
                                    Rp {{ number_format($area['pendapatan'], 0, ',', '.') }}
                                </td>
                                <td class="text-right td-muted">
                                    @php
                                        $kontribusi =
                                            $laporan->total_pendapatan > 0
                                                ? round(($area['pendapatan'] / $laporan->total_pendapatan) * 100, 1)
                                                : 0;
                                    @endphp
                                    {{ $kontribusi }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="td-bold">Total</td>
                            <td class="text-center">{{ $laporan->total_transaksi }}</td>
                            <td class="text-right">{{ $laporan->total_pendapatan_format }}</td>
                            <td class="text-right">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif

        {{-- ── Detail Transaksi (10 teratas) ──────────────────── --}}
        @php
            use App\Models\Transaksi;
            use Carbon\Carbon;

            $dari = Carbon::parse($laporan->periode_dari)->startOfDay();
            $sampai = Carbon::parse($laporan->periode_sampai)->endOfDay();

            $detailQuery = Transaksi::with(['kendaraan', 'areaParkir'])
                ->whereBetween('waktu_masuk', [$dari, $sampai])
                ->when($laporan->area_id, fn($q) => $q->where('area_id', $laporan->area_id))
                ->where('status', 'keluar')
                ->latest('waktu_masuk');

            $totalSelesai = $detailQuery->count();
            $detailRows = (clone $detailQuery)->limit(20)->get();
        @endphp

        @if ($detailRows->isNotEmpty())
            <div class="table-section">
                <div class="section-heading">
                    Detail Transaksi Selesai
                    @if ($totalSelesai > 20)
                        <span style="font-weight:500;color:#94a3b8;font-size:9.5px;">
                            (menampilkan 20 dari {{ $totalSelesai }})
                        </span>
                    @endif
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Plat Nomor</th>
                            <th>Pemilik</th>
                            <th class="text-center">Jenis</th>
                            <th>Area</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th class="text-center">Durasi</th>
                            <th class="text-right">Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailRows as $i => $t)
                            <tr>
                                <td class="td-muted">{{ $i + 1 }}</td>
                                <td class="td-bold">{{ strtoupper($t->kendaraan->plat_nomor) }}</td>
                                <td>{{ $t->kendaraan->pemilik }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge {{ $t->kendaraan->jenis_kendaraan === 'motor' ? 'badge-motor' : 'badge-mobil' }}">
                                        {{ ucfirst($t->kendaraan->jenis_kendaraan) }}
                                    </span>
                                </td>
                                <td>{{ $t->areaParkir->nama_area }}</td>
                                <td>{{ $t->waktu_masuk->format('H:i') }}<br><span
                                        class="td-muted">{{ $t->waktu_masuk->format('d/m') }}</span></td>
                                <td>{{ $t->waktu_keluar?->format('H:i') ?? '—' }}<br><span
                                        class="td-muted">{{ $t->waktu_keluar?->format('d/m') ?? '' }}</span></td>
                                <td class="text-center">{{ $t->durasi_format }}</td>
                                <td class="text-right td-bold">{{ $t->total_bayar_format }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="text-right">Total Pendapatan ({{ $totalSelesai }} transaksi)</td>
                            <td class="text-right" style="color:#16a34a;">
                                {{ $laporan->total_pendapatan_format }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif

        {{-- ── Tanda tangan ─────────────────────────────────────── --}}
        <div class="ttd-section">
            <div class="ttd-box">
                <div class="ttd-label">
                    Dibuat oleh,<br>
                    {{ now()->translatedFormat('d F Y') }}
                </div>
                <div class="ttd-line">{{ $laporan->generated_by ?? '___________________' }}</div>
                <div class="ttd-jabatan">Owner</div>
            </div>
        </div>

        {{-- ── Footer ───────────────────────────────────────────── --}}
        <div class="footer">
            <div class="footer-left">
                Laporan ini digenerate otomatis oleh Sistem Parkir App.
            </div>
            <div class="footer-right">
                ID: #{{ $laporan->id }} &nbsp;·&nbsp;
                {{ $laporan->generated_at?->format('d/m/Y H:i') }}
            </div>
        </div>

    </div>

    <script>
        // Auto-trigger print dialog saat halaman pertama kali dibuka
        window.addEventListener('load', function() {
            // Beri waktu render selesai sebelum print dialog muncul
            setTimeout(function() {
                // Hanya auto-trigger jika dibuka dari window.open (bukan navigasi biasa)
                if (window.opener) {
                    window.print();
                }
            }, 600);
        });
    </script>
</body>

</html>
