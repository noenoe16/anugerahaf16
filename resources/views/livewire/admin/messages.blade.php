<x-layouts.app title="Messages">
    <div class="p-6 grid md:grid-cols-3 gap-4">
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 glass-3d p-3">
            <h2 class="font-semibold mb-2">Users</h2>
            <ul class="space-y-1 max-h-72 overflow-auto">
                @foreach(\App\Models\User::orderBy('name')->get() as $u)
                    <li><button data-uid="{{ $u->id }}" class="underline w-full text-start">{{ $u->name }}</button></li>
                @endforeach
            </ul>
        </div>
        <div class="md:col-span-2 rounded-xl border border-neutral-200 dark:border-neutral-700 glass-3d p-3">
            <h2 class="font-semibold mb-2">Conversation</h2>
            <div id="thread" class="space-y-2 max-h-72 overflow-auto border rounded p-2 border-neutral-200 dark:border-neutral-700 bg-white/50 dark:bg-zinc-900/50"></div>
            <form id="sendForm" method="POST" action="{{ route('admin.messages.store') }}" class="mt-3 flex items-center gap-2">
                @csrf
                <input type="hidden" name="receiver_id" id="receiver_id" />
                <input name="content" placeholder="Type a message..." class="input-3d flex-1" />
                <button class="btn-3d-success">Send</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function loadThread(uid) {
                fetch(`{{ url('/api/thread') }}?user_id=${uid}`).then(r=>r.json()).then(items => {
                    const box = document.getElementById('thread');
                    box.innerHTML = '';
                    items.forEach(m => {
                        const div = document.createElement('div');
                        div.className = 'text-sm';
                        div.textContent = `${m.direction === 'out' ? 'You' : m.sender}: ${m.content}`;
                        box.appendChild(div);
                    });
                });
            }
            document.querySelectorAll('[data-uid]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const uid = btn.dataset.uid;
                    document.getElementById('receiver_id').value = uid;
                    loadThread(uid);
                })
            });
        });
    </script>
</x-layouts.app>
