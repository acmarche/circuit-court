<?php

declare(strict_types=1);

namespace App\Livewire\CircuitCourt;

use App\Models\Shop;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.circuit-court')]
final class LocaliteShow extends Component
{
    private const string CIRCUIT_COURT_TAG_SLUG = 'circuit-court';

    public string $city;

    public function mount(string $city): void
    {
        $this->city = $city;
    }

    /** @return Collection<int, Shop> */
    #[Computed]
    public function shops(): Collection
    {
        return Shop::query()
            ->where('enabled', true)
            ->where('city', $this->city)
            ->whereHas('tags', fn (Builder $q): Builder => $q->where('slug', self::CIRCUIT_COURT_TAG_SLUG))
            ->with(['tags' => fn ($q) => $q->where('private', false), 'categories', 'media'])
            ->orderBy('company')
            ->get();
    }

    public function render(): View
    {
        return view('livewire.circuit-court.localite-show')
            ->title($this->city.' - Circuit Court');
    }
}
