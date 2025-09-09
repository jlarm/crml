<?php

declare(strict_types=1);

namespace Modules\User\Livewire;

use Illuminate\View\View;
use Livewire\Component;

final class Index extends Component
{
    public function render(): View
    {
        return view('user::livewire.index');
    }
}
