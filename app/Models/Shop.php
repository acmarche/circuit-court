<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaSpatie;

final class Shop extends Model implements HasMedia
{
    use HasSlug;
    use InteractsWithMedia;

    protected $fillable = [
        'address_id',
        'company',
        'street',
        'number',
        'postal_code',
        'city',
        'phone',
        'phone_other',
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
        'contact_mobile',
        'contact_email',
        'admin_function',
        'admin_civility',
        'admin_last_name',
        'admin_first_name',
        'admin_phone',
        'admin_phone_other',
        'admin_mobile',
        'admin_email',
        'comment1',
        'comment2',
        'comment3',
        'note',
        'user',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->useDisk('public');
    }

    public function registerMediaConversions(?MediaSpatie $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    /** @return BelongsTo<Address, $this> */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
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

    public function hasTag(string $name): bool
    {
        return $this->tags->contains('name', $name);
    }

    protected static function booted(): void
    {
        self::creating(function (self $model) {
            if (Auth::check()) {
                $user = Auth::user();
                $model->user = $user->username;
            }
        });
    }

    private function slugSourceField(): string
    {
        return 'company';
    }
}
