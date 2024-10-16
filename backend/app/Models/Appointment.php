<?php

namespace App\Models;

use App\Services\ProviderService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $guarded = ['id'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function providerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(ServiceProviderService::class, 'provider_service_id');
    }

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
