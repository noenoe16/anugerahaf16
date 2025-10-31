<x-layouts.app title="CCTVs">
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-lg font-semibold flex items-center gap-2">
                <span class="inline-grid place-content-center size-6 rounded-lg bg-gradient-to-br from-emerald-500 to-green-600 text-white shadow">📹</span>
                <span>CCTVs</span>
            </h1>
            <a href="{{ route('admin.cctvs.create') }}" class="btn-3d-primary" wire:navigate>New CCTV</a>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-neutral-200 dark:border-neutral-700 ui-3d-card">
            <div class="ui-3d-rail"></div>
            <table class="min-w-full text-sm">
                <thead class="bg-zinc-50/90 dark:bg-zinc-900/80">
                    <tr>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">ID</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Name</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Room</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">IP</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Status</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Cctv::with('room')->orderBy('name')->get() as $c)
                        <tr class="border-t border-neutral-200/70 dark:border-neutral-700/70 hover:bg-white/50 dark:hover:bg-white/5">
                            <td class="p-3 font-medium text-zinc-700 dark:text-zinc-200">{{ $c->id }}</td>
                            <td class="p-3 font-semibold">{{ $c->name }}</td>
                            <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $c->room?->name }}</td>
                            <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $c->ip_address }}</td>
                            <td class="p-3">
                                @php $statusColor = match($c->status){'online'=>'bg-green-600','offline'=>'bg-rose-600','maintenance'=>'bg-amber-500',default=>'bg-zinc-500'}; @endphp
                                <span class="inline-flex items-center gap-1 text-xs">
                                    <span class="size-2 rounded-full {{ $statusColor }}"></span>
                                    {{ ucfirst($c->status) }}
                                </span>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.cctvs.edit', $c) }}" class="btn-3d-square-info" title="Edit" wire:navigate>
                                        <flux:icon.pencil class="size-4" />
                                    </a>
                                    <form method="POST" action="{{ url('/admin/cctvs/'.$c->id) }}" onsubmit="return confirm('Delete CCTV?')">
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
                            <td class="p-6 text-center text-zinc-600 dark:text-zinc-400" colspan="6">No CCTVs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
