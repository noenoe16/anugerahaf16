<x-layouts.app title="Create Marker">
    <div class="p-6 max-w-2xl space-y-4">
        <h1 class="text-lg font-semibold">Create Marker</h1>
        <form method="POST" action="{{ url('/admin/locations') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Type</label>
                <select name="type" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm">
                    <option value="building">Building</option>
                    <option value="room">Room</option>
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" required />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">Latitude</label>
                    <input name="latitude" type="number" step="0.0000001" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" required />
                </div>
                <div>
                    <label class="block text-sm mb-1">Longitude</label>
                    <input name="longitude" type="number" step="0.0000001" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" required />
                </div>
            </div>
            <div>
                <label class="block text-sm mb-1">Building (for Room)</label>
                <select name="building_id" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm">
                    <option value="">—</option>
                    @foreach(\App\Models\Building::orderBy('name')->get() as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <button class="px-3 py-1.5 rounded-md bg-zinc-900 text-white dark:bg-white dark:text-black">Save</button>
                    <a href="{{ route('admin.maps.index') }}" class="px-3 py-1.5 rounded-md border border-neutral-300 dark:border-neutral-700">Cancel</a>
                </div>
                <div id="pickMap" class="mt-3 h-64 rounded-lg border border-neutral-200 dark:border-neutral-700"></div>
                <div class="text-xs text-zinc-600">Click map or drag marker to set Lat/Lng.</div>
            </div>
        </form>
    </div>
</x-layouts.app>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const el = document.getElementById('pickMap');
        if (!el) return;
        const latEl = document.querySelector('input[name="latitude"]');
        const lngEl = document.querySelector('input[name="longitude"]');
        const dLat = parseFloat(latEl.value) || -6.401;
        const dLng = parseFloat(lngEl.value) || 108.369;
        if (!latEl.value) latEl.value = dLat.toFixed(7);
        if (!lngEl.value) lngEl.value = dLng.toFixed(7);
        const m = L.map('pickMap').setView([dLat, dLng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19}).addTo(m);
        let marker = L.marker([dLat, dLng], {draggable: true}).addTo(m);
        marker.on('dragend', () => {
            const ll = marker.getLatLng();
            latEl.value = ll.lat.toFixed(7);
            lngEl.value = ll.lng.toFixed(7);
        });
        m.on('click', (e) => {
            marker.setLatLng(e.latlng);
            latEl.value = e.latlng.lat.toFixed(7);
            lngEl.value = e.latlng.lng.toFixed(7);
        });
    });
</script>
