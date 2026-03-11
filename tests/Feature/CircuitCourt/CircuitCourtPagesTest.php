<?php

declare(strict_types=1);

use App\Livewire\CircuitCourt\ActeurIndex;
use App\Livewire\CircuitCourt\MapPage;
use App\Models\Shop;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

function createCircuitCourtTag(): Tag
{
    return Tag::factory()->create(['name' => 'Circuit court', 'slug' => 'circuit-court']);
}

function createCircuitCourtShop(array $attributes = []): Shop
{
    $shop = Shop::factory()->create(array_merge(['enabled' => true], $attributes));
    $shop->tags()->attach(createCircuitCourtTag());

    return $shop;
}

it('renders the map page', function (): void {
    $this->get(route('circuit-court.map'))->assertOk();
});

it('renders the acteur list page', function (): void {
    $this->get(route('circuit-court.acteurs'))->assertOk();
});

it('renders the acteur detail page', function (): void {
    $shop = Shop::factory()->create(['enabled' => true]);

    $this->get(route('circuit-court.acteur.show', $shop))->assertOk();
});

it('renders the filiere index page', function (): void {
    $this->get(route('circuit-court.filieres'))->assertOk();
});

it('renders the filiere show page', function (): void {
    $tag = Tag::factory()->create();

    $this->get(route('circuit-court.filiere.show', $tag))->assertOk();
});

it('renders the localite index page', function (): void {
    $this->get(route('circuit-court.localites'))->assertOk();
});

it('renders the localite show page', function (): void {
    $this->get(route('circuit-court.localite.show', ['city' => 'Marche-en-Famenne']))->assertOk();
});

it('renders the about page', function (): void {
    $this->get(route('circuit-court.about'))->assertOk();
});

it('filters shops by tag on the map page', function (): void {
    $group = TagGroup::factory()->create();
    $tag = Tag::factory()->create(['tag_group_id' => $group->id]);
    $ccTag = createCircuitCourtTag();

    $shop = Shop::factory()->create(['enabled' => true, 'latitude' => '50.22', 'longitude' => '5.33']);
    $shop->tags()->attach([$ccTag->id, $tag->id]);

    Livewire::test(MapPage::class)
        ->call('toggleTag', $tag->id)
        ->assertSet('selectedTags', [$tag->id]);
});

it('filters shops by locality on the list page', function (): void {
    $ccTag = createCircuitCourtTag();

    $shop1 = Shop::factory()->create(['enabled' => true, 'city' => 'Marche-en-Famenne']);
    $shop1->tags()->attach($ccTag);

    $shop2 = Shop::factory()->create(['enabled' => true, 'city' => 'Aye']);
    $shop2->tags()->attach($ccTag);

    Livewire::test(ActeurIndex::class)
        ->call('selectLocality', 'Marche-en-Famenne')
        ->assertSee($shop1->company)
        ->assertDontSee($shop2->company);
});

it('clears filters on the map page', function (): void {
    $group = TagGroup::factory()->create();
    $tag = Tag::factory()->create(['tag_group_id' => $group->id]);

    Livewire::test(MapPage::class)
        ->call('toggleTag', $tag->id)
        ->assertSet('selectedTags', [$tag->id])
        ->call('clearFilters')
        ->assertSet('selectedTags', [])
        ->assertSet('selectedLocality', '');
});

it('shows the shop preview on the map page', function (): void {
    $ccTag = createCircuitCourtTag();
    $shop = Shop::factory()->create(['enabled' => true, 'latitude' => '50.22', 'longitude' => '5.33']);
    $shop->tags()->attach($ccTag);

    Livewire::test(MapPage::class)
        ->call('showPreview', $shop->id)
        ->assertSet('previewShopId', $shop->id)
        ->assertSee($shop->company);
});
