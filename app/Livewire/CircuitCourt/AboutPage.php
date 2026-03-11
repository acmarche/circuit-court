<?php

declare(strict_types=1);

namespace App\Livewire\CircuitCourt;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.circuit-court')]
#[Title('A propos - Circuit Court Marche-en-Famenne')]
final class AboutPage extends Component
{
    public function render(): View
    {
        return view('livewire.circuit-court.about-page');
    }
}
