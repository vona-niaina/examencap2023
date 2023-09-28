<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    //adminIndex
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
            
            
            //users qui a un echec en ecrit 
            $usersEchecEcrit= Inscription::where('reussitExamen', 'non')
                ->whereIn('examen_id', function ($query){
                    $query->select('id')
                    ->from('examens')
                    ->where('typeExamen', 'ECRIT');
                })
                ->pluck('user_id');
            $nombreEchecEcrit= count($usersEchecEcrit);
          
            //users qui a un echec pratique
            $usersEchecPratique= Inscription::where('reussitExamen', 'non')
            ->whereIn('examen_id', function ($query){
                $query->select('id')
                ->from('examens')
                ->where('typeExamen', 'PRATIQUE');
            })
            ->pluck('user_id');
            $nombreEchecPratique= count($usersEchecPratique);

            //users inscrits total
            $usersInscritsTotal = Inscription::count();
           
            ///users qui ont des inscriptions
            $usersAvecInscriptions= Inscription::distinct('user_id')->pluck('user_id');
            $nombreUsersAvecInscriptions= count($usersAvecInscriptions);
            
            //users sans inscriptions
            $nombreUsersSansInscriptions= User::whereNotIn('id', $usersAvecInscriptions)->count();
            
            // %reussitParCisco: bar 
            //
            $ciscos= DB::table('ciscos')
                ->select('id', 'nomCisco') 
                ->get();
            
            $pourcentagesReussite = [];

            foreach ($ciscos as $cisco) {
                $idCisco = $cisco->id;
                $nomCisco = $cisco->nomCisco;

                //Nombre total d'inscriptions pour ce Cisco
                $totalInscriptions = DB::table('inscriptions')
                    ->whereIn('user_id', function ($query) use ($idCisco) {
                        $query->select('users.id')
                            ->from('users')
                            ->join('etabs', 'users.etab_id', '=', 'etabs.id')
                            ->join('zaps', 'etabs.zap_id', '=', 'zaps.id')
                            ->where('zaps.cisco_id', $idCisco);
                    })
                    ->count();

                //nombre d'inscriptions réussites aux types écrits et pratique pour ce Cisco
                $nombreReussitesEcritPratique = DB::table('inscriptions')
                    ->where('reussitExamen', 'oui')
                    ->whereIn('examen_id', function ($query) {
                        $query->select('id')
                        ->from('examens')
                        ->whereIn('typeExamen', ['ECRIT', 'PRATIQUE']);
                    })
                    ->count();

                //calculer le pourcentage  de réussite 
                $pourcentageReussite = $totalInscriptions > 0 ? ($nombreReussitesEcritPratique / $totalInscriptions) * 100 : 0;
                $pourcentagesReussite[$idCisco] = $pourcentageReussite;   

                //$pourcentafesReussite contient maintenant le pourcentage de reussite pour chaque Cisco    
            }
            // dd($pourcentagesReussite);

            //users qui ont réussi définitivement par cisco(%sur les users qui ont une inscription sur ce cisco)
            

            //reussitParAnnee: line
            


        return view ('adminAcc');
    }//end func



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
