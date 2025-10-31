<x-layouts.app title="Contacts">
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-lg font-semibold flex items-center gap-2">
                <span class="inline-grid place-content-center size-6 rounded-lg bg-gradient-to-br from-fuchsia-500 to-purple-600 text-white shadow">📇</span>
                <span>Contact List</span>
            </h1>
            <a href="{{ route('admin.contacts.create') }}" class="btn-3d-primary" wire:navigate>New Contact</a>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-neutral-200 dark:border-neutral-700 ui-3d-card">
            <div class="ui-3d-rail"></div>
            <table class="min-w-full text-sm">
                <thead class="bg-zinc-50/90 dark:bg-zinc-900/80">
                    <tr>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Name</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Email</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Phone</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">WhatsApp</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Address</th>
                        <th scope="col" class="text-start p-3 text-[11px] font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Contact::orderBy('name')->get() as $c)
                        <tr class="border-t border-neutral-200/70 dark:border-neutral-700/70 hover:bg-white/50 dark:hover:bg-white/5">
                            <td class="p-3 font-semibold">{{ $c->name }}</td>
                            <td class="p-3"><a href="mailto:{{ $c->email }}" class="text-blue-600 hover:underline">{{ $c->email }}</a></td>
                            <td class="p-3"><a href="tel:{{ $c->phone }}" class="text-blue-600 hover:underline">{{ $c->phone }}</a></td>
                            <td class="p-3"><a href="https://wa.me/{{ preg_replace('/\D/','', (string) $c->whatsapp) }}" target="_blank" class="text-blue-600 hover:underline">{{ $c->whatsapp }}</a></td>
                            <td class="p-3 text-zinc-600 dark:text-zinc-400">{{ $c->address }}</td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.contacts.edit', $c) }}" class="btn-3d-square-info" title="Edit" wire:navigate>
                                        <flux:icon.pencil class="size-4" />
                                    </a>
                                    <form method="POST" action="{{ url('/admin/contacts/'.$c->id) }}" onsubmit="return confirm('Delete contact?')">
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
                            <td class="p-6 text-center text-zinc-600 dark:text-zinc-400" colspan="6">No contacts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
