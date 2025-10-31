<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen surface-3d antialiased">
        <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10 relative">
            <img src="/images/Kilang.png" alt="Background" class="absolute inset-0 size-full object-cover opacity-20 blur-sm md:blur pointer-events-none select-none" />
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-9 w-9 mb-1 items-center justify-center rounded-md">
                        <img src="/images/logo-pertamina.png" alt="Pertamina" class="size-9" />
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <footer class="w-full text-center text-xs text-zinc-600 dark:text-zinc-400 py-4 glass-3d">
            &copy; 2025 Kilang Pertamina Internasional Refinery Unit VI Balongan
        </footer>
        @fluxScripts
    </body>
</html>
