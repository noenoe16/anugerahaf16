<x-layouts.app title="Locations">
    <div class="p-6">
        <div class="mb-4 flex items-center gap-2">
            <h1 class="text-2xl font-semibold tracking-tight">Locations</h1>
            <div class="ml-auto relative" id="locSearchWrap">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-zinc-500 pointer-events-none" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input id="searchBuilding" placeholder="Cari gedung..." class="input-3d w-[240px] pl-8" />
                <div id="locSearchPanel" class="search-panel-3d" hidden></div>
            </div>
        </div>

        <div class="space-y-2">
            
            @php($desiredBuildings = [
                'Gedung Kolaboratif','Gerbang Utama','AWI','Shelter Maintenance Area 1','Shelter Maintenance Area 2','Shelter Maintenance Area 3','Shelter Maintenance Area 4','Shelter White OM','Pintu Masuk Area Kilang Pertamina','Marine Region III Pertamina Balongan','Main Control Room','Tank Farm Area 1','Gedung EXOR','Area Produksi Crude Distillation Unit (CDU)','HSSE Demo Room','Gedung Amanah','POC','JGC',
            ])
            @php($buildings = \App\Models\Building::whereIn('name', $desiredBuildings)->orderBy('name')->get())
            <div id="buildingList" class="grid gap-6 md:grid-cols-3">
                @foreach($buildings as $b)
                    <div class="building-card ui-3d-card p-6 flex flex-col items-center justify-center text-center min-h-[160px]" data-name="{{ strtolower($b->name) }}">
                        <div class="ui-3d-rail mb-4"></div>
                        <div class="text-lg font-semibold mb-3">{{ $b->name }}</div>
                        <div class="flex items-center justify-center">
                            <a href="{{ route('user.locations.building', $b->id) }}" class="btn-3d-success text-center">
                                Room
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cards = Array.from(document.querySelectorAll('#buildingList [data-name]'));
            const input = document.getElementById('searchBuilding');
            const wrap = document.getElementById('locSearchWrap');
            const panel = document.getElementById('locSearchPanel');

            const names = cards.map(c => c.dataset.name);
            const debounce = (fn, ms = 250) => { let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); }; };

            function apply(v) {
                const q = (v || '').toLowerCase().trim();
                cards.forEach(card => card.classList.toggle('hidden', q && !card.dataset.name.includes(q)));
            }
            function buildPanel(v) {
                const q = (v || '').toLowerCase().trim();
                panel.innerHTML = '';
                if (!q) { panel.hidden = true; return; }
                const matches = names.filter(n => n.includes(q)).slice(0, 8);
                if (matches.length === 0) { panel.hidden = true; return; }
                matches.forEach(n => {
                    const b = document.createElement('button');
                    b.type = 'button';
                    b.className = 'dd-item';
                    b.textContent = n;
                    b.addEventListener('click', () => {
                        input.value = n; apply(n); panel.hidden = true;
                    });
                    panel.appendChild(b);
                });
                panel.hidden = false;
            }
            const update = debounce((val) => { apply(val); buildPanel(val); }, 200);

            input.addEventListener('input', (e) => update(e.target.value));
            input.addEventListener('keydown', (e) => { if (e.key === 'Escape') panel.hidden = true; });
            document.addEventListener('click', (e) => { if (!wrap.contains(e.target)) panel.hidden = true; });
        });
    </script>
</x-layouts.app>
