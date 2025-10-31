<x-layouts.app title="User List">
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-lg font-semibold flex items-center gap-2">
                <span class="inline-grid place-content-center size-6 rounded-lg bg-gradient-to-br from-amber-500 to-yellow-600 text-white shadow">👤</span>
                <span>User List</span>
            </h1>
            <a href="{{ route('admin.users.create') }}" class="btn-3d-primary" wire:navigate>New User</a>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-neutral-200 dark:border-neutral-700 ui-3d-card">
            <div class="ui-3d-rail"></div>
            <table class="min-w-full text-sm">
                <thead class="bg-zinc-50/90 dark:bg-zinc-900/80">
                    <tr>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Name</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Email</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Role</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Status</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Last Seen</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\User::orderBy('name')->get() as $u)
                        @php $online = $u->last_seen_at && now()->diffInMinutes($u->last_seen_at) <= 5; @endphp
                        <tr class="border-t border-neutral-200/70 dark:border-neutral-700/70 hover:bg-white/50 dark:hover:bg-white/5">
                            <td class="p-3 font-semibold">{{ $u->name }}</td>
                            <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $u->email }}</td>
                            <td class="p-3">{{ strtoupper($u->role ?? 'user') }}</td>
                            <td class="p-3">
                                <span class="inline-flex items-center gap-1 text-sm">
                                    <span class="size-2 rounded-full {{ $online ? 'bg-green-600' : 'bg-zinc-400' }}"></span>
                                    {{ $online ? 'Online' : 'Offline' }}
                                </span>
                            </td>
                            <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $u->last_seen_at?->diffForHumans() ?? '—' }}</td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $u) }}" class="btn-3d-square-info" title="Edit" wire:navigate>
                                        <flux:icon.pencil class="size-4" />
                                    </a>
                                    <form method="POST" action="{{ url('/admin/users/'.$u->id) }}" onsubmit="return confirm('Delete user?')">
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
                            <td class="p-6 text-center text-zinc-600 dark:text-zinc-400" colspan="6">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
