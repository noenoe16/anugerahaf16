<x-layouts.app title="Rooms">
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-lg font-semibold">Rooms</h1>
            <div class="ml-auto flex items-center gap-2">
                <a href="{{ route('user.locations') }}" class="btn-3d-primary text-sm" wire:navigate>Kembali</a>

                <div class="relative" id="searchWrap">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-zinc-500 pointer-events-none" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <input id="q" placeholder="Cari ruangan..." class="input-3d w-[200px] sm:w-[240px] pl-8" />
                    <div id="searchPanel" class="search-panel-3d" hidden></div>
                </div>
                <button id="searchBtn" class="btn-3d-primary text-sm flex items-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="white" stroke-width="2"/><path d="M20 20l-3.5-3.5" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>Pencarian</span>
                </button>
            </div>
        </div>

        @php($rooms = \App\Models\Room::with('building:id,name')->orderBy('name')->get())
        <div id="list" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($rooms as $r)
                <a href="{{ route('user.locations.room', ['building' => $r->building_id, 'room' => $r->id]) }}" class="ui-3d-card p-4 block" data-text="{{ strtolower($r->name.' '.optional($r->building)->name) }}" wire:navigate>
                    <div class="ui-3d-rail mb-2"></div>
                    <div class="text-xs text-zinc-500">{{ optional($r->building)->name ?? '-' }}</div>
                    <div class="mt-1 text-lg font-semibold">{{ $r->name }}</div>
                </a>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const list = document.getElementById('list');
            const items = Array.from(list.querySelectorAll('[data-text]'));
            const input = document.getElementById('q');
            const panel = document.getElementById('searchPanel');
            const btn = document.getElementById('searchBtn');

            const hrefMap = new Map(items.map(el => [el.dataset.text, el.getAttribute('href')]));

            const debounce = (fn, ms = 250) => { let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); }; };

            function filterList(value) {
                const v = (value || '').toLowerCase().trim();
                items.forEach(el => el.classList.toggle('hidden', v && !el.dataset.text.includes(v)));
            }

            function buildPanel(value) {
                if (!panel) return;
                const v = (value || '').toLowerCase().trim();
                panel.innerHTML = '';
                if (!v) { panel.hidden = true; return; }
                const matches = items
                    .map(el => el.dataset.text)
                    .filter(t => t.includes(v))
                    .slice(0, 7);
                if (matches.length === 0) { panel.hidden = true; return; }
                matches.forEach(t => {
                    const b = document.createElement('button');
                    b.type = 'button';
                    b.className = 'dd-item';
                    b.textContent = t;
                    b.addEventListener('click', () => {
                        const href = hrefMap.get(t);
                        if (href) { window.location.href = href; }
                    });
                    panel.appendChild(b);
                });
                panel.hidden = false;
            }

            const update = debounce((val) => { filterList(val); buildPanel(val); }, 200);

            input.addEventListener('input', (e) => update(e.target.value));
            btn.addEventListener('click', () => update(input.value));
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') { panel.hidden = true; }
                if (e.key === 'Enter') { update(input.value); }
            });
            document.addEventListener('click', (e) => {
                if (!document.getElementById('searchWrap').contains(e.target)) {
                    panel.hidden = true;
                }
            });
        })
    </script>
</x-layouts.app>


