<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="grow overflow-x-hidden p-4 md:p-6 pb-16">
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
