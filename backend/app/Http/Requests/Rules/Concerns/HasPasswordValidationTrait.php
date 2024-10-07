<?php

namespace App\Http\Requests\Rules\Concerns;

use Illuminate\Validation\Rules\Password;

trait HasPasswordValidationTrait
{
    protected function passValidationRules() {
        if (config('app.env') == 'local') {
            $passwordValidation = Password::min(6);
        } else {
            $passwordValidation = Password::min(8)
                ->letters()->mixedCase()->numbers()->symbols()
                ->uncompromised();
        }
        return $passwordValidation;
    }
}
