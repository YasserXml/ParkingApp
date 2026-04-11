<x-filament-widgets::widget>
<x-filament::section heading="Kapasitas Area Parkir">

<style>
    .kap-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:1rem; }
    .kap-card { border:2px solid #000; padding:14px; background:#fff; box-shadow:3px 3px 0 #000; }
    .kap-name { font-weight:900; font-size:14px; margin-bottom:10px; }
    .kap-bar-wrap { width:100%; height:18px; background:#e5e7eb; border:2px solid #000; box-shadow:2px 2px 0 #000; overflow:hidden; margin-bottom:6px; }
    .kap-bar-fill { height:100%; border-right:2px solid #000; transition:width .3s; }
    .kap-bar-green  { background:#4ade80; }
    .kap-bar-yellow { background:#fde047; }
    .kap-bar-red    { background:#f87171; }
    .kap-meta { display:flex; justify-content:space-between; font-size:11px; font-weight:700; }
    .kap-badge { display:inline-block; padding:2px 8px; border:2px solid #000; font-weight:900; font-size:10px; text-transform:uppercase; margin-top:6px; }
    .kap-badge-green  { background:#4ade80; }
    .kap-badge-yellow { background:#fde047; }
    .kap-badge-red    { background:#f87171; }
</style>

<div class="kap-grid">
    @forelse ($this->areaParkirs as $area)
        @php
            $pct      = $area->kapasitas > 0 ? round(($area->terisi / $area->kapasitas) * 100) : 0;
            $barCls   = $pct >= 100 ? 'kap-bar-red' : ($pct >= 80 ? 'kap-bar-yellow' : 'kap-bar-green');
            $badgeCls = $pct >= 100 ? 'kap-badge-red' : ($pct >= 80 ? 'kap-badge-yellow' : 'kap-badge-green');
            $label    = $pct >= 100 ? 'Penuh' : ($pct >= 80 ? 'Padat' : 'Tersedia');
        @endphp
        <div class="kap-card">
            <div class="kap-name">{{ $area->nama_area }}</div>
            <div class="kap-bar-wrap">
                <div class="kap-bar-fill {{ $barCls }}" style="width:{{ min($pct,100) }}%"></div>
            </div>
            <div class="kap-meta">
                <span>{{ $area->terisi }} / {{ $area->kapasitas }} slot</span>
                <span>{{ $pct }}%</span>
            </div>
            <span class="kap-badge {{ $badgeCls }}">{{ $label }}</span>
        </div>
    @empty
        <p style="color:#9ca3af;font-weight:700;font-size:13px;">Belum ada area parkir.</p>
    @endforelse
</div>

</x-filament::section>
</x-filament-widgets::widget>
