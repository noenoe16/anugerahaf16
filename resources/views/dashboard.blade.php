<x-layouts.app title="Dashboard">
    @php
        $isAdmin = auth()->user()->role === 'admin';
        $buildings = \App\Models\Building::count();
        $rooms = \App\Models\Room::count();
        $cctvTotal = \App\Models\Cctv::count();
        $cctvOnline = \App\Models\Cctv::where('status', 'online')->count();
        $cctvOffline = \App\Models\Cctv::where('status', 'offline')->count();
        $cctvMaintenance = \App\Models\Cctv::where('status', 'maintenance')->count();
        $onlineThreshold = now()->subMinutes(5);
        $usersTotal = \App\Models\User::count();
        $usersOnline = \App\Models\User::whereNotNull('last_seen_at')->where('last_seen_at', '>=', $onlineThreshold)->count();
        $usersOffline = max($usersTotal - $usersOnline, 0);
    @endphp

    <div class="p-6 space-y-6">
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-semibold tracking-tight">Dashboard</h1>
            <div class="ml-auto flex items-center gap-2">
                <a href="{{ $isAdmin ? route('admin.export.buildings') : route('user.export.buildings') }}" class="btn-3d-primary text-sm">Export Buildings (XLSX)</a>
                <a href="{{ $isAdmin ? route('admin.export.rooms') : route('user.export.rooms') }}" class="btn-3d-info text-sm">Export Rooms (XLSX)</a>
                <a href="{{ $isAdmin ? route('admin.export.cctvs') : route('user.export.cctvs') }}" class="btn-3d-success text-sm">Export CCTVs (XLSX)</a>
                <a href="{{ $isAdmin ? route('admin.export.users') : route('user.export.users') }}" class="btn-3d-warning text-sm">Export Users (All)</a>
                <a href="{{ $isAdmin ? route('admin.export.users.online') : route('user.export.users.online') }}" class="btn-3d-success text-sm">Users Online</a>
                <a href="{{ $isAdmin ? route('admin.export.users.offline') : route('user.export.users.offline') }}" class="btn-3d-danger text-sm">Users Offline</a>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            <div class="ui-3d-card p-4 relative">
                <div class="absolute -top-2 -left-2 size-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white grid place-content-center shadow-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12l9-9 9 9-9 9-9-9z" stroke="white" stroke-width="2"/></svg>
                </div>
                <p class="text-xs text-zinc-500">Total Buildings</p>
                <p class="text-2xl font-semibold">{{ $buildings }}</p>
                <p class="text-xs text-zinc-500">Semua gedung terdaftar</p>
            </div>

            <div class="ui-3d-card p-4 relative">
                <div class="absolute -top-2 -left-2 size-9 rounded-xl bg-gradient-to-br from-sky-500 to-cyan-600 text-white grid place-content-center shadow-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16v12H4z" stroke="white" stroke-width="2"/><path d="M8 6V3h8v3" stroke="white" stroke-width="2"/></svg>
                </div>
                <p class="text-xs text-zinc-500">Total Rooms</p>
                <p class="text-2xl font-semibold">{{ $rooms }}</p>
                <p class="text-xs text-zinc-500">Seluruh ruangan</p>
            </div>

            <div class="ui-3d-card p-4 relative">
                <div class="absolute -top-2 -left-2 size-9 rounded-xl bg-gradient-to-br from-emerald-500 to-green-600 text-white grid place-content-center shadow-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="white" stroke-width="2"/><path d="M8 12h8M12 8v8" stroke="white" stroke-width="2"/></svg>
                </div>
                <p class="text-xs text-zinc-500">CCTV Online</p>
                <p class="text-2xl font-semibold">{{ $cctvOnline }}</p>
                <p class="text-xs text-zinc-500">Dari total {{ $cctvTotal }}</p>
            </div>

            <div class="ui-3d-card p-4 relative">
                <div class="absolute -top-2 -left-2 size-9 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 text-white grid place-content-center shadow-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="white" stroke-width="2"/><path d="M8 12h8" stroke="white" stroke-width="2"/></svg>
                </div>
                <p class="text-xs text-zinc-500">CCTV Offline</p>
                <p class="text-2xl font-semibold">{{ $cctvOffline }}</p>
                <p class="text-xs text-zinc-500">Maintenance: {{ $cctvMaintenance }}</p>
            </div>

            <div class="ui-3d-card p-4 relative">
                <div class="absolute -top-2 -left-2 size-9 rounded-xl bg-gradient-to-br from-fuchsia-500 to-purple-600 text-white grid place-content-center shadow-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 7h18M3 12h18M3 17h18" stroke="white" stroke-width="2"/></svg>
                </div>
                <p class="text-xs text-zinc-500">CCTV Total</p>
                <p class="text-2xl font-semibold">{{ $cctvTotal }}</p>
                <p class="text-xs text-zinc-500">Online {{ $cctvOnline }} • Offline {{ $cctvOffline }}</p>
            </div>

            <div class="ui-3d-card p-4 relative">
                <div class="absolute -top-2 -left-2 size-9 rounded-xl bg-gradient-to-br from-amber-500 to-yellow-600 text-white grid place-content-center shadow-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v18M3 12h18" stroke="white" stroke-width="2"/></svg>
                </div>
                <p class="text-xs text-zinc-500">Users Online</p>
                <p class="text-2xl font-semibold">{{ $usersOnline }}</p>
                <p class="text-xs text-zinc-500">Total pengguna: {{ $usersTotal }}</p>
            </div>

            <div class="ui-3d-card p-4 relative">
                <div class="absolute -top-2 -left-2 size-9 rounded-xl bg-gradient-to-br from-slate-500 to-zinc-700 text-white grid place-content-center shadow-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 12h16" stroke="white" stroke-width="2"/><path d="M8 16h8" stroke="white" stroke-width="2"/></svg>
                </div>
                <p class="text-xs text-zinc-500">Users Offline</p>
                <p class="text-2xl font-semibold">{{ $usersOffline }}</p>
                <p class="text-xs text-zinc-500">Batas online: 5 menit</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="ui-3d-card p-4">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-sm font-semibold">Recent Buildings</h2>
                    <a href="{{ route('user.locations') }}" class="btn-3d-primary text-xs">View all</a>
                </div>
                <div class="divide-y divide-zinc-200/60 dark:divide-zinc-800/60">
                    @foreach(\App\Models\Building::latest('id')->limit(5)->get() as $b)
                        <a href="{{ route('user.locations.building', $b) }}" class="flex items-center justify-between py-2 hover:opacity-90">
                            <span class="text-sm">{{ $b->name }}</span>
                            <span class="text-xs text-zinc-500">{{ $b->rooms()->count() }} rooms</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="ui-3d-card p-4">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-sm font-semibold">Recent Rooms</h2>
                    <a href="{{ route('user.rooms') }}" class="btn-3d-info text-xs">View all</a>
                </div>
                <div class="divide-y divide-zinc-200/60 dark:divide-zinc-800/60">
                    @foreach(\App\Models\Room::with('building:id,name')->latest('id')->limit(5)->get() as $r)
                        <a href="{{ route('user.cctv.index', ['room' => $r->id]) }}" class="flex items-center justify-between py-2 hover:opacity-90">
                            <span class="text-sm">{{ $r->name }} <span class="text-xs text-zinc-500">— {{ $r->building?->name }}</span></span>
                            <span class="text-xs text-zinc-500">{{ $r->cctvs()->count() }} CCTV</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="ui-3d-card p-4">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-sm font-semibold">CCTV Status Distribution</h2>
                <div class="flex items-center gap-2">
                    <span class="badge-3d">Online {{ $cctvOnline }}</span>
                    <span class="badge-3d">Offline {{ $cctvOffline }}</span>
                    <span class="badge-3d">Maint {{ $cctvMaintenance }}</span>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="glass-3d rounded-lg p-3">
                    <p class="text-xs text-zinc-500">Online</p>
                    <p class="text-xl font-semibold">{{ $cctvOnline }}</p>
                </div>
                <div class="glass-3d rounded-lg p-3">
                    <p class="text-xs text-zinc-500">Offline</p>
                    <p class="text-xl font-semibold">{{ $cctvOffline }}</p>
                </div>
                <div class="glass-3d rounded-lg p-3">
                    <p class="text-xs text-zinc-500">Maintenance</p>
                    <p class="text-xl font-semibold">{{ $cctvMaintenance }}</p>
                </div>
            </div>
        </div>

        <div class="ui-3d-card p-4">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-sm font-semibold">Quick Actions</h2>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('user.maps') }}" class="btn-3d-info">Open Maps</a>
                <a href="{{ route('user.rooms') }}" class="btn-3d-primary">Browse Rooms</a>
                <a href="{{ route('user.cctv.index') }}" class="btn-3d-success">Live CCTV</a>
                <a href="{{ route('user.contacts') }}" class="btn-3d-warning">Contacts</a>
                <a href="{{ route('user.notifications') }}" class="btn-3d-neutral">Notifications</a>
                <a href="{{ route('user.messages') }}" class="btn-3d-danger">Messages</a>
            </div>
        </div>
    </div>
</x-layouts.app>


