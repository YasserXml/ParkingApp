@php
    $kapasitas = $getRecord()->kapasitas ?? 0;
    $terisi    = $getRecord()->terisi ?? 0;
    $persen    = $kapasitas > 0 ? round(($terisi / $kapasitas) * 100) : 0;

    $warna = match (true) {
        $persen >= 100 => 'bg-red-500',
        $persen >= 80  => 'bg-yellow-400',
        default        => 'bg-green-500',
    };

    $border = match (true) {
        $persen >= 100 => 'border-red-600',
        $persen >= 80  => 'border-yellow-500',
        default        => 'border-green-600',
    };
@endphp

<div class="w-full min-w-[120px]">
    {{-- Label persentase --}}
    <div class="flex justify-between items-center mb-1">
        <span class="text-xs font-black tracking-wide" style="font-weight: 900;">
            {{ $terisi }} / {{ $kapasitas }}
        </span>
        <span class="text-xs font-bold">{{ $persen }}%</span>
    </div>

    {{-- Progress bar neobrutalism style --}}
    <div
        class="w-full h-4 bg-gray-200 border-2 border-black"
        style="box-shadow: 2px 2px 0px #000;"
    >
        <div
            class="{{ $warna }} {{ $border }} h-full border-r-2 transition-all duration-300"
            style="width: {{ min($persen, 100) }}%;"
        ></div>
    </div>
</div>
