<x-layouts.app title="Create Location">
    <div class="p-6 max-w-2xl space-y-4">
        <h1 class="text-lg font-semibold">Create Location</h1>
        <form method="POST" action="{{ route('admin.locations.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm mb-1">Type</label>
                <select name="type" class="w-full border rounded px-2 py-1 dark:bg-zinc-900 dark:border-zinc-700">
                    <option value="building">Building</option>
                    <option value="room">Room</option>
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" class="w-full border rounded px-2 py-1 dark:bg-zinc-900 dark:border-zinc-700" required />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">Latitude</label>
                    <input name="latitude" type="number" step="0.0000001" class="w-full border rounded px-2 py-1 dark:bg-zinc-900 dark:border-zinc-700" required />
                </div>
                <div>
                    <label class="block text-sm mb-1">Longitude</label>
                    <input name="longitude" type="number" step="0.0000001" class="w-full border rounded px-2 py-1 dark:bg-zinc-900 dark:border-zinc-700" required />
                </div>
            </div>
            <div>
                <label class="block text-sm mb-1">Building (for Room)</label>
                <select name="building_id" class="w-full border rounded px-2 py-1 dark:bg-zinc-900 dark:border-zinc-700">
                    <option value="">—</option>
                    @foreach(\App\Models\Building::orderBy('name')->get() as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="px-3 py-1.5 rounded bg-zinc-900 text-white dark:bg-white dark:text-black">Save</button>
        </form>
    </div>
</x-layouts.app>
