<?php

namespace App\Http\Requests\adminRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CentreRequest extends FormRequest
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
            'nomCentre' => ['required','min:4', 'max:100', Rule::unique('centres')->ignore($this->route()->parameter('centre'))],
            'emplacementCentre' => ['required', 'min:3', 'max:200', Rule::unique('centres')->ignore($this->route()->parameter('centre'))],
            'texteNumCandidat' => ['required', 'min:3', 'max:10',  Rule::unique('centres')->ignore($this->route()->parameter('centre'))]
        ];
    }
}
