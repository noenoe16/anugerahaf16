<x-layouts.app title="Messages">
    <div class="p-6 space-y-4">
        <h1 class="text-lg font-semibold">Messages</h1>

        <div class="grid md:grid-cols-3 gap-4">
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-3">
                <div class="mb-2 flex items-center justify-between text-sm font-medium">
                    <span>Contacts</span>
                    <a href="/user/contacts" class="btn-3d-neutral" wire:navigate>All Contacts</a>
                </div>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-zinc-500 pointer-events-none" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <input id="searchUser" placeholder="Cari user..." class="input-3d w-full pl-8 text-sm" />
                </div>
                <ul id="userList" class="max-h-80 overflow-auto space-y-1 text-sm">
                    @php($users = \App\Models\User::where('id', '!=', auth()->id())->orderBy('name')->get())
                    @forelse($users as $u)
                        <li>
                            <button data-id="{{ $u->id }}" data-name="{{ $u->name }}" class="w-full text-start rounded px-2 py-1 hover:bg-neutral-100 dark:hover:bg-zinc-800">
                                {{ $u->name }}
                            </button>
                        </li>
                    @empty
                        <li class="text-zinc-600">No contacts.</li>
                    @endforelse
                </ul>
            </div>

            <div class="md:col-span-2 space-y-3 min-h-[50vh]">
                <div id="threadHeader" class="rounded-xl border border-neutral-200 dark:border-neutral-700 glass-3d px-3 py-2 text-sm">
                    <span id="activeName" class="font-medium">Pilih kontak untuk mulai</span>
                </div>
                <div id="threadBox" class="rounded-xl border border-neutral-200 dark:border-neutral-700 glass-3d p-3 h-[50vh] max-h-[520px] overflow-y-auto">
                    <div class="text-sm text-zinc-600">Belum ada percakapan.</div>
                </div>
                <form id="composer" class="flex items-center gap-2">
                    <input type="hidden" name="receiver_id" id="receiver_id" />
                    <input id="messageInput" name="content" placeholder="Tulis pesan..." class="input-3d flex-1 text-sm" disabled />
                    <button id="sendBtn" type="submit" class="btn-3d-success disabled:opacity-50" disabled>Kirim</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userList = document.getElementById('userList');
            const searchUser = document.getElementById('searchUser');
            const threadBox = document.getElementById('threadBox');
            const activeName = document.getElementById('activeName');
            const receiverInput = document.getElementById('receiver_id');
            const messageInput = document.getElementById('messageInput');
            const sendBtn = document.getElementById('sendBtn');
            const composer = document.getElementById('composer');
            let activeUserId = null;
            let pollHandle = null;

            searchUser.addEventListener('input', (e) => {
                const q = e.target.value.toLowerCase();
                userList.querySelectorAll('[data-id]').forEach(btn => {
                    const name = btn.dataset.name.toLowerCase();
                    btn.parentElement.classList.toggle('hidden', !name.includes(q));
                });
            });

            userList.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-id]');
                if (!btn) return;
                activeUserId = btn.dataset.id;
                activeName.textContent = btn.dataset.name;
                receiverInput.value = activeUserId;
                messageInput.disabled = false;
                sendBtn.disabled = false;
                startPolling();
            });

            function startPolling() {
                if (!activeUserId) return;
                if (pollHandle) clearInterval(pollHandle);
                loadThread();
                pollHandle = setInterval(loadThread, 2500);
            }

            async function loadThread() {
                if (!activeUserId) return;
                try {
                    const res = await fetch(`{{ route('api.thread') }}?user_id=${encodeURIComponent(activeUserId)}`);
                    if (!res.ok) return;
                    const data = await res.json();
                    renderThread(data);
                } catch (_) { /* ignore */ }
            }

            function renderThread(items) {
                threadBox.innerHTML = '';
                if (!items || items.length === 0) {
                    const empty = document.createElement('div');
                    empty.className = 'text-sm text-zinc-600';
                    empty.textContent = 'Belum ada pesan.';
                    threadBox.appendChild(empty);
                    return;
                }
                items.forEach(m => {
                    const row = document.createElement('div');
                    row.className = `my-1 flex ${m.direction === 'out' ? 'justify-end' : 'justify-start'}`;
                    const bubble = document.createElement('div');
                    bubble.className = `${m.direction === 'out' ? 'bg-zinc-900 text-white dark:bg-white dark:text-black' : 'bg-neutral-100 dark:bg-zinc-800'} rounded-xl px-3 py-2 max-w-[75%] text-sm`;
                    const content = document.createElement('div');
                    content.textContent = m.content;
                    const meta = document.createElement('div');
                    meta.className = 'mt-0.5 text-[10px] opacity-70';
                    meta.textContent = m.created_at || '';
                    bubble.appendChild(content);
                    bubble.appendChild(meta);
                    row.appendChild(bubble);
                    threadBox.appendChild(row);
                });
                threadBox.scrollTop = threadBox.scrollHeight;
            }

            composer.addEventListener('submit', async (e) => {
                e.preventDefault();
                const content = messageInput.value.trim();
                if (!activeUserId || !content) return;
                sendBtn.disabled = true;
                try {
                    const res = await fetch(`{{ url('/user/messages') }}` , {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                        },
                        body: new URLSearchParams({ receiver_id: activeUserId, content }),
                    });
                    messageInput.value = '';
                    loadThread();
                } catch (_) { /* ignore */ }
                finally { sendBtn.disabled = false; }
            });
        });
    </script>
</x-layouts.app>
