<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Shop extends Model
{
    use HasSlug;

    protected $fillable = [
        'point_of_sale_id',
        'address_id',
        'company',
        'street',
        'number',
        'postal_code',
        'city',
        'phone',
        'phone_other',
        'fax',
        'mobile',
        'website',
        'email',
        'facebook',
        'twitter',
        'instagram',
        'tiktok',
        'youtube',
        'linkedin',
        'longitude',
        'latitude',
        'city_center',
        'open_at_lunch',
        'pmr',
        'click_collect',
        'ecommerce',
        'enabled',
        'vat_number',
        'function',
        'civility',
        'last_name',
        'first_name',
        'contact_street',
        'contact_number',
        'contact_postal_code',
        'contact_city',
        'contact_phone',
        'contact_phone_other',
        'contact_fax',
        'contact_mobile',
        'contact_email',
        'admin_function',
        'admin_civility',
        'admin_last_name',
        'admin_first_name',
        'admin_phone',
        'admin_phone_other',
        'admin_fax',
        'admin_mobile',
        'admin_email',
        'comment1',
        'comment2',
        'comment3',
        'note',
        'user',
    ];

    /** @return BelongsTo<PointOfSale, $this> */
    public function pointOfSale(): BelongsTo
    {
        return $this->belongsTo(PointOfSale::class);
    }

    /** @return BelongsTo<Address, $this> */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /** @return HasMany<Media, $this> */
    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /** @return HasMany<Schedule, $this> */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /** @return BelongsToMany<Category, $this> */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_shop')
            ->withPivot('principal');
    }

    /** @return BelongsToMany<Tag, $this> */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'shop_tag');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'city_center' => 'boolean',
            'click_collect' => 'boolean',
            'ecommerce' => 'boolean',
            'enabled' => 'boolean',
            'open_at_lunch' => 'boolean',
            'pmr' => 'boolean',
        ];
    }

    private function slugSourceField(): string
    {
        return 'company';
    }
}
