<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'services';

    public function providerServices(): HasMany
    {
        return $this->hasMany(Service::class, 'service_id');
    }
}
