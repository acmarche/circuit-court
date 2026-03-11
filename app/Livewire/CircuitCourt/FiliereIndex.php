<?php

declare(strict_types=1);

namespace App\Livewire\CircuitCourt;

use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.circuit-court')]
#[Title('Filières - Circuit Court Marche-en-Famenne')]
final class FiliereIndex extends Component
{
    private const string CIRCUIT_COURT_TAG_SLUG = 'circuit-court';

    /** @return Collection<int, Tag> */
    #[Computed]
    public function tags(): Collection
    {
        return Tag::query()
            ->where('private', false)
            ->where('slug', '!=', self::CIRCUIT_COURT_TAG_SLUG)
            ->whereHas('shops', fn (Builder $q): Builder => $q
                ->where('enabled', true)
                ->whereHas('tags', fn (Builder $sub): Builder => $sub->where('slug', self::CIRCUIT_COURT_TAG_SLUG))
            )
            ->withCount(['shops' => fn (Builder $q): Builder => $q
                ->where('enabled', true)
                ->whereHas('tags', fn (Builder $sub): Builder => $sub->where('slug', self::CIRCUIT_COURT_TAG_SLUG)),
            ])
            ->orderBy('name')
            ->get();
    }

    public function render(): View
    {
        return view('livewire.circuit-court.filiere-index');
    }
}
