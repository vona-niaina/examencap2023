<?php

namespace App\Http\Requests\adminRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SalleRequest extends FormRequest
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
            'numSalle' => ['required', 'integer', 'min:0', 'digits_between:1,3',
                Rule::unique('salles')->where( function ($query){
                    return $query->where('centre_id', $this->input('centre_id'));
                    // ->where('colonne3', $this->input('colonne3'))
                })->ignore($this->route()->parameter('salle'))
            ],
            
            'capaciteSalle' => ['required', 'integer', 'min:0', 'digits_between:1,3'],
            'centre_id' => ['required']
        ];
    }

    // public function message(){
    //     return[
    //         'numSalle.integer' => 'Numéro salle déjà associé à ce centre d\'examen'
    //     ];
    // }
}
