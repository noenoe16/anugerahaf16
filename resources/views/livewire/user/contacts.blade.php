<x-layouts.app title="Contacts">
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight">Contact</h1>
            <div class="flex items-center gap-2 text-sm">
                <a href="mailto:admin@example.com" class="btn-3d-info">Email Admin</a>
                <a href="/user/messages" class="btn-3d-primary" wire:navigate>Open Messages</a>
            </div>
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
                        </tr>
                    @empty
                        <tr>
                            <td class="p-6 text-center text-zinc-600 dark:text-zinc-400" colspan="5">No contacts available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
