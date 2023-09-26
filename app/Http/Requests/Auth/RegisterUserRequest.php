<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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

        $dateNavigateurParDefault= ['mm/dd/yyyy', 'mm/yyyy/dd', 'dd/mm/yyyy', 'dd/yyyy/mm', 'yyyy/mm/dd', 'yyyy/dd/mm'];

        return [
            'name' => ['required', 'string','min: 2','max:100' ],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'confirmed', Password::min(4)],
            'prenom' => ['required', 'string', 'min: 2', 'max:100'],
            'cinEnseignant' => ['required', 'digits:12', 'regex: /^\d{5}(0|1)\d{6}$/'], 
            
            'dateNaissance'=> ['required', 'date', function($attribute, $value, $fail){
                $age= now()->diff($value)->y;
                if($age < 18){
                    $fail('On doit avoir au moins 18 ans');
                }
            }],

        

            'photoIdentite'=> ['required', 'image', 'mimes:jpeg,png,jpg,gif'],

            //dateCAE
            // 'dateObtentionCAE'=> ['date',Rule::requiredIf(function(){
            //     return $this->input('diplomeCAE') !== null;
            // })],
            'dateObtentionCAE'=> ['required_with:diplomeCAE', 'nullable', function($attribute, $value, $fail) use ($dateNavigateurParDefault){
                if(in_array($value, $dateNavigateurParDefault)){
                    $this->merge(['dateObtentionCAE' => null ] );
                }elseif(!(strtotime($value))){
                    $fail('Ce n\'est pas une date valide ');
                }
            }],

            //diplomeCAE
            // 'diplomeCAE' => ['image','mimes:jpeg,png,jpg,gif','max:2048', Rule::requiredIf(function(){
            //     return $this->input('dateObtentionCAE');
            // })],
            'diplomeCAE' => ['sometimes', 'required_if:diplomeBacc,null', 'image','mimes:jpeg,png,jpg,gif'],  

            //dateBACC
            // 'dateObtentionBacc'  => ['date', Rule::requiredIf(function(){
            //     return $this->input('diplomeBacc')!== null;
            // })], 
            'dateObtentionBacc'  => ['required_with:diplomeBacc', 'nullable', function($attribute, $value, $fail) use ($dateNavigateurParDefault){
                if(in_array($value, $dateNavigateurParDefault)){
                    $this->merge(['dateObtentionBacc' => null ] );
                }elseif(!(strtotime($value))){
                    $fail('Ce n\'est pas une date valide ');
                }
            }], 

            //diplomeCAE
            // 'diplomeBacc'  => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048', Rule::requiredIf(function(){
            //     return $this->input('dateObtentionBacc');
            // })],
            'diplomeBacc'  => ['sometimes', 'required_if:diplomeCAE,null', 'image', 'mimes:jpeg,png,jpg,gif'],  

            //daterise de service
            'dateDePriseDeService'=> ['required', 'date'],

            //Certifcat administratif
            'certificatAdministratif'=> ['required', 'image', 'mimes:jpeg,png,jpg,gif']

        ];
    }//end func

    public function message()
    {
        return[
            'cin.regex' => 'Veuillez vérifier votre numéro CIN'
        ];
    }
}
