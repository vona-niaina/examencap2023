<?php

namespace App\Http\Requests\adminRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CiscoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'codeCisco' => ['numeric','required', 'digits:3', Rule::unique('ciscos')->ignore($this->cisco)], //->ignore($this->route()->parameter('idCisco'))
            'nomCisco' => ['required', 'min:4', 'max:50', Rule::unique('ciscos')->ignore($this->cisco)],
        ];
    }
}
