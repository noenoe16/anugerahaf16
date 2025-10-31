<x-layouts.app title="Rooms">
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-lg font-semibold flex items-center gap-2">
                <span class="inline-grid place-content-center size-6 rounded-lg bg-gradient-to-br from-sky-500 to-cyan-600 text-white shadow">🗂️</span>
                <span>Rooms</span>
            </h1>
            <a href="{{ route('admin.rooms.create') }}" class="btn-3d-primary" wire:navigate>New Room</a>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-neutral-200 dark:border-neutral-700 ui-3d-card">
            <div class="ui-3d-rail"></div>
            <table class="min-w-full text-sm">
                <thead class="bg-zinc-50/90 dark:bg-zinc-900/80">
                    <tr>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">ID</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Building</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Name</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Code</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Room::with('building')->orderBy('name')->get() as $r)
                        <tr class="border-t border-neutral-200/70 dark:border-neutral-700/70 hover:bg-white/50 dark:hover:bg-white/5">
                            <td class="p-3 font-medium text-zinc-700 dark:text-zinc-200">{{ $r->id }}</td>
                            <td class="p-3 font-semibold">{{ $r->building?->name }}</td>
                            <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $r->name }}</td>
                            <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $r->code }}</td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.rooms.edit', $r) }}" class="btn-3d-square-info" title="Edit" wire:navigate>
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
                            <td class="p-6 text-center text-zinc-600 dark:text-zinc-400" colspan="5">No rooms found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
