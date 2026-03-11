<?php

declare(strict_types=1);

namespace App\Livewire\CircuitCourt;

use App\Models\Shop;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.circuit-court')]
final class ActeurShow extends Component
{
    public Shop $shop;

    public function mount(Shop $shop): void
    {
        $this->shop = $shop->load(['tags' => fn ($q) => $q->where('private', false), 'categories', 'medias']);
    }

    public function render(): View
    {
        return view('livewire.circuit-court.acteur-show')
            ->title($this->shop->company.' - Circuit Court');
    }
}
