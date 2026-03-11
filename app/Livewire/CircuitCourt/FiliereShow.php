<?php

declare(strict_types=1);

namespace App\Livewire\CircuitCourt;

use App\Models\Shop;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.circuit-court')]
final class FiliereShow extends Component
{
    private const string CIRCUIT_COURT_TAG_SLUG = 'circuit-court';

    public Tag $tag;

    public function mount(Tag $tag): void
    {
        abort_if($tag->isPrivate(), 404);

        $this->tag = $tag;
    }

    /** @return Collection<int, Shop> */
    #[Computed]
    public function shops(): Collection
    {
        return $this->tag->shops()
            ->where('enabled', true)
            ->whereHas('tags', fn (Builder $q): Builder => $q->where('slug', self::CIRCUIT_COURT_TAG_SLUG))
            ->with(['tags' => fn ($q) => $q->where('private', false), 'categories', 'medias'])
            ->orderBy('company')
            ->get();
    }

    public function render(): View
    {
        return view('livewire.circuit-court.filiere-show')
            ->title($this->tag->name.' - Circuit Court');
    }
}
