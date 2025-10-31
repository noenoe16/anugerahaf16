<x-layouts.app title="Edit Location">
    <div class="p-6 max-w-2xl space-y-4">
        <h1 class="text-lg font-semibold">Edit Location</h1>
        @php
            $type = request('type','building');
            if ($type==='room') {
                $item = \App\Models\Room::findOrFail(request('id'));
            } else {
                $item = \App\Models\Building::findOrFail(request('id'));
            }
        @endphp
        <form method="POST" action="{{ route('admin.locations.update') }}" class="space-y-3">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="{{ $type }}" />
            <input type="hidden" name="id" value="{{ $item->id }}" />
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" value="{{ $item->name }}" class="w-full border rounded px-2 py-1 dark:bg-zinc-900 dark:border-zinc-700" required />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">Latitude</label>
                    <input name="latitude" type="number" step="0.0000001" value="{{ $item->latitude }}" class="w-full border rounded px-2 py-1 dark:bg-zinc-900 dark:border-zinc-700" required />
                </div>
                <div>
                    <label class="block text-sm mb-1">Longitude</label>
                    <input name="longitude" type="number" step="0.0000001" value="{{ $item->longitude }}" class="w-full border rounded px-2 py-1 dark:bg-zinc-900 dark:border-zinc-700" required />
                </div>
            </div>
            @if ($type==='room')
            <div>
                <label class="block text-sm mb-1">Building</label>
                <select name="building_id" class="w-full border rounded px-2 py-1 dark:bg-zinc-900 dark:border-zinc-700">
                    @foreach(\App\Models\Building::orderBy('name')->get() as $b)
                        <option value="{{ $b->id }}" @selected($item->building_id==$b->id)>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <button class="px-3 py-1.5 rounded bg-zinc-900 text-white dark:bg-white dark:text-black">Update</button>
        </form>
    </div>
</x-layouts.app>


