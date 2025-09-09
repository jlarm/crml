<flux:table :paginate="$this->users" class="w-full">
    <flux:table.columns>
        <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
        <flux:table.column sortable :sorted="$sortBy === 'timezone'" :direction="$sortDirection" wire:click="sort('timezone')">Timezone</flux:table.column>
        <flux:table.column align="end"></flux:table.column>
    </flux:table.columns>
    <flux:table.rows>
        @forelse($this->users as $user)
            <flux:table.row wire:key="user-{{ $user->id }}">
                <flux:table.cell>{{ $user->name }}</flux:table.cell>
                <flux:table.cell>{{ $user->timezone ?? '-' }}</flux:table.cell>
                <flux:table.cell align="end">View</flux:table.cell>
            </flux:table.row>
        @empty
            <flux:table.row>
                <flux:table.cell>There are no users</flux:table.cell>
            </flux:table.row>
        @endforelse
    </flux:table.rows>
</flux:table>
