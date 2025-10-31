<x-layouts.app title="Edit Marker">
    <div class="p-6 max-w-2xl space-y-4">
        <h1 class="text-lg font-semibold">Edit Marker</h1>
        @php
            $type = request('type', 'building');
            if ($type === 'room') {
                $marker = \App\Models\Room::findOrFail(request('id'));
            } else {
                $marker = \App\Models\Building::findOrFail(request('id'));
            }
        @endphp
        <form method="POST" action="{{ url('/admin/locations') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="{{ $type }}" />
            <input type="hidden" name="id" value="{{ $marker->id }}" />
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" value="{{ $marker->name }}" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" required />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">Latitude</label>
                    <input name="latitude" type="number" step="0.0000001" value="{{ $marker->latitude }}" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" required />
                </div>
                <div>
                    <label class="block text-sm mb-1">Longitude</label>
                    <input name="longitude" type="number" step="0.0000001" value="{{ $marker->longitude }}" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" required />
                </div>
            </div>
            @if ($type === 'room')
            <div>
                <label class="block text-sm mb-1">Building</label>
                <select name="building_id" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm">
                    @foreach(\App\Models\Building::orderBy('name')->get() as $b)
                        <option value="{{ $b->id }}" @selected($marker->building_id==$b->id)>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <button class="px-3 py-1.5 rounded-md bg-zinc-900 text-white dark:bg-white dark:text-black">Update</button>
                    <a href="{{ route('admin.maps.index') }}" class="px-3 py-1.5 rounded-md border border-neutral-300 dark:border-neutral-700">Cancel</a>
                </div>
                <div id="pickMap" class="mt-3 h-64 rounded-lg border border-neutral-200 dark:border-neutral-700"></div>
                <div class="text-xs text-zinc-600">Click on map to set Lat/Lng.</div>
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
        const m = L.map('pickMap').setView([{{ $marker->latitude ?? -6.401 }}, {{ $marker->longitude ?? 108.369 }}], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19}).addTo(m);
        let marker = L.marker([{{ $marker->latitude ?? -6.401 }}, {{ $marker->longitude ?? 108.369 }}], {draggable: true}).addTo(m);
        marker.on('dragend', (e)=> {
            const ll = marker.getLatLng();
            document.querySelector('input[name="latitude"]').value = ll.lat.toFixed(7);
            document.querySelector('input[name="longitude"]').value = ll.lng.toFixed(7);
        });
        m.on('click', (e) => {
            marker.setLatLng(e.latlng);
            document.querySelector('input[name="latitude"]').value = e.latlng.lat.toFixed(7);
            document.querySelector('input[name="longitude"]').value = e.latlng.lng.toFixed(7);
        });
    });
</script>
