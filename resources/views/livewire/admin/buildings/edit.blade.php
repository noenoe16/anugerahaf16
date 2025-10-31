<x-layouts.app title="Edit Building">
    <div class="p-6 max-w-xl">
        <h1 class="text-lg font-semibold mb-4">Edit Building</h1>
        <form method="POST" action="{{ url('/admin/buildings/'.request()->route('building')) }}" class="space-y-4">
            @csrf
            @method('PUT')
            @php $b = \App\Models\Building::findOrFail(request()->route('building')); @endphp
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" value="{{ $b->name }}" class="input-3d w-full" required />
            </div>
            <div>
                <label class="block text-sm mb-1">Code</label>
                <input name="code" value="{{ $b->code }}" class="input-3d w-full" />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">Latitude</label>
                    <input name="latitude" type="number" step="0.0000001" value="{{ $b->latitude }}" class="input-3d w-full" />
                </div>
                <div>
                    <label class="block text-sm mb-1">Longitude</label>
                    <input name="longitude" type="number" step="0.0000001" value="{{ $b->longitude }}" class="input-3d w-full" />
                </div>
            </div>
            <div>
                <label class="block text-sm mb-1">Address</label>
                <textarea name="address" class="input-3d w-full">{{ $b->address }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <button class="btn-3d-success">Update</button>
                <a href="{{ route('admin.buildings.index') }}" class="btn-3d-neutral">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>


