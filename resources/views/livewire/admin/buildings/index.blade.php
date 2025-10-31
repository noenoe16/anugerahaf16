<x-layouts.app title="Buildings">
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-lg font-semibold flex items-center gap-2">
                <span class="inline-grid place-content-center size-6 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow">🏢</span>
                <span>Buildings</span>
            </h1>
            <a href="{{ route('admin.buildings.create') }}" class="btn-3d-primary" wire:navigate>New Building</a>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-neutral-200 dark:border-neutral-700 ui-3d-card">
            <div class="ui-3d-rail"></div>
            <table class="min-w-full text-sm">
                <thead class="bg-zinc-50/90 dark:bg-zinc-900/80">
                    <tr>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">ID</th>
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
                            <td class="p-3 font-medium text-zinc-700 dark:text-zinc-200">{{ $b->id }}</td>
                            <td class="p-3 font-semibold">{{ $b->name }}</td>
                            <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $b->code }}</td>
                            <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $b->latitude }}</td>
                            <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $b->longitude }}</td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.buildings.edit', $b) }}" class="btn-3d-square-info" title="Edit" wire:navigate>
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
                            <td class="p-6 text-center text-zinc-600 dark:text-zinc-400" colspan="6">No buildings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
