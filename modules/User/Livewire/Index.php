<?php

declare(strict_types=1);

namespace Modules\User\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\User\Models\User;

final class Index extends Component
{
    use WithPagination;

    public string $sortBy = 'name';

    public string $sortDirection = 'desc';

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->select(['id', 'name', 'timezone'])
            ->paginate(5);
    }

    public function render(): View
    {
        return view('user::livewire.index');
    }
}
