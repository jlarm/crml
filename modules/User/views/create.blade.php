<x-layouts.app :title="__('Create User')">
    <div class="flex justify-between items-center">
        <flux:heading size="xl">Create User</flux:heading>
        <flux:button wire:navigate icon="arrow-left" href="{{ route('user.index') }}">Back</flux:button>
    </div>
    <flux:separator variant="subtle" class="my-8" />
    <livewire:user.create />
</x-layouts.app>
