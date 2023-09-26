<?php

namespace App\Http\Requests\adminRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ZapRequest extends FormRequest
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
            'codeZap' => ['required', 'integer', 'digits: 5' , Rule::unique('zaps')->ignore($this->route()->parameter('zap'))], //->ignore($this->id),
            'nomZap' => ['required', 'max:80', Rule::unique('zaps')->ignore($this->route()->parameter('zap')) ],
            'cisco_id' => ['required']
        ];
    }
}
