<x-layouts.app title="CCTV">
    <div class="p-6 space-y-4">
        @php($roomId = request('room'))
        @php($roomModel = $roomId ? \App\Models\Room::find($roomId) : null)
        @php($backUrl = $roomModel ? route('user.locations.building', ['building' => $roomModel->building_id]) : route('user.locations'))
        <div class="flex items-center gap-3">
            <h1 class="text-lg font-semibold">CCTV</h1>
            <div class="ml-auto flex items-center gap-2">
                <a href="{{ $backUrl }}" class="btn-3d-primary text-sm">&larr; Kembali</a>
                <a href="{{ $backUrl }}" class="btn-3d-success text-white text-sm">Kembali ke Gedung</a>
                <button data-status="all" class="px-3 py-1 rounded-full bg-zinc-900 text-white text-sm">Semua</button>
                <button data-status="online" class="size-6 rounded-full border-2 border-black/10 ring-2 ring-white/50" style="background:#16a34a" title="Online"></button>
                <button data-status="offline" class="size-6 rounded-full border-2 border-black/10 ring-2 ring-white/50" style="background:#dc2626" title="Offline"></button>
                <button data-status="maintenance" class="size-6 rounded-full border-2 border-black/10 ring-2 ring-white/50" style="background:#eab308" title="Maintenance"></button>
            </div>
        </div>

        @php($items = \App\Models\Cctv::with(['building:id,name', 'room:id,name,building_id'])->when($roomId, fn($q)=>$q->where('room_id', $roomId))->orderBy('name')->get())

        <div id="grid" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($items as $c)
                <div class="cctv-card ui-3d-card p-4 flex flex-col min-h-[300px]" data-status="{{ $c->status }}" data-text="{{ strtolower($c->name.' '.optional($c->building)->name.' '.optional($c->room)->name) }}">
                    <div class="ui-3d-rail mb-3"></div>
                    <img src="/images/kilang1.jpg" alt="{{ $c->name }}" class="aspect-video w-full rounded-lg border border-neutral-200 object-cover dark:border-neutral-700">
                    <div class="mt-3 text-center">
                        <div class="text-lg font-semibold">{{ $c->name }}</div>
                        <div class="text-sm text-zinc-600">{{ optional($c->building)->name ?? '-' }} • {{ optional($c->room)->name ?? '-' }}</div>
                    </div>
                    <div class="mt-auto flex items-center justify-center pt-3">
                        <a href="{{ route('user.cctv.show', $c->id) }}" class="btn-3d-success text-center">
                            Live CCTV
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="cctvModal" class="fixed inset-0 hidden items-center justify-center bg-black/70 p-4">
        <div class="w-full max-w-4xl rounded-xl bg-white shadow-xl dark:bg-zinc-900">
            <div class="flex items-center justify-between rounded-t-xl bg-blue-700 px-4 py-2 text-white">
                <div id="modalTitle" class="font-semibold">Live CCTV</div>
                <button id="modalClose" class="text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="p-4">
                <video id="modalPlayer" controls playsinline class="w-full rounded-lg bg-black" style="aspect-ratio:16/9"></video>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/hls.js@1"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cards = Array.from(document.querySelectorAll('.cctv-card'));
            let active = new Set(['online','offline','maintenance']);
            function apply() {
                const q = '';
                cards.forEach(el => {
                    const matchText = el.dataset.text.includes(q);
                    const matchStatus = active.has(el.dataset.status);
                    el.classList.toggle('hidden', !(matchText && matchStatus));
                });
            }
            
            document.querySelectorAll('[data-status]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const s = btn.dataset.status;
                    if (s === 'all') { active = new Set(['online','offline','maintenance']); }
                    else {
                        if (active.has(s)) active.delete(s); else active.add(s);
                        if (active.size === 0) active = new Set(['online','offline','maintenance']);
                    }
                    apply();
                });
            });
            apply();

            // Modal player open/close
            const modal = document.getElementById('cctvModal');
            const title = document.getElementById('modalTitle');
            const video = document.getElementById('modalPlayer');
            document.getElementById('modalClose').addEventListener('click', closeModal);
            function openModal(name, ip) {
                title.textContent = name;
                try {
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
                } catch (_) {}
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            function closeModal() {
                if (video._hls) { video._hls.destroy(); }
                video.pause();
                video.removeAttribute('src');
                video.load();
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            document.querySelectorAll('.btn-watch').forEach(btn => {
                btn.addEventListener('click', () => openModal(btn.dataset.name, btn.dataset.ip));
            });
        });
    </script>
</x-layouts.app>


