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
#[Title('Carte - Circuit Court Marche-en-Famenne')]
final class MapPage extends Component
{
    private const string CIRCUIT_COURT_TAG_SLUG = 'circuit-court';

    /** @var array<int, int> */
    #[Url(as: 'tags')]
    public array $selectedTags = [];

    #[Url(as: 'localite')]
    public string $selectedLocality = '';

    public ?int $previewShopId = null;

    /** @return Collection<int, Shop> */
    #[Computed]
    public function shops(): Collection
    {
        return $this->baseQuery()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->when($this->selectedLocality !== '', fn (Builder $q): Builder => $q->where('city', $this->selectedLocality))
            ->when($this->selectedTags !== [], fn (Builder $q): Builder => $q->whereHas('tags', fn (Builder $sub): Builder => $sub->whereIn('tags.id', $this->selectedTags)))
            ->with(['tags' => fn ($q) => $q->where('private', false), 'categories', 'media'])
            ->orderBy('company')
            ->get();
    }

    /** @return Collection<int, TagGroup> */
    #[Computed]
    public function tagGroups(): Collection
    {
        return TagGroup::query()
            ->where('private', false)
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
        $this->previewShopId = null;
        $this->dispatch('filters-changed');
    }

    public function selectLocality(string $locality): void
    {
        $this->selectedLocality = $this->selectedLocality === $locality ? '' : $locality;
        $this->previewShopId = null;
        $this->dispatch('filters-changed');
    }

    public function clearFilters(): void
    {
        $this->selectedTags = [];
        $this->selectedLocality = '';
        $this->previewShopId = null;
        $this->dispatch('filters-changed');
    }

    /** @return list<array{id: int, lat: float|null, lng: float|null, company: string, icon: string|null}> */
    public function getShopsForMap(): array
    {
        return $this->shops->map(fn (Shop $s): array => [
            'id' => $s->id,
            'lat' => $s->latitude,
            'lng' => $s->longitude,
            'company' => $s->company,
            'icon' => $s->categories->first()?->icon
                ? asset('storage/bottin/icons/'.$s->categories->first()->icon)
                : null,
        ])->values()->all();
    }

    public function showPreview(int $shopId): void
    {
        $this->previewShopId = $shopId;
        $this->dispatch('shop-preview-opened');
    }

    public function closePreview(): void
    {
        $this->previewShopId = null;
    }

    public function render(): View
    {
        return view('livewire.circuit-court.map-page');
    }

    /** @return Builder<Shop> */
    private function baseQuery(): Builder
    {
        return Shop::query()
            ->where('enabled', true)
            ->whereHas('tags', fn (Builder $q): Builder => $q->where('slug', self::CIRCUIT_COURT_TAG_SLUG));
    }
}
