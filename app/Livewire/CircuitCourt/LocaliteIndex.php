<?php

declare(strict_types=1);

namespace App\Livewire\CircuitCourt;

use App\Models\Shop;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.circuit-court')]
#[Title('Localités - Circuit Court Marche-en-Famenne')]
final class LocaliteIndex extends Component
{
    private const string CIRCUIT_COURT_TAG_SLUG = 'circuit-court';

    /** @return Collection<int, Shop> */
    #[Computed]
    public function localities(): Collection
    {
        return Shop::query()
            ->where('enabled', true)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->whereHas('tags', fn (Builder $q): Builder => $q->where('slug', self::CIRCUIT_COURT_TAG_SLUG))
            ->selectRaw('city, count(*) as shops_count')
            ->groupBy('city')
            ->orderBy('city')
            ->get();
    }

    public function render(): View
    {
        return view('livewire.circuit-court.localite-index');
    }
}
