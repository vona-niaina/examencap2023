<?php

namespace App\Http\Controllers\Auth;

use App\Models\Etab;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\RegisterUserRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register',[
            'etabs' => Etab::orderBy('nomEtab', 'asc')->get()
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        //     'prenom' => ['required', 'string', 'max:255'],
        //    // 'diplomeBacc' => ['']
        // ]);

        //file photoIdentite
        if($request->file('photoIdentite') != null) { 
            $fileNamePhotoIdentite = time() . '.' .$request->photoIdentite->extension();
            $pathPhotoIdentite= $request->file('photoIdentite')->storeAs('photoIdentite', $fileNamePhotoIdentite,'public' );
        }

        //file Bacc
        if ($request->file('diplomeBacc') != null) {
            $fileNameDiplomeBacc = time() . '.' . $request->diplomeBacc->extension();
            $pathBacc= $request->file('diplomeBacc')->storeAs('diplomeBacc', $fileNameDiplomeBacc,'public' );
        // }else{
        //     dd('null');
         }

         //file CAE
         if($request->file('diplomeCAE') != null) { 
            $fileNameDiplomeCAE = time() . '.' .$request->diplomeCAE->extension();
            $pathCAE= $request->file('diplomeCAE')->storeAs('diplomeCAE', $fileNameDiplomeCAE,'public' );
         }
        
         //file certificatAdmin
         if($request->file('certificatAdministratif') != null){
            $fileNameCertificatAdministratif = time() . '.' . $request->certificatAdministratif->extension();
            $pathCertificatAdministratif= $request->file('certificatAdministratif')->storeAs(
                'certificatAdministratif', $fileNameCertificatAdministratif,'public');
         }

         //insertion
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'prenom' => $request->prenom,

            'cinEnseignant' => $request->cinEnseignant,

            'etab_id' => $request->etab_id,

            'photoIdentite' => $pathPhotoIdentite?? null,

            'dateNaissance' => $request->dateNaissance,

            'dateObtentionCAE' => $request->dateObtentionCAE,
            'diplomeCAE' => $pathCAE?? null, 

            'dateObtentionBacc' => $request->dateObtentionBacc,
            'diplomeBacc' => $pathBacc?? null,

            'dateDePriseDeService' => $request->dateDePriseDeService,
            'certificatAdministratif' => $pathCertificatAdministratif?? null,
              
            'etabs_id' => $request->etabs_id?? null 
            
        ]);

        event(new Registered($user));

        Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        $role= $request->user()->admin;
            switch($role){
                case 0:
                    return redirect(route('client.index'));
                    break;
                case 1:
                    return redirect(route('admi'));
                    // return '/admi';
                    break;
                default:
                    return redirect(route('client.index'));
                    break;         
                }
    }
}
