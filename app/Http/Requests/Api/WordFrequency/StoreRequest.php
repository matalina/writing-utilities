<?php

namespace App\Http\Requests\Api\WordFrequency;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OneOrOther;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'string' => [new OneOrOther('file'), 'string'],
            'file' => [new OneOrOther('string')],
        ];
    }
}
