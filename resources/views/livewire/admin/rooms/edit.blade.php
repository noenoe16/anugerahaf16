<x-layouts.app title="Edit Room">
    <div class="p-6 max-w-xl">
        <h1 class="text-lg font-semibold mb-4">Edit Room</h1>
        @php $r = \App\Models\Room::findOrFail(request()->route('room')); @endphp
        <form method="POST" action="{{ url('/admin/rooms/'.request()->route('room')) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm mb-1">Building</label>
                <select name="building_id" class="select-3d w-full" required>
                    @foreach(\App\Models\Building::orderBy('name')->get() as $b)
                        <option value="{{ $b->id }}" @selected($r->building_id == $b->id)>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" value="{{ $r->name }}" class="input-3d w-full" required />
            </div>
            <div>
                <label class="block text-sm mb-1">Code</label>
                <input name="code" value="{{ $r->code }}" class="input-3d w-full" />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">Latitude</label>
                    <input name="latitude" type="number" step="0.0000001" value="{{ $r->latitude }}" class="input-3d w-full" />
                </div>
                <div>
                    <label class="block text-sm mb-1">Longitude</label>
                    <input name="longitude" type="number" step="0.0000001" value="{{ $r->longitude }}" class="input-3d w-full" />
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button class="btn-3d-success">Update</button>
                <a href="{{ route('admin.rooms.index') }}" class="btn-3d-neutral">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>

