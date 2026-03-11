<?php

declare(strict_types=1);

use App\Services\MapSearchService;
use Meilisearch\Client;
use Meilisearch\Endpoints\Indexes;
use Meilisearch\Search\SearchResult;

beforeEach(function (): void {
    $searchResult = new SearchResult([
        'hits' => [],
        'offset' => 0,
        'limit' => 500,
        'estimatedTotalHits' => 0,
        'processingTimeMs' => 1,
        'query' => '',
    ]);

    $index = Mockery::mock(Indexes::class);
    $index->shouldReceive('search')->andReturn($searchResult);

    $client = Mockery::mock(Client::class);
    $client->shouldReceive('index')->andReturn($index);

    $this->app->instance(Client::class, $client);
});

it('validates map search request parameters', function (): void {
    $this->postJson('/api/bottin/map/update', [
        'localite' => 123,
        'tags' => 'not-an-array',
        'coordinates' => [
            'latitude' => 999,
        ],
    ])->assertUnprocessable()
        ->assertJsonValidationErrors(['localite', 'tags', 'coordinates.latitude', 'coordinates.longitude']);
});

it('accepts valid map search request with no parameters', function (): void {
    $this->postJson('/api/bottin/map/update')
        ->assertSuccessful();
});

it('accepts valid map search request with localite', function (): void {
    $this->postJson('/api/bottin/map/update', [
        'localite' => 'Marche-en-Famenne',
    ])->assertSuccessful();
});

it('accepts valid map search request with tags', function (): void {
    $this->postJson('/api/bottin/map/update', [
        'tags' => ['restaurant', 'hotel'],
    ])->assertSuccessful();
});

it('accepts valid map search request with coordinates', function (): void {
    $this->postJson('/api/bottin/map/update', [
        'coordinates' => [
            'latitude' => 50.2268,
            'longitude' => 5.3442,
        ],
    ])->assertSuccessful();
});

it('passes correct filters to meilisearch', function (): void {
    $index = Mockery::mock(Indexes::class);
    $index->shouldReceive('search')
        ->once()
        ->withArgs(function (string $query, array $options): bool {
            return $query === ''
                && $options['limit'] === 500
                && in_array('city = "Marche-en-Famenne"', $options['filter'])
                && in_array('tags = "restaurant"', $options['filter'])
                && in_array('_geoRadius(50.2268, 5.3442, 5000)', $options['filter']);
        })
        ->andReturn(new SearchResult([
            'hits' => [],
            'offset' => 0,
            'limit' => 500,
            'estimatedTotalHits' => 0,
            'processingTimeMs' => 1,
            'query' => '',
        ]));

    $client = Mockery::mock(Client::class);
    $client->shouldReceive('index')->andReturn($index);
    $this->app->instance(Client::class, $client);

    $this->postJson('/api/bottin/map/update', [
        'localite' => 'Marche-en-Famenne',
        'tags' => ['restaurant'],
        'coordinates' => [
            'latitude' => 50.2268,
            'longitude' => 5.3442,
        ],
    ])->assertSuccessful();
});

it('transforms hits to legacy format', function (): void {
    $service = new MapSearchService(app(Client::class));

    $result = $service->search();

    expect($result)->toHaveKey('hits')
        ->and($result['hits'])->toBeArray();
});

it('maps hit fields to legacy names', function (): void {
    $hit = [
        'id' => 1,
        'company' => 'Test Shop',
        'street' => 'Rue Test',
        'number' => '1',
        'postal_code' => 6900,
        'city' => 'Marche-en-Famenne',
        'phone' => '084 00 00 00',
        'phone_other' => null,
        'fax' => null,
        'mobile' => null,
        'website' => null,
        'email' => 'test@test.be',
        'longitude' => '5.34',
        'latitude' => '50.22',
        'city_center' => false,
        'open_at_lunch' => false,
        'pmr' => false,
        'vat_number' => null,
        'function' => null,
        'civility' => null,
        'last_name' => null,
        'first_name' => null,
        'contact_street' => null,
        'contact_number' => null,
        'contact_postal_code' => null,
        'contact_city' => null,
        'contact_phone' => null,
        'contact_phone_other' => null,
        'contact_fax' => null,
        'contact_mobile' => null,
        'contact_email' => null,
        'comment1' => null,
        'comment2' => null,
        'comment3' => null,
        'slug' => 'test-shop',
        'facebook' => null,
        'twitter' => null,
        'instagram' => null,
        'tiktok' => null,
        'youtube' => null,
        'linkedin' => null,
        'updated_at' => '2025-01-01T00:00:00+00:00',
        'created_at' => '2025-01-01T00:00:00+00:00',
        'image' => '/bottin/fiches/1/test.jpg',
        'tags' => ['Circuit court'],
        'tags_object' => [
            ['id' => 14, 'name' => 'Circuit court', 'description' => null, 'group' => 'Alimentation', 'color' => '#38620e', 'icon' => 'test.svg', 'private' => false],
        ],
        'type' => 'fiche',
        'categories' => [
            ['id' => 4, 'name' => 'Associations', 'description' => null, 'logo' => '', 'icon' => null, 'slug' => 'associations', 'parent_id' => 420],
        ],
        'cap_member' => true,
        '_geo' => ['lat' => '50.22', 'lng' => '5.34'],
    ];

    $searchResult = new SearchResult([
        'hits' => [$hit],
        'offset' => 0,
        'limit' => 500,
        'estimatedTotalHits' => 1,
        'processingTimeMs' => 1,
        'query' => '',
    ]);

    $index = Mockery::mock(Indexes::class);
    $index->shouldReceive('search')->andReturn($searchResult);

    $client = Mockery::mock(Client::class);
    $client->shouldReceive('index')->andReturn($index);

    $service = new MapSearchService($client);
    $result = $service->search();

    $legacyHit = $result['hits'][0];

    expect($legacyHit)
        ->toHaveKey('societe', 'Test Shop')
        ->toHaveKey('rue', 'Rue Test')
        ->toHaveKey('cp', 6900)
        ->toHaveKey('localite', 'Marche-en-Famenne')
        ->toHaveKey('telephone', '084 00 00 00')
        ->toHaveKey('centreville', false)
        ->toHaveKey('midi', false)
        ->toHaveKey('slugname', 'test-shop')
        ->toHaveKey('type', 'fiche')
        ->toHaveKey('capMember', true)
        ->and($legacyHit['tagsObject'][0])->toHaveKey('groupe', 'Alimentation')
        ->and($legacyHit['classements'][0])->toHaveKey('slugname', 'associations')
        ->and($legacyHit['secteurs'])->toBe(['Associations']);
});
