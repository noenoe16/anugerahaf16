<x-layouts.app title="Maps">
    <div class="p-6 space-y-6">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-lg font-semibold">Markers</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.export.buildings') }}" class="btn-3d-primary" wire:navigate>Export Buildings XLSX</a>
                <a href="{{ route('admin.export.rooms') }}" class="btn-3d-info" wire:navigate>Export Rooms XLSX</a>
                <a href="{{ route('admin.export.cctvs') }}" class="btn-3d-success" wire:navigate>Export CCTVs XLSX</a>
                <a href="{{ route('admin.maps.create') }}" class="btn-3d-warning" wire:navigate>Create Marker</a>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h2 class="font-semibold mb-2">Building Markers</h2>
                <div class="overflow-x-auto rounded-2xl border border-neutral-200 dark:border-neutral-700 ui-3d-card">
                    <div class="ui-3d-rail"></div>
                    <table class="min-w-full text-sm">
                        <thead class="bg-zinc-50/90 dark:bg-zinc-900/80">
                            <tr>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Name</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Code</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Lat</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Lng</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Building::orderBy('name')->get() as $b)
                                <tr class="border-t border-neutral-200/70 dark:border-neutral-700/70 hover:bg-white/50 dark:hover:bg-white/5">
                                    <td class="p-3 font-semibold">{{ $b->name }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $b->code }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $b->latitude }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $b->longitude }}</td>
                                    <td class="p-3">
                                        <a href="{{ route('admin.buildings.edit', $b) }}" class="btn-3d-square-info" title="Edit" wire:navigate>
                                            <flux:icon.pencil class="size-4" />
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-6 text-center text-zinc-600 dark:text-zinc-400" colspan="5">No building markers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h2 class="font-semibold mb-2">Room Markers</h2>
                <div class="overflow-x-auto rounded-2xl border border-neutral-200 dark:border-neutral-700 ui-3d-card">
                    <div class="ui-3d-rail"></div>
                    <table class="min-w-full text-sm">
                        <thead class="bg-zinc-50/90 dark:bg-zinc-900/80">
                            <tr>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Building</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Room</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Code</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Lat</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Lng</th>
                                <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Room::with('building')->orderBy('name')->get() as $r)
                                <tr class="border-t border-neutral-200/70 dark:border-neutral-700/70 hover:bg-white/50 dark:hover:bg-white/5">
                                    <td class="p-3 font-semibold">{{ $r->building?->name }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $r->name }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $r->code }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $r->latitude }}</td>
                                    <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $r->longitude }}</td>
                                    <td class="p-3">
                                        <a href="{{ route('admin.rooms.edit', $r) }}" class="btn-3d-square-info" title="Edit" wire:navigate>
                                            <flux:icon.pencil class="size-4" />
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-6 text-center text-zinc-600 dark:text-zinc-400" colspan="6">No room markers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
