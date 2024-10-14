<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Provider extends Model implements HasMedia
{
    use HasFactory;
    use \Spatie\MediaLibrary\InteractsWithMedia;
    
    protected $guarded = ['id'];

    public function province(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function logo(): Attribute
    {
        $logo = $this->getFirstMedia('business_logo');
        return Attribute::make(
            get: fn() => [
                'url' => $logo?->getUrl(),
                'type' => $logo?->file_name,
                'thumbnail' => $this->getFirstMedia('business_logo_preview')?->getUrl()
            ]
        );
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('business_logo_preview')
            ->format('webp')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
}
