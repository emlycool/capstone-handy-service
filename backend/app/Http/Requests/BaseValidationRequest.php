<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Exceptions\ApiValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

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

    public function paginateAndFilterRules(): array
    {
        return [
            'order_by' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
            'limit' => ['nullable', 'integer', 'min:1'],
            'search' => ['nullable', 'string', ],
            'start_date' => ['nullable', 'required_unless:end_date,null', 'date_format:"Y-m-d"', 'before_or_equal:' . now()->toDateString()],
            'end_date' => ['nullable', 'required_unless:start_date,null', 'date_format:"Y-m-d"', 'after:start_date']
        ];
    }
}