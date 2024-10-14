<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ServiceProviderService extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $table = 'service_provider_services';
    protected $guarded = ['id'];

    protected $casts = [
        'working_hours' => 'array',
        'included_benefits' => 'array',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function images(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getMedia()->map->getUrl()->toArray()
        );
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    public function provider(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->HasOneThrough(Provider::class, User::class, 'id', 'user_id', 'service_provider_id', 'id');
    }
}
