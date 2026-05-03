<x-filament-panels::page>

    <style>
        .neo-page * {
            box-sizing: border-box;
        }

        .neo-page {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .neo-split {
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .neo-left {
            width: 300px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .neo-right {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .neo-card {
            border: 2px solid #000;
            box-shadow: 4px 4px 0 #000;
            padding: 1rem;
        }

        .neo-card-green {
            background: #4ade80;
        }

        .neo-card-yellow {
            background: #fde047;
        }

        .neo-card-blue {
            background: #60a5fa;
        }

        .neo-card-white {
            background: #fff;
        }

        .neo-card-label {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: 4px;
        }

        .neo-card-number {
            font-size: 3rem;
            font-weight: 900;
            line-height: 1;
        }

        .neo-card-number-md {
            font-size: 1.5rem;
            font-weight: 900;
            line-height: 1.2;
        }

        .neo-card-sub {
            font-size: 11px;
            font-weight: 700;
            color: rgba(0, 0, 0, .6);
            margin-top: 4px;
        }

        .neo-progress-wrap {
            width: 100%;
            height: 20px;
            background: #e5e7eb;
            border: 2px solid #000;
            box-shadow: 2px 2px 0 #000;
            overflow: hidden;
        }

        .neo-progress-fill {
            height: 100%;
            border-right: 2px solid #000;
            transition: width .3s;
        }

        .neo-progress-green {
            background: #4ade80;
        }

        .neo-progress-yellow {
            background: #fde047;
        }

        .neo-progress-red {
            background: #f87171;
        }

        .neo-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 2px solid #000;
            font-weight: 900;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .05em;
            padding: 8px 16px;
            cursor: pointer;
            transition: transform .1s;
            white-space: nowrap;
            background: none;
        }

        .neo-btn:hover:not(:disabled) {
            transform: translate(-2px, -2px);
        }

        .neo-btn:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .neo-btn-green {
            background: #4ade80;
            box-shadow: 4px 4px 0 #000;
        }

        .neo-btn-red {
            background: #f87171;
            box-shadow: 4px 4px 0 #000;
        }

        .neo-btn-ghost {
            background: #fff;
            box-shadow: 3px 3px 0 #000;
        }

        .neo-btn-sm {
            padding: 4px 12px;
            font-size: 11px;
            box-shadow: 2px 2px 0 #000;
        }

        .neo-search-wrap {
            position: relative;
        }

        .neo-search {
            width: 100%;
            border: 2px solid #000;
            box-shadow: 3px 3px 0 #000;
            padding: 8px 40px 8px 12px;
            font-weight: 700;
            font-size: 13px;
            background: #fff;
            outline: none;
        }

        .neo-search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            width: 16px;
            height: 16px;
        }

        .neo-actions-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .neo-btns-group {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .neo-tabs {
            display: inline-flex;
            border: 2px solid #000;
            box-shadow: 3px 3px 0 #000;
            overflow: hidden;
        }

        .neo-tab {
            padding: 8px 20px;
            font-weight: 900;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-right: 2px solid #000;
            cursor: pointer;
            background: #fff;
            color: #000;
            transition: background .1s;
            border-top: none;
            border-bottom: none;
            border-left: none;
        }

        .neo-tab:last-child {
            border-right: none;
        }

        .neo-tab:hover {
            background: #f3f4f6;
        }

        .neo-tab.active {
            background: #000;
            color: #fff;
        }

        .neo-tab-cnt {
            font-size: 11px;
            color: #4ade80;
            margin-left: 2px;
        }

        .neo-table-wrap {
            border: 2px solid #000;
            box-shadow: 4px 4px 0 #000;
            background: #fff;
            overflow: hidden;
        }

        .neo-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .neo-table thead tr {
            background: #000;
            color: #fff;
        }

        .neo-table th {
            padding: 12px 14px;
            font-weight: 900;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            text-align: left;
            white-space: nowrap;
        }

        .neo-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .neo-table tbody tr:last-child {
            border-bottom: none;
        }

        .neo-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .neo-table td {
            padding: 10px 14px;
            vertical-align: middle;
        }

        .neo-plat {
            font-weight: 900;
            font-size: 14px;
        }

        .neo-sub {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            margin-top: 2px;
        }

        .neo-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border: 2px solid;
            font-weight: 900;
            font-size: 11px;
            text-transform: uppercase;
        }

        .neo-badge-motor {
            background: #fde047;
            border-color: #ca8a04;
        }

        .neo-badge-mobil {
            background: #bfdbfe;
            border-color: #3b82f6;
        }

        .neo-status {
            display: inline-block;
            padding: 2px 8px;
            border: 2px solid #000;
            font-weight: 900;
            font-size: 11px;
            text-transform: uppercase;
        }

        .neo-status-aktif {
            background: #4ade80;
        }

        .neo-status-selesai {
            background: #e5e7eb;
        }

        .neo-empty {
            padding: 4rem 2rem;
            text-align: center;
        }

        .neo-empty-icon {
            font-size: 2.5rem;
            margin-bottom: .5rem;
        }

        .neo-empty-text {
            font-weight: 900;
            text-transform: uppercase;
            font-size: 13px;
            color: #9ca3af;
        }

        .neo-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(0, 0, 0, .65);
        }

        .neo-modal {
            background: #fff;
            border: 2px solid #000;
            box-shadow: 6px 6px 0 #000;
            width: 100%;
            max-width: 480px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .neo-modal-hdr {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-bottom: 2px solid #000;
        }

        .neo-modal-hdr-green {
            background: #4ade80;
        }

        .neo-modal-hdr-red {
            background: #f87171;
        }

        .neo-modal-title {
            font-weight: 900;
            font-size: 15px;
            text-transform: uppercase;
        }

        .neo-close {
            width: 30px;
            height: 30px;
            border: 2px solid #000;
            background: transparent;
            font-weight: 900;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .neo-close:hover {
            background: #000;
            color: #fff;
        }

        .neo-modal-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .neo-modal-footer {
            display: flex;
            gap: 10px;
            padding-top: 14px;
            border-top: 2px solid #000;
        }

        .neo-modal-footer .neo-btn {
            flex: 1;
            justify-content: center;
        }

        .neo-slideover-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            justify-content: flex-end;
            background: rgba(0, 0, 0, .5);
        }

        .neo-slideover {
            background: #fff;
            border-left: 2px solid #000;
            box-shadow: -6px 0 0 #000;
            width: 100%;
            max-width: 400px;
            height: 100%;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .neo-slideover-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            flex: 1;
        }

        .neo-slideover-footer {
            padding: 16px 20px;
            border-top: 2px solid #000;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-shrink: 0;
        }

        .neo-label {
            display: block;
            font-weight: 900;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: 4px;
        }

        .neo-input {
            width: 100%;
            border: 2px solid #000;
            box-shadow: 3px 3px 0 #000;
            padding: 8px 12px;
            font-weight: 700;
            font-size: 14px;
            background: #fff;
            outline: none;
            color: #000;
        }

        .neo-input-ro {
            background: #f3f4f6;
            color: #6b7280;
        }

        .neo-select {
            width: 100%;
            border: 2px solid #000;
            box-shadow: 3px 3px 0 #000;
            padding: 8px 12px;
            font-weight: 700;
            font-size: 14px;
            background: #fff;
            outline: none;
            color: #000;
            cursor: pointer;
        }

        .neo-error {
            color: #dc2626;
            font-size: 11px;
            font-weight: 700;
            margin-top: 4px;
        }

        .neo-helper {
            color: #9ca3af;
            font-size: 11px;
            font-weight: 700;
            margin-top: 4px;
        }

        .neo-info-box {
            border: 2px solid #000;
            box-shadow: 3px 3px 0 #000;
            padding: 12px;
        }

        .neo-info-green {
            background: #f0fdf4;
        }

        .neo-info-yellow {
            background: #fefce8;
        }

        .neo-info-red {
            background: #fef2f2;
        }

        .neo-info-blue {
            background: #eff6ff;
        }

        .neo-info-gray {
            background: #f9fafb;
        }

        .neo-info-lbl {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .neo-info-val {
            font-weight: 700;
            font-size: 13px;
        }

        .neo-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 10px;
        }

        .neo-calc-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .neo-calc-row:last-child {
            border-bottom: none;
        }

        .neo-calc-lbl {
            font-weight: 700;
            font-size: 13px;
            color: #4b5563;
        }

        .neo-calc-val {
            font-weight: 900;
            font-size: 13px;
        }

        .neo-total-lbl {
            font-weight: 900;
            font-size: 15px;
            text-transform: uppercase;
        }

        .neo-total-val {
            font-weight: 900;
            font-size: 1.75rem;
            color: #16a34a;
        }

        @media(max-width:1024px) {
            .neo-split {
                flex-direction: column;
            }

            .neo-left {
                width: 100%;
            }
        }

        @media(max-width:640px) {
            .neo-actions-row {
                flex-direction: column;
                align-items: stretch;
            }

            .neo-btns-group {
                flex-direction: column;
            }

            .neo-btn {
                justify-content: center;
            }
        }
    </style>

    <div class="neo-page">
        <div class="neo-split">

            {{-- ── PANEL KIRI ─────────────────────────────────── --}}
            <div class="neo-left">

                <div class="neo-card neo-card-green">
                    <p class="neo-card-label">Sedang Parkir</p>
                    <p class="neo-card-number">{{ $this->statSedangParkir }}</p>
                    <p class="neo-card-sub">kendaraan aktif</p>
                </div>

                <div class="neo-card neo-card-yellow">
                    <p class="neo-card-label">Masuk Hari Ini</p>
                    <p class="neo-card-number">{{ $this->statMasukHariIni }}</p>
                    <p class="neo-card-sub">total kendaraan</p>
                </div>

                <div class="neo-card neo-card-blue">
                    <p class="neo-card-label">Pendapatan Hari Ini</p>
                    <p class="neo-card-number-md">{{ $this->statPendapatanHariIni }}</p>
                    <p class="neo-card-sub">dari transaksi selesai</p>
                </div>

                <div class="neo-card neo-card-white">
                    <p class="neo-card-label" style="margin-bottom:12px;">Kapasitas Area</p>
                    @forelse ($this->areaParkirs as $area)
                        @php
                            $pct = $area->kapasitas > 0 ? round(($area->terisi / $area->kapasitas) * 100) : 0;
                            $fillCls =
                                $pct >= 100
                                    ? 'neo-progress-red'
                                    : ($pct >= 80
                                        ? 'neo-progress-yellow'
                                        : 'neo-progress-green');
                        @endphp
                        <div style="margin-bottom:14px;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                                <span style="font-weight:900;font-size:13px;">{{ $area->nama_area }}</span>
                                <span
                                    style="font-weight:700;font-size:12px;">{{ $area->terisi }}/{{ $area->kapasitas }}</span>
                            </div>
                            <div class="neo-progress-wrap">
                                <div class="neo-progress-fill {{ $fillCls }}" style="width:{{ min($pct, 100) }}%">
                                </div>
                            </div>
                            <p style="font-size:10px;font-weight:700;color:#6b7280;margin-top:3px;">
                                {{ $area->sisa_slot }} slot tersedia · {{ $pct }}%
                            </p>
                        </div>
                    @empty
                        <p style="font-size:13px;color:#9ca3af;font-weight:700;">Belum ada area parkir.</p>
                    @endforelse
                </div>

            </div>

            {{-- ── PANEL KANAN ─────────────────────────────────── --}}
            <div class="neo-right">

                {{-- Actions Row --}}
                <div class="neo-actions-row">
                    <div class="neo-search-wrap" style="max-width:280px;width:100%;">
                        <input type="text" wire:model.live.debounce.400ms="search"
                            placeholder="Cari plat nomor / pemilik..." class="neo-search" />
                        <svg class="neo-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                        </svg>
                    </div>
                    <div class="neo-btns-group">
                        <button class="neo-btn neo-btn-green" wire:click="bukaModalMasuk">
                            ↓ Proses Kendaraan Masuk
                        </button>
                        <button class="neo-btn neo-btn-red" wire:click="bukaModalCari">
                            ↑ Proses Kendaraan Keluar
                        </button>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="neo-tabs">
                    <button class="neo-tab {{ $tab === 'aktif' ? 'active' : '' }}" wire:click="setTab('aktif')">
                        Aktif <span class="neo-tab-cnt">({{ $this->statSedangParkir }})</span>
                    </button>
                    <button class="neo-tab {{ $tab === 'selesai' ? 'active' : '' }}"
                        wire:click="setTab('selesai')">Selesai</button>
                    <button class="neo-tab {{ $tab === 'semua' ? 'active' : '' }}"
                        wire:click="setTab('semua')">Semua</button>
                </div>

                {{-- Tabel --}}
                <div class="neo-table-wrap">
                    <div style="overflow-x:auto;">
                        <table class="neo-table">
                            <thead>
                                <tr>
                                    <th>Plat</th>
                                    <th>Jenis</th>
                                    <th>Area</th>
                                    <th>Masuk</th>
                                    <th>Durasi</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->transaksis as $t)
                                    <tr>
                                        <td>
                                            <div class="neo-plat">{{ strtoupper($t->kendaraan->plat_nomor) }}</div>
                                            <div class="neo-sub">{{ $t->kendaraan->pemilik }}</div>
                                        </td>
                                        <td>
                                            <span
                                                class="neo-badge {{ $t->kendaraan->jenis_kendaraan === 'motor' ? 'neo-badge-motor' : 'neo-badge-mobil' }}">
                                                {{ $t->kendaraan->jenis_kendaraan === 'motor' ? '🛵 Motor' : '🚗 Mobil' }}
                                            </span>
                                        </td>
                                        <td style="font-weight:700;">{{ $t->areaParkir->nama_area }}</td>
                                        <td>
                                            <span style="font-weight:700;">{{ $t->waktu_masuk->format('H:i') }}</span>
                                            <div class="neo-sub">{{ $t->waktu_masuk->format('d M') }}</div>
                                        </td>
                                        <td style="font-weight:700;">{{ $t->durasi_format }}</td>
                                        <td>
                                            @if ($t->total_bayar)
                                                <span
                                                    style="font-weight:900;color:#16a34a;">{{ $t->total_bayar_format }}</span>
                                            @else
                                                <span style="color:#d1d5db;font-weight:700;">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="neo-status {{ $t->status === 'masuk' ? 'neo-status-aktif' : 'neo-status-selesai' }}">
                                                {{ $t->status === 'masuk' ? 'Parkir' : 'Selesai' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($t->status === 'masuk')
                                                <button class="neo-btn neo-btn-red neo-btn-sm"
                                                    wire:click="prosesKeluarDariTabel({{ $t->id }})">
                                                    Keluar
                                                </button>
                                            @else
                                                <span style="color:#d1d5db;font-size:12px;font-weight:700;">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <div class="neo-empty">
                                                <div class="neo-empty-icon">📭</div>
                                                <div class="neo-empty-text">Tidak ada transaksi</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($this->transaksis->hasPages())
                        <div style="padding:12px 16px;border-top:2px solid #000;">
                            {{ $this->transaksis->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>


        {{-- ════════════════════════════════════
     MODAL: KENDARAAN MASUK
════════════════════════════════════ --}}
        @if ($showModalMasuk)
            <div class="neo-overlay">
                <div class="neo-modal">
                    <div class="neo-modal-hdr neo-modal-hdr-green">
                        <span class="neo-modal-title"> Kendaraan Masuk</span>
                        <button class="neo-close" wire:click="tutupModalMasuk">✕</button>
                    </div>
                    <div class="neo-modal-body">

                        <div>
                            <label class="neo-label">Plat Nomor <span style="color:red">*</span></label>
                            <input type="text" wire:model.live.debounce.500ms="masuk_plat_nomor"
                                wire:updated.debounce.500ms="cariKendaraanMasuk" placeholder="B 1234 XYZ"
                                class="neo-input" style="text-transform:uppercase;" />
                            @error('masuk_plat_nomor')
                                <p class="neo-error">{{ $message }}</p>
                            @enderror

                            @if ($masuk_plat_nomor && strlen($masuk_plat_nomor) >= 2)
                                @if ($masuk_kendaraan_id)
                                    <div class="neo-info-box neo-info-green" style="margin-top:8px;">
                                        <p style="font-size:12px;font-weight:900;color:#16a34a;">✅ Kendaraan ditemukan —
                                            data otomatis terisi</p>
                                    </div>
                                @elseif ($masuk_kendaraan_baru)
                                    <div class="neo-info-box neo-info-yellow" style="margin-top:8px;">
                                        <p style="font-size:12px;font-weight:900;color:#92400e;">⚠ Kendaraan baru —
                                            lengkapi data di bawah</p>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            <div>
                                <label class="neo-label">Jenis <span style="color:red">*</span></label>
                                <select wire:model.live="masuk_jenis_kendaraan" wire:change="hitungTarifPreview"
                                    class="neo-select" {{ $masuk_kendaraan_id ? 'disabled' : '' }}>
                                    <option value="">Pilih jenis</option>
                                    <option value="motor">🛵 Motor</option>
                                    <option value="mobil">🚗 Mobil</option>
                                </select>
                                @error('masuk_jenis_kendaraan')
                                    <p class="neo-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="neo-label">Warna <span style="color:red">*</span></label>
                                <input type="text" wire:model.live="masuk_warna" placeholder="Merah, Hitam..."
                                    class="neo-input {{ $masuk_kendaraan_id ? 'neo-input-ro' : '' }}"
                                    {{ $masuk_kendaraan_id ? 'readonly' : '' }} />
                                @error('masuk_warna')
                                    <p class="neo-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="neo-label">Nama Pemilik <span style="color:red">*</span></label>
                            <input type="text" wire:model.live="masuk_pemilik" placeholder="Nama lengkap pemilik"
                                class="neo-input {{ $masuk_kendaraan_id ? 'neo-input-ro' : '' }}"
                                {{ $masuk_kendaraan_id ? 'readonly' : '' }} />
                            @error('masuk_pemilik')
                                <p class="neo-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="neo-label">Area Parkir <span style="color:red">*</span></label>
                            <select wire:model.live="masuk_area_id" wire:change="hitungTarifPreview"
                                class="neo-select">
                                <option value="">Pilih area parkir</option>
                                @foreach ($this->areaParkirs as $area)
                                    <option value="{{ $area->id }}"
                                        {{ !$area->masih_tersedia ? 'disabled' : '' }}>
                                        {{ $area->nama_area }} ({{ $area->sisa_slot }}
                                        slot){{ !$area->masih_tersedia ? ' — PENUH' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('masuk_area_id')
                                <p class="neo-error">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($masuk_tarif_preview)
                            <div
                                class="neo-info-box {{ str_contains($masuk_tarif_preview, '⚠') ? 'neo-info-red' : 'neo-info-blue' }}">
                                <p class="neo-info-lbl">Tarif</p>
                                <p style="font-weight:900;font-size:18px;">{{ $masuk_tarif_preview }}</p>
                            </div>
                        @endif

                        <div>
                            <label class="neo-label">Waktu Masuk <span style="color:red">*</span></label>
                            <input type="datetime-local" wire:model.live="masuk_waktu_masuk" class="neo-input" />
                            <p class="neo-helper">Default: sekarang. Ubah jika terlambat input.</p>
                            @error('masuk_waktu_masuk')
                                <p class="neo-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="neo-modal-footer">
                            <button class="neo-btn neo-btn-ghost" wire:click="tutupModalMasuk">Batal</button>
                            <button class="neo-btn neo-btn-green" wire:click="simpanKendaraanMasuk"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="simpanKendaraanMasuk">✓ Simpan & Cetak
                                    Tiket</span>
                                <span wire:loading wire:target="simpanKendaraanMasuk">Menyimpan...</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endif


        {{-- ════════════════════════════════════
     MODAL: CARI KENDARAAN KELUAR
════════════════════════════════════ --}}
        @if ($showModalCari)
            <div class="neo-overlay">
                <div class="neo-modal" style="max-width:520px;">
                    <div class="neo-modal-hdr neo-modal-hdr-red">
                        <span class="neo-modal-title"> Pilih Kendaraan Keluar</span>
                        <button class="neo-close" wire:click="tutupModalCari">✕</button>
                    </div>
                    <div class="neo-modal-body">

                        {{-- Search filter --}}
                        <div>
                            <label class="neo-label">Cari Plat / Pemilik</label>
                            <input type="text" wire:model.live.debounce.300ms="cari_plat_nomor"
                                placeholder="Ketik untuk filter..." class="neo-input"
                                style="text-transform:uppercase;" autofocus />
                        </div>

                        {{-- List transaksi aktif --}}
                        <div>
                            <label class="neo-label" style="margin-bottom:8px;">
                                Kendaraan Sedang Parkir
                                <span style="color:#6b7280;font-weight:700;text-transform:none;letter-spacing:0;">
                                    ({{ $this->transaksiAktifList->count() }} kendaraan)
                                </span>
                            </label>

                            @if ($this->transaksiAktifList->isEmpty())
                                <div class="neo-info-box neo-info-gray" style="text-align:center;padding:2rem;">
                                    <p style="font-size:1.5rem;margin-bottom:6px;">🅿</p>
                                    <p style="font-weight:900;font-size:13px;color:#9ca3af;text-transform:uppercase;">
                                        {{ $cari_plat_nomor ? 'Tidak ditemukan' : 'Tidak ada kendaraan parkir' }}
                                    </p>
                                </div>
                            @else
                                <div
                                    style="display:flex;flex-direction:column;gap:6px;max-height:320px;overflow-y:auto;">
                                    @foreach ($this->transaksiAktifList as $item)
                                        @php
                                            $isSelected = $cari_transaksi_id === $item->id;
                                        @endphp
                                        <button wire:click="pilihTransaksiKeluar({{ $item->id }})"
                                            style="
                                width:100%;
                                text-align:left;
                                border:2px solid {{ $isSelected ? '#16a34a' : '#000' }};
                                background:{{ $isSelected ? '#f0fdf4' : '#fff' }};
                                box-shadow:{{ $isSelected ? '3px 3px 0 #16a34a' : '3px 3px 0 #000' }};
                                padding:12px 14px;
                                cursor:pointer;
                                transition:all .1s;
                                display:flex;
                                align-items:center;
                                justify-content:space-between;
                                gap:12px;
                            ">
                                            {{-- Kiri: plat + pemilik --}}
                                            <div>
                                                <div style="display:flex;align-items:center;gap:8px;">
                                                    <span style="font-weight:900;font-size:15px;">
                                                        {{ strtoupper($item->kendaraan->plat_nomor) }}
                                                    </span>
                                                    <span
                                                        class="neo-badge {{ $item->kendaraan->jenis_kendaraan === 'motor' ? 'neo-badge-motor' : 'neo-badge-mobil' }}"
                                                        style="font-size:10px;padding:1px 6px;">
                                                        {{ $item->kendaraan->jenis_kendaraan === 'motor' ? '🛵' : '🚗' }}
                                                        {{ ucfirst($item->kendaraan->jenis_kendaraan) }}
                                                    </span>
                                                </div>
                                                <div
                                                    style="font-size:12px;font-weight:700;color:#6b7280;margin-top:2px;">
                                                    {{ $item->kendaraan->pemilik }} ·
                                                    {{ $item->areaParkir->nama_area }}
                                                </div>
                                            </div>

                                            {{-- Kanan: durasi + checklist --}}
                                            <div style="text-align:right;flex-shrink:0;">
                                                <div
                                                    style="font-weight:900;font-size:13px;color:{{ $isSelected ? '#16a34a' : '#000' }};">
                                                    {{ $item->durasi_format }}
                                                </div>
                                                <div style="font-size:11px;font-weight:700;color:#9ca3af;">
                                                    masuk {{ $item->waktu_masuk->format('H:i') }}
                                                </div>
                                                @if ($isSelected)
                                                    <div style="font-size:18px;margin-top:2px;">✅</div>
                                                @endif
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Footer --}}
                        <div class="neo-modal-footer">
                            <button class="neo-btn neo-btn-ghost" wire:click="tutupModalCari">Batal</button>
                            <button class="neo-btn neo-btn-red" wire:click="lanjutProsesKeluar"
                                {{ !$cari_transaksi_id ? 'disabled' : '' }}>
                                Lanjut Proses →
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endif


        {{-- ════════════════════════════════════
     SLIDE-OVER: PROSES KELUAR
════════════════════════════════════ --}}
        @if ($showSlideover)
            <div class="neo-slideover-overlay">
                <div class="neo-slideover">

                    <div class="neo-modal-hdr neo-modal-hdr-red" style="flex-shrink:0;">
                        <span class="neo-modal-title">⬆ Proses Keluar</span>
                        <button class="neo-close" wire:click="tutupSlideover">✕</button>
                    </div>

                    <div class="neo-slideover-body">
                        @if ($this->transaksiKeluar)
                            @php $tx = $this->transaksiKeluar; @endphp

                            <div class="neo-info-box neo-info-gray">
                                <p class="neo-info-lbl" style="margin-bottom:8px;">Info Kendaraan</p>
                                <p style="font-weight:900;font-size:1.5rem;margin-bottom:10px;">
                                    {{ strtoupper($tx->kendaraan->plat_nomor) }}
                                </p>
                                <div class="neo-info-grid">
                                    <div>
                                        <p class="neo-info-lbl">Pemilik</p>
                                        <p class="neo-info-val">{{ $tx->kendaraan->pemilik }}</p>
                                    </div>
                                    <div>
                                        <p class="neo-info-lbl">Jenis</p>
                                        <p class="neo-info-val">{{ ucfirst($tx->kendaraan->jenis_kendaraan) }}</p>
                                    </div>
                                    <div>
                                        <p class="neo-info-lbl">Area</p>
                                        <p class="neo-info-val">{{ $tx->areaParkir->nama_area }}</p>
                                    </div>
                                    <div>
                                        <p class="neo-info-lbl">Tarif</p>
                                        <p class="neo-info-val">{{ $tx->tarif_format }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="neo-info-box" style="background:#fff;">
                                <p class="neo-info-lbl" style="margin-bottom:10px;">Kalkulasi Biaya</p>

                                <div class="neo-calc-row">
                                    <span class="neo-calc-lbl">Waktu Masuk</span>
                                    <span class="neo-calc-val">{{ $tx->waktu_masuk->format('H:i, d M Y') }}</span>
                                </div>

                                <div style="padding:10px 0;border-bottom:1px solid #e5e7eb;">
                                    <label class="neo-label">Waktu Keluar</label>
                                    <input type="datetime-local" wire:model.live="keluar_waktu_keluar"
                                        class="neo-input" />
                                    <p class="neo-helper">Ubah jika terlambat input.</p>
                                </div>

                                <div class="neo-calc-row">
                                    <span class="neo-calc-lbl">Durasi</span>
                                    <span class="neo-calc-val">{{ $this->previewDurasi }}</span>
                                </div>

                                <div class="neo-calc-row">
                                    <span class="neo-calc-lbl">Tarif/jam</span>
                                    <span class="neo-calc-val">{{ $tx->tarif_format }}</span>
                                </div>

                                <div
                                    style="display:flex;justify-content:space-between;align-items:center;padding-top:12px;margin-top:4px;border-top:2px solid #000;">
                                    <span class="neo-total-lbl">Total Bayar</span>
                                    <span class="neo-total-val">{{ $this->previewTotalBayar }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="neo-slideover-footer">
                        <button class="neo-btn neo-btn-green" style="justify-content:center;"
                            wire:click="konfirmasiKeluar" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="konfirmasiKeluar">✓ Konfirmasi & Cetak Struk</span>
                            <span wire:loading wire:target="konfirmasiKeluar">Memproses...</span>
                        </button>
                        <button class="neo-btn neo-btn-ghost" style="justify-content:center;"
                            wire:click="tutupSlideover">Batal</button>
                    </div>

                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('buka-cetak', ({
            url
        }) => {
            const a = document.createElement('a');
            a.href = url;
            a.target = '_blank';
            a.rel = 'noopener noreferrer';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });
    });
</script>
