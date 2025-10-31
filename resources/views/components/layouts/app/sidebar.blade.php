<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen surface-3d ui-3d-page dark:bg-zinc-800 flex flex-col">
        <flux:sidebar sticky stashable class="w-72 shrink-0 min-h-svh overflow-x-hidden glass-3d nav-3d sidebar-3d sk-sidebar relative z-50">
            <flux:sidebar.toggle class="lg:hidden" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse">
                <span class="rounded-xl glass-3d shadow-sm p-2">
                    <x-app-logo />
                </span>
            </a>

            
            <flux:navlist variant="outline" class="overflow-y-auto overflow-x-hidden pb-28 lg:pb-44 flex flex-col gap-2">
                @if (auth()->user()?->role === 'admin')
                    <flux:navlist.group :heading="__('Platform')" class="grid">
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('dashboard')) sk-item-active @endif" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.home class="size-4" />
                            </span>
                            <span class="font-medium">Dashboard</span>
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group heading="User">
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('admin.users.*')) sk-item-active @endif" :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-sky-500 to-cyan-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.users class="size-4" />
                            </span>
                            <span class="font-medium">User List</span>
                        </flux:navlist.item>
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('admin.users.create')) sk-item-active @endif" :href="route('admin.users.create')" :current="request()->routeIs('admin.users.create')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.user-plus class="size-4" />
                            </span>
                            <span class="font-medium">Create User</span>
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group heading="Maps">
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('admin.maps.*')) sk-item-active @endif" :href="route('admin.maps.index')" :current="request()->routeIs('admin.maps.*')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.map class="size-4" />
                            </span>
                            <span class="font-medium">Maps List</span>
                        </flux:navlist.item>
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('admin.maps.create')) sk-item-active @endif" :href="route('admin.maps.create')" :current="request()->routeIs('admin.maps.create')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-amber-500 to-yellow-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.map-pin-plus class="size-4" />
                            </span>
                            <span class="font-medium">Create Maps</span>
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group heading="Location">
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('admin.locations.*')) sk-item-active @endif" :href="route('admin.locations.index')" :current="request()->routeIs('admin.locations.*')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-blue-600 to-sky-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.building-2 class="size-4" />
                            </span>
                            <span class="font-medium">Location List</span>
                        </flux:navlist.item>
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('admin.locations.create')) sk-item-active @endif" :href="route('admin.locations.create')" :current="request()->routeIs('admin.locations.create')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.circle-plus class="size-4" />
                            </span>
                            <span class="font-medium">Create Location</span>
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group heading="Contact">
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('admin.contacts.*')) sk-item-active @endif" :href="route('admin.contacts.index')" :current="request()->routeIs('admin.contacts.*')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-pink-500 to-fuchsia-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.phone class="size-4" />
                            </span>
                            <span class="font-medium">Contact List</span>
                        </flux:navlist.item>
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('admin.contacts.create')) sk-item-active @endif" :href="route('admin.contacts.create')" :current="request()->routeIs('admin.contacts.create')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-amber-500 to-yellow-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.circle-plus class="size-4" />
                            </span>
                            <span class="font-medium">Create Contact</span>
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group heading="Notification" class="mt-auto">
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('admin.notifications')) sk-item-active @endif" :href="route('admin.notifications')" :current="request()->routeIs('admin.notifications')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.bell class="size-4" />
                            </span>
                            <span class="font-medium">Notification</span>
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group heading="Message">
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('admin.messages')) sk-item-active @endif" :href="route('admin.messages')" :current="request()->routeIs('admin.messages')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.messages-square class="size-4" />
                            </span>
                            <span class="font-medium">Message</span>
                        </flux:navlist.item>
                    </flux:navlist.group>
                @else
                    <flux:navlist.group heading="Platform">
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('dashboard')) sk-item-active @endif" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.home class="size-4" />
                            </span>
                            <span class="font-medium">Dashboard</span>
                        </flux:navlist.item>
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('user.maps')) sk-item-active @endif" :href="route('user.maps')" :current="request()->routeIs('user.maps')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.map class="size-4" />
                            </span>
                            <span class="font-medium">Maps</span>
                        </flux:navlist.item>
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('user.locations')) sk-item-active @endif" :href="route('user.locations')" :current="request()->routeIs('user.locations')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-blue-600 to-sky-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.building-2 class="size-4" />
                            </span>
                            <span class="font-medium">Location</span>
                        </flux:navlist.item>
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('user.contacts')) sk-item-active @endif" :href="route('user.contacts')" :current="request()->routeIs('user.contacts')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-pink-500 to-fuchsia-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.phone class="size-4" />
                            </span>
                            <span class="font-medium">Contact</span>
                        </flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.group heading="Notification" class="mt-auto">
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('user.notifications')) sk-item-active @endif" :href="route('user.notifications')" :current="request()->routeIs('user.notifications')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.bell class="size-4" />
                            </span>
                            <span class="font-medium">Notification</span>
                        </flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.group heading="Message">
                        <flux:navlist.item class="nav-item-3d sk-item rounded-2xl h-14 px-3 gap-3 flex items-center @if(request()->routeIs('user.messages')) sk-item-active @endif" :href="route('user.messages')" :current="request()->routeIs('user.messages')" wire:navigate>
                            <span class="inline-grid place-content-center size-9 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white ring-2 ring-white/20 shadow-lg">
                                <flux:icon.messages-square class="size-4" />
                            </span>
                            <span class="font-medium">Message</span>
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />

            
            <!-- User Menu pinned to bottom -->
            <flux:dropdown class="absolute left-3 right-3 bottom-3 z-[70]" position="top" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px] z-[70]">
                    <flux:menu.separator />
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <div class="px-3 py-2">
                        <div x-data x-effect="$el.classList.toggle('is-dark', $flux.appearance==='dark'); $el.classList.toggle('is-system', $flux.appearance==='system');" class="theme-seg">
                            <span class="theme-seg__thumb"></span>
                            <button type="button" x-on:click="$flux.appearance='light'"><flux:icon.sun class="size-4" /></button>
                            <button type="button" x-on:click="$flux.appearance='dark'"><flux:icon.moon class="size-4 text-amber-400" /></button>
                            <button type="button" x-on:click="$flux.appearance='system'"><flux:icon.computer-desktop class="size-4" /></button>
                        </div>
                    </div>

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile header: only toggle, profile lives at the bottom of sidebar -->
        <flux:header class="lg:hidden glass-3d nav-3d">
            <flux:sidebar.toggle class="lg:hidden" inset="left" />
            <flux:spacer />
        </flux:header>

        {{ $slot }}

        <footer class="fixed right-0 bottom-0 left-0 lg:left-72 z-40 glass-3d text-center text-xs text-zinc-600 dark:text-zinc-400 py-3">
            &copy; 2025 Kilang Pertamina Internasional Refinery Unit VI Balongan
        </footer>

        @fluxScripts
    </body>
</html>
