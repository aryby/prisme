<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Paper Submissions</x-slot>

        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Public paper submission is
                    <strong>{{ $submissionsEnabled ? 'enabled' : 'disabled' }}</strong>.
                </p>
                @if ($notification !== '')
                    <p class="mt-2 text-sm text-success-600 dark:text-success-400" role="status">
                        {{ $notification }}
                    </p>
                @endif
            </div>

            <x-filament::button
                wire:click="toggleSubmissions"
                color="{{ $submissionsEnabled ? 'danger' : 'success' }}"
            >
                {{ $submissionsEnabled ? 'Disable submissions' : 'Enable submissions' }}
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
