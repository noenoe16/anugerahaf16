<x-layouts.app title="Create Room">
    <div class="p-6 max-w-xl">
        <h1 class="text-lg font-semibold mb-4">Create Room</h1>
        <form method="POST" action="{{ url('/admin/rooms') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Building</label>
                <select name="building_id" class="select-3d w-full" required>
                    @foreach(\App\Models\Building::orderBy('name')->get() as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" class="input-3d w-full" required />
            </div>
            <div>
                <label class="block text-sm mb-1">Code</label>
                <input name="code" class="input-3d w-full" />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">Latitude</label>
                    <input name="latitude" type="number" step="0.0000001" class="input-3d w-full" />
                </div>
                <div>
                    <label class="block text-sm mb-1">Longitude</label>
                    <input name="longitude" type="number" step="0.0000001" class="input-3d w-full" />
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button class="btn-3d-success">Save</button>
                <a href="{{ route('admin.rooms.index') }}" class="btn-3d-neutral">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>

