<div class="max-w-2xl mx-auto">
    <form wire:submit.prevent="create" class="space-y-6">
        <flux:field>
            <flux:label>Name</flux:label>

            <flux:input wire:model="form.name" type="text" />

            <flux:error name="name" />
        </flux:field>

        <flux:field>
            <flux:label>Email</flux:label>

            <flux:input wire:model="form.email" type="email" />

            <flux:error name="email" />
        </flux:field>

        <flux:field>
            <flux:label>Phone</flux:label>

            <flux:input wire:model="form.phone" type="text" />

            <flux:error name="phone" />
        </flux:field>

        <flux:field>
            <flux:label>Timezone</flux:label>

            <flux:select wire:model="form.timezone" variant="listbox" searchable>
                @foreach($this->timezones() as $timezone)
                    <flux:select.option>{{ $timezone }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:error name="timezone" />
        </flux:field>

        <div class="flex gap-x-2">
            <flux:button type="submit" variant="primary">Submit</flux:button>
            <flux:button wire:navigate href="{{ route('user.index') }}">Cancel</flux:button>
        </div>
    </form>
</div>
