<?php
namespace App\Actions\Appointment;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class ListAppointmentAction
{
    public function handle(?User $client = null, ?User $provider = null, array $requestData = []): LengthAwarePaginator
    {
        return $this->query($client, $provider, $requestData)
            ->paginated(Arr::get($requestData, "limit"));
    }

    public function query(?User $client = null, ?User $provider = null, array $requestData = []): Builder
    {
        return Appointment::with(['client', 'providerUser.provider', 'service', 'serviceCategory'])
            ->when($client, function ($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->when($provider, function ($query) use ($provider) {
                $query->where('service_provider_id', $provider->id);
            })
            ->when(isset($requestData['status']), function ($query) use ($requestData) {
                $query->whereIn('status', Arr::wrap($requestData['status']));
            })
            ->orderBy(\DB::raw("appointments.id"), Arr::get($requestData, 'order_by', 'desc'));
    }
}