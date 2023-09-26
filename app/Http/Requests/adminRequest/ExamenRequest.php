<?php

namespace App\Http\Requests\adminRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ExamenRequest extends FormRequest
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
            'typeExamen' => ['required', 'string', 'min:0', 'max:10',
                Rule::unique('examens')->where( function ($query){
                    return $query->where('anneeExamen', $this->input('anneeExamen'));
                    // ->where('colonne3', $this->input('colonne3'))
                })->ignore($this->route()->parameter('examen'))                
            ], 
            'anneeExamen' => ['required' ,'integer', 'min:1900', 'max: 2099'],
            'debutExamen' => ['required' ,'date', 'after:12/30/1900', 'before: 12/31/2099', 'before:finExamen', 'after:debutInscription', 'after:finInscription'],
            'finExamen' => ['required' ,'date', 'after:12/30/1900', 'before: 12/31/2099', 'after:debutInscription', 'after:finInscription', 'after:debutExamen'],
            'debutInscription' => ['required' ,'date', 'after:12/30/1900', 'before: 12/31/2099', 'before:finInscription', 'before:debutExamen', 'before:finExamen'],
            'finInscription' => ['required' ,'date', 'after:12/30/1900', 'before: 12/31/2099','before:debutExamen','before:finExamen', 'after:debutInscription'],


        ];
    }
}
