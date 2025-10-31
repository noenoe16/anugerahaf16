<x-layouts.app title="Create Contact">
    <div class="p-6 max-w-xl">
        <h1 class="text-lg font-semibold mb-4">Create Contact</h1>
        <form method="POST" action="{{ url('/admin/contacts') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" required />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">Email</label>
                    <input name="email" type="email" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="block text-sm mb-1">Phone</label>
                    <input name="phone" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" />
                </div>
            </div>
            <div>
                <label class="block text-sm mb-1">WhatsApp</label>
                <input name="whatsapp" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" />
            </div>
            <div>
                <label class="block text-sm mb-1">Address</label>
                <textarea name="address" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1.5 rounded-md bg-zinc-900 text-white dark:bg-white dark:text-black">Save</button>
                <a href="{{ route('admin.contacts.index') }}" class="px-3 py-1.5 rounded-md border border-neutral-300 dark:border-neutral-700">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
