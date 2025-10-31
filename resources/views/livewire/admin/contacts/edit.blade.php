<x-layouts.app title="Edit Contact">
    <div class="p-6 max-w-xl">
        <h1 class="text-lg font-semibold mb-4">Edit Contact</h1>
        @php $c = \App\Models\Contact::findOrFail(request()->route('contact')); @endphp
        <form method="POST" action="{{ url('/admin/contacts/'.request()->route('contact')) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" value="{{ $c->name }}" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" required />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">Email</label>
                    <input name="email" value="{{ $c->email }}" type="email" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="block text-sm mb-1">Phone</label>
                    <input name="phone" value="{{ $c->phone }}" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">WhatsApp</label>
                    <input name="whatsapp" value="{{ $c->whatsapp }}" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" />
                </div>
            </div>
            <div>
                <label class="block text-sm mb-1">Address</label>
                <textarea name="address" class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm">{{ $c->address }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1.5 rounded-md bg-zinc-900 text-white dark:bg-white dark:text-black">Update</button>
                <a href="{{ route('admin.contacts.index') }}" class="px-3 py-1.5 rounded-md border border-neutral-300 dark:border-neutral-700">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
