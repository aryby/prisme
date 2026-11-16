<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <x-filament::button type="submit">
            Save committee page
        </x-filament::button>
    </form>
</x-filament-panels::page>
