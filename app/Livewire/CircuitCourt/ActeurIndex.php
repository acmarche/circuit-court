<?php

declare(strict_types=1);

namespace App\Livewire\CircuitCourt;

use App\Models\Shop;
use App\Models\TagGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.circuit-court')]
#[Title('Liste des acteurs - Circuit Court Marche-en-Famenne')]
final class ActeurIndex extends Component
{
    private const string CIRCUIT_COURT_TAG_SLUG = 'circuit-court';

    /** @var array<int, int> */
    #[Url(as: 'tags')]
    public array $selectedTags = [];

    #[Url(as: 'localite')]
    public string $selectedLocality = '';

    /** @return Collection<int, Shop> */
    #[Computed]
    public function shops(): Collection
    {
        return $this->baseQuery()
            ->when($this->selectedLocality !== '', fn (Builder $q): Builder => $q->where('city', $this->selectedLocality))
            ->when($this->selectedTags !== [], fn (Builder $q): Builder => $q->whereHas('tags', fn (Builder $sub): Builder => $sub->whereIn('tags.id', $this->selectedTags)))
            ->with(['tags' => fn ($q) => $q->where('private', false), 'categories', 'medias'])
            ->orderBy('company')
            ->get();
    }

    /** @return Collection<int, TagGroup> */
    #[Computed]
    public function tagGroups(): Collection
    {
        return TagGroup::query()
            ->with(['tags' => fn ($q) => $q->where('private', false)->orderBy('name')])
            ->orderBy('name')
            ->get();
    }

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

    public function toggleTag(int $tagId): void
    {
        if (in_array($tagId, $this->selectedTags, true)) {
            $this->selectedTags = array_values(array_diff($this->selectedTags, [$tagId]));
        } else {
            $this->selectedTags[] = $tagId;
        }
    }

    public function selectLocality(string $locality): void
    {
        $this->selectedLocality = $this->selectedLocality === $locality ? '' : $locality;
    }

    public function clearFilters(): void
    {
        $this->selectedTags = [];
        $this->selectedLocality = '';
    }

    public function render(): View
    {
        return view('livewire.circuit-court.acteur-index');
    }

    /** @return Builder<Shop> */
    private function baseQuery(): Builder
    {
        return Shop::query()
            ->where('enabled', true)
            ->whereHas('tags', fn (Builder $q): Builder => $q->where('slug', self::CIRCUIT_COURT_TAG_SLUG));
    }
}
