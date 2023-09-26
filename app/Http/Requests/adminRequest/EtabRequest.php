<?php

namespace App\Http\Requests\adminRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EtabRequest extends FormRequest
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
            'codeEtab' => ['required', 'integer', 'digits: 9' , Rule::unique('etabs')->ignore($this->route()->parameter('etab'))],
            'nomEtab' => ['required', 'max:120', Rule::unique('etabs')->ignore($this->route()->parameter('etab')) ],
            'codeSecteurEtab' => ['required', 'integer', 'digits: 1' ],
            'codeNiveauEtab' => ['required', 'integer', 'digits: 1' ],
            'zap_id' => ['required']
        ];
    }
}
