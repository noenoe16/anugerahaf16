<x-layouts.app title="Notifications">
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold">Notifications</h1>
            <button id="refreshBtn" class="btn-3d-info">Refresh</button>
        </div>
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 glass-3d p-3">
            <div id="notifList" class="space-y-2"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            async function load() {
                const res = await fetch(`{{ url('/api/notifications') }}`);
                const data = await res.json();
                const list = document.getElementById('notifList');
                list.innerHTML = '';
                data.forEach(n => {
                    const div = document.createElement('div');
                    div.className = 'p-2 rounded border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900';
                    div.innerHTML = `<div class="font-medium">${n.title}</div><div class="text-sm text-zinc-600">${n.body}</div>`;
                    list.appendChild(div);
                });
            }
            load();
            setInterval(load, 5000);
            document.getElementById('refreshBtn').addEventListener('click', load);
        });
    </script>
</x-layouts.app>
