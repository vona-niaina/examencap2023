<?php

namespace App\Http\Requests\adminRequest;

use Illuminate\Foundation\Http\FormRequest;

class AffectationZapSalle extends FormRequest
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
            'nombreCandidatAAffecterSansSalle' => ['required', 'min:1']
        ];
    }
}
