<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\ApiValidationException;

class BaseValidationRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $message = $this->summarize($validator);
        throw new ApiValidationException(errors: $validator->errors()->toArray(), msg: $message);
    }

    /**
     * Create an error message summary from the validation errors.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return string
     */
    protected function summarize(Validator $validator) : string
    {
        $messages = $validator->errors()->all();

        if (! count($messages) || ! is_string($messages[0])) {
            return $validator->getTranslator()->get('The given data was invalid.');
        }

        $message = array_shift($messages);

        if ($count = count($messages)) {
            $pluralized = $count === 1 ? 'error' : 'errors';

            $message .= ' '.$validator->getTranslator()->choice("(and :count more $pluralized)", $count, compact('count'));
        }

        return $message;
    }
}