<x-layouts.app title="Edit CCTV">
    <div class="p-6 max-w-xl">
        <h1 class="text-lg font-semibold mb-4">Edit CCTV</h1>
        @php $c = \App\Models\Cctv::findOrFail(request()->route('cctv')); @endphp
        <form method="POST" action="{{ url('/admin/cctvs/'.request()->route('cctv')) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm mb-1">Building</label>
                <select name="building_id" class="select-3d w-full">
                    <option value="">—</option>
                    @foreach(\App\Models\Building::orderBy('name')->get() as $b)
                        <option value="{{ $b->id }}" @selected($c->building_id == $b->id)>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Room</label>
                <select name="room_id" class="select-3d w-full">
                    <option value="">—</option>
                    @foreach(\App\Models\Room::orderBy('name')->get() as $r)
                        <option value="{{ $r->id }}" @selected($c->room_id == $r->id)>{{ $r->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" value="{{ $c->name }}" class="input-3d w-full" required />
            </div>
            <div>
                <label class="block text-sm mb-1">IP Address (RTSP)</label>
                <input name="ip_address" value="{{ $c->ip_address }}" class="input-3d w-full" required />
            </div>
            <div>
                <label class="block text-sm mb-1">Status</label>
                <select name="status" class="select-3d w-full">
                    <option value="online" @selected($c->status==='online')>Online</option>
                    <option value="offline" @selected($c->status==='offline')>Offline</option>
                    <option value="maintenance" @selected($c->status==='maintenance')>Maintenance</option>
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Location Note</label>
                <input name="location_note" value="{{ $c->location_note }}" class="input-3d w-full" />
            </div>
            <div class="flex items-center gap-2">
                <button class="btn-3d-success">Update</button>
                <a href="{{ route('admin.cctvs.index') }}" class="btn-3d-neutral">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
