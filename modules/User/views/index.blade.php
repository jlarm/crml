<x-layouts.app :title="__('Users')">
    <div class="flex justify-between items-center">
        <flux:heading size="xl">Users</flux:heading>
        <flux:button wire:navigate href="{{ route('user.create') }}" variant="primary">Add User</flux:button>
    </div>
    <flux:separator variant="subtle" class="my-8" />
    <livewire:user.index />
</x-layouts.app>
