<x-layouts.app :title="$building->name">
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold">{{ $building->name }}</h1>
            <a href="{{ route('user.locations') }}" class="btn-3d-primary text-sm">&larr; Kembali</a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @php($rooms = \App\Models\Room::where('building_id', $building->id)->orderBy('name')->get())
            @forelse($rooms as $room)
                <div class="ui-3d-card p-4 flex flex-col items-center text-center">
                    <div class="ui-3d-rail mb-2"></div>
                    <div class="text-xs text-zinc-500">Room</div>
                    <div class="mt-1 text-lg font-semibold mb-3">{{ $room->name }}</div>
                    <div class="flex items-center justify-center">
                        <a href="{{ route('user.cctv.index', ['room' => $room->id]) }}" class="btn-3d-success text-center">
                            Live CCTV
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-zinc-600">Tidak ada ruangan pada gedung ini.</div>
            @endforelse
        </div>
    </div>
</x-layouts.app>


