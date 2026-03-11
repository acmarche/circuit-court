<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Media extends Model
{
    public const CREATED_AT = null;

    public const BASE_PATH = 'bottin/fiches/';

    protected $fillable = [
        'shop_id',
        'name',
        'is_main',
        'file_name',
        'mime_type',
        'size',
    ];

    /** @return BelongsTo<Shop, $this> */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * file_name = bottin/fiches/12/01KJ7HQBR7DRT6QBSEDRZ6WAH9.pdf
     */
    public function storagePath(): string
    {
        return $this->file_name;
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_main' => 'boolean',
        ];
    }
}
