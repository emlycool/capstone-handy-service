<?php
namespace App\Services;

use App\Actions\Provider\CreateOrUpdateProviderAction;
use App\Models\City;
use App\Models\Role;
use App\Models\User;
use App\Enums\RoleEnum;
use App\Models\Provider;
use App\Models\Province;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use App\Actions\User\RegisterUserAction;
use App\Actions\User\SendEmailVerficationMailAction;
use App\Actions\User\UpdateUserAction;
use App\Exceptions\ApiException;
use App\Helpers\ApiResponse;
use App\Helpers\AppUtil;
use Illuminate\Support\Arr;

class OnboardingService
{
    public function __construct(
        protected AuthService $authService
    )
    {
        
    }

    public function registerUser(array $data)
    {
        DB::transaction(function() use(&$data){
            $data['user'] = app(RegisterUserAction::class)->handle($data);
            $this->assignRole(RoleEnum::CLIENT, $data['user']);
        });

        AppUtil::defer(fn() => resolve(SendEmailVerficationMailAction::class)->handle($data));

        $token = $this->authService->login($data['user']);
        $data['auth'] = $this->authService->authResponse($token);
        return $data;
    }

    public function updateUser(User $user, array $data): User
    {
        resolve(UpdateUserAction::class)->handle($user, $data);
        return $user;
    }


    public function storeProvider(User $user, array $data): Provider
    {
        $provider = new Provider();
        DB::transaction(function() use(&$data, $user, &$provider){
            $provider = resolve(CreateOrUpdateProviderAction::class)->handle($user, $data);
            $this->assignRole(RoleEnum::SERVICE_PROVIDER, $user);
        });

        if(Arr::get($data, 'business_logo')){
            $provider->addMediaFromRequest('business_logo')->toMediaCollection('business_logo');
        }
        throw_if(!$provider, new ApiException(msg: "Failed to create provider"));
        return $provider;
    }

    public function updateUserProvider(User $user, array $data): Provider
    {
        $provider = $user->provider;
        $provider->update($data);
        return $provider;
    }

    public function listProvinces(): array
    {
        $provinces = Province::with('cities:province_id,name')->get(['id', 'name', 'code']);
        return $provinces->toArray();
    }

    public function listCities(): array
    {
        $cities = City::with('province:id,name,code')->get(['name', 'province_id']);
        return $cities->toArray();
    }

    private function assignRole(RoleEnum $roleEnum, $user): void
    {
        $role = Role::where("name", $roleEnum->value)->first();
        $user->roles()->syncWithoutDetaching([$role->id]);
    }
}