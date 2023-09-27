<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TestController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['bar']);
    }


    public function andrana(){
        //autorisation avec gates
       
        return view ('test.andrana');
    }
    
    public function foo(){
        //autorisation avec gates
        if(!Gate::allows('access-admin')){
            abort('403');
        }
        // $examen= Examen::
        return view ('test.foo');
    }

    public function adminIndex(){
        if(!Gate::allows('access-admin')){
            abort('403');
        }

        //ici pour chart
            //nombre : admis définitif
            $usersReussitEcrit= Inscription::where('reussitExamen', 'oui')
                ->whereIn('examen_id', function ($query){
                    $query->select('id')
                    ->from('examens')
                    ->where('typeExamen', 'ECRIT');
                })
                ->pluck('user_id');
             
            $usersReussitPratique= Inscription::where('reussitExamen', 'oui')
                ->whereIn('examen_id', function ($query){
                    $query->select('id')
                    ->from('examens')
                    ->where('typeExamen', 'PRATIQUE');
                })   
                ->pluck('user_id');
                
            $usersAdmisDefinitif= $usersReussitEcrit->intersect($usersReussitPratique);
            $nombreUsersAdmisDefinitif= count($usersAdmisDefinitif);
            // dd($nombreUsersAdmisDefinitif);    


        return view ('adminAcc');
    }

    public function cliIndex(){
        if(!Gate::allows('access-cli')){
            abort('403');
        }
        return view ('cliAcc');
    }

    public function bar(){
        return view ('test.bar');
    }
}
