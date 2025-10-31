<x-layouts.app title="Create CCTV">
    <div class="p-6 max-w-xl">
        <h1 class="text-lg font-semibold mb-4">Create CCTV</h1>
        <form method="POST" action="{{ url('/admin/cctvs') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Building</label>
                <select name="building_id" class="select-3d w-full">
                    <option value="">—</option>
                    @foreach(\App\Models\Building::orderBy('name')->get() as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Room</label>
                <select name="room_id" class="select-3d w-full">
                    <option value="">—</option>
                    @foreach(\App\Models\Room::orderBy('name')->get() as $r)
                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" class="input-3d w-full" required />
            </div>
            <div>
                <label class="block text-sm mb-1">IP Address (RTSP)</label>
                <input name="ip_address" placeholder="rtsp://..." class="input-3d w-full" required />
            </div>
            <div>
                <label class="block text-sm mb-1">Status</label>
                <select name="status" class="select-3d w-full">
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Location Note</label>
                <input name="location_note" class="input-3d w-full" />
            </div>
            <div class="flex items-center gap-2">
                <button class="btn-3d-success">Save</button>
                <a href="{{ route('admin.cctvs.index') }}" class="btn-3d-neutral">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
