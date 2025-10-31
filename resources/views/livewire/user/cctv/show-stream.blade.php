@php($cctv = \App\Models\Cctv::with(['building:id,name','room:id,name,building_id'])->findOrFail($id))

<x-layouts.app :title="$cctv->name">
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm text-zinc-500">{{ optional($cctv->building)->name }} {{ optional($cctv->room)->name ? '• '.optional($cctv->room)->name : '' }}</div>
                <h1 class="text-lg font-semibold">{{ $cctv->name }}</h1>
            </div>
            @php($buildingId = optional($cctv->room)->building_id ?? $cctv->building_id ?? optional($cctv->building)->id)
            <div class="flex items-center gap-2">
                <a href="{{ route('user.cctv.index', ['room' => optional($cctv->room)->id]) }}" class="btn-3d-primary text-sm">&larr; Kembali</a>
                @if($buildingId)
                    <a href="{{ route('user.locations.building', ['building' => $buildingId]) }}" class="btn-3d-success text-white text-sm">Kembali ke Gedung</a>
                @endif
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-4">
            <video id="hlsPlayer" controls playsinline class="w-full rounded-lg bg-black" style="aspect-ratio:16/9"></video>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/hls.js@1"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const video = document.getElementById('hlsPlayer');
            try {
                const ip = @json($cctv->ip_address);
                const host = (new URL(ip)).hostname || ip;
                const safe = host.replaceAll('.', '_').replaceAll(':','_').replaceAll('@','_');
                const src = `/live/${safe}.m3u8`;
                if (Hls.isSupported()) {
                    const hls = new Hls();
                    hls.loadSource(src);
                    hls.attachMedia(video);
                    hls.on(Hls.Events.MANIFEST_PARSED, function() { video.play(); });
                    video._hls = hls;
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    video.src = src;
                    video.play();
                } else {
                    video.innerHTML = 'HLS not supported in this browser.';
                }
            } catch (e) {}
        });
    </script>
</x-layouts.app>


