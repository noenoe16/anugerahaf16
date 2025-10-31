<x-layouts.app title="Locations">
    <div class="p-6 space-y-6">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-lg font-semibold">Location List</h1>
            <a href="{{ route('admin.locations.create') }}" class="btn-3d-primary" wire:navigate>Create</a>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h2 class="font-semibold mb-2">Buildings</h2>
                <div class="overflow-x-auto rounded-2xl border border-neutral-200 dark:border-neutral-700 ui-3d-card">
                    <div class="ui-3d-rail"></div>
                    <table class="min-w-full text-sm">
                        <thead class="bg-zinc-50/90 dark:bg-zinc-900/80">
                            <tr>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Name</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Lat</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Lng</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Building::orderBy('name')->get() as $b)
                                <tr class="border-t border-neutral-200/70 dark:border-neutral-700/70 hover:bg-white/50 dark:hover:bg-white/5">
                                    <td class="p-3 font-semibold">{{ $b->name }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $b->latitude }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $b->longitude }}</td>
                                    <td class="p-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.locations.edit', ['type'=>'building','id'=>$b->id]) }}" class="btn-3d-square-info" title="Edit" wire:navigate>
                                                <flux:icon.pencil class="size-4" />
                                            </a>
                                            <form method="POST" action="{{ url('/admin/buildings/'.$b->id) }}" onsubmit="return confirm('Delete building?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-3d-square-danger" title="Delete">
                                                    <flux:icon.trash class="size-4" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-4 text-center text-zinc-600 dark:text-zinc-400" colspan="4">No buildings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h2 class="font-semibold mb-2">Rooms & CCTV</h2>
                <div class="overflow-x-auto rounded-2xl border border-neutral-200 dark:border-neutral-700 ui-3d-card">
                    <div class="ui-3d-rail"></div>
                    <table class="min-w-full text-sm">
                        <thead class="bg-zinc-50/90 dark:bg-zinc-900/80">
                            <tr>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Building</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Room</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">CCTVs</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Room::with(['building','cctvs'])->orderBy('name')->get() as $r)
                                <tr class="border-t border-neutral-200/70 dark:border-neutral-700/70 hover:bg-white/50 dark:hover:bg-white/5">
                                    <td class="p-3 font-semibold">{{ $r->building?->name }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $r->name }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">
                                        @forelse($r->cctvs as $c)
                                            <div>{{ $c->name }} ({{ $c->status }})</div>
                                        @empty
                                            <div class="text-zinc-500">—</div>
                                        @endforelse
                                    </td>
                                    <td class="p-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.locations.edit', ['type'=>'room','id'=>$r->id]) }}" class="btn-3d-square-info" title="Edit" wire:navigate>
                                                <flux:icon.pencil class="size-4" />
                                            </a>
                                            <form method="POST" action="{{ url('/admin/rooms/'.$r->id) }}" onsubmit="return confirm('Delete room?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-3d-square-danger" title="Delete">
                                                    <flux:icon.trash class="size-4" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-4 text-center text-zinc-600 dark:text-zinc-400" colspan="4">No rooms found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
