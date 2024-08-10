<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cisco;
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
            $nombreUsersSansInscriptions= User::whereNotIn('id', $usersAvecInscriptions)
                                                ->where('admin', 0)
                                                ->count();
            
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
            $ciscoss= Cisco::all();

            //tableau pour stocker les résultats par Cisco
            $resultatsParCisco= [];

            foreach ($ciscoss as $cisc) {
                //comptez le nombre d'users inscrits à ce cisco
                $nombreInscriptionCisco= DB::table('ciscos')
                    ->join('zaps', 'ciscos.id', '=', 'zaps.cisco_id')
                    ->join('etabs', 'zaps.id', '=', 'etabs.zap_id')
                    ->join('users', 'etabs.id', '=', 'users.etab_id')
                    ->join('inscriptions', 'users.id', '=', 'inscriptions.user_id')
                    ->where('ciscos.id', $cisc->id)
                    ->distinct('users.id')
                    ->count();

                //comptez le nombre d'user admis définitivement dans ce cisco
                $nombreAdmisDefinitivement= DB::table('ciscos')
                    ->join('zaps', 'ciscos.id', '=', 'zaps.cisco_id')
                    ->join('etabs', 'zaps.id', '=', 'etabs.zap_id')
                    ->join('users', 'etabs.id', '=', 'users.etab_id')
                    ->join('inscriptions', 'users.id', '=', 'inscriptions.user_id')
                    ->join('examens', 'inscriptions.examen_id', '=', 'examens.id')
                    ->where('ciscos.id', $cisc->id)
                    ->where('examens.typeExamen', 'ECRIT')
                    ->where('inscriptions.reussitExamen', 'oui')
                    ->whereIn('users.id', function ($query) use ($cisc){
                        // sous requete pour trouver les users admis définitivement pour le type Pratique
                        $query->select('users.id')
                            ->from('users')
                            ->join('etabs', 'users.etab_id', '=', 'etabs.id')
                            ->join('zaps', 'etabs.zap_id', '=', 'zaps.id')
                            ->join('ciscos', 'zaps.cisco_id', '=', 'ciscos.id')
                            ->join('inscriptions', 'users.id', '=', 'inscriptions.user_id')
                            ->join('examens', 'inscriptions.examen_id', '=', 'examens.id')
                            ->where('ciscos.id', $cisc->id)
                            ->where('examens.typeExamen', 'PRATIQUE')
                            ->where('inscriptions.reussitExamen', 'oui');

                    })
                    ->count();

                // calculer le pourcentage pour ce cisco
                $pourcentageAdmisDefinitivement= $nombreInscriptionCisco > 0 ? ($nombreAdmisDefinitivement / $nombreInscriptionCisco) * 100 : 0;

                // stocker le résultat dans le tableau
                $resultatsParCisco[] = [
                    'cisco' => $cisc->nomCisco,
                    'userInscrit' => $nombreInscriptionCisco,
                    'nombreAdmisDefinitivement' => $nombreAdmisDefinitivement,
                    'pourcentage' => $pourcentageAdmisDefinitivement
                ];
                    
            }
            // dd($resultatsParCisco);


            //reussitParAnnee: line
        
            //pourcentage réussit ecrit pratique

            // total ecrit inscriptions
            $totalInscriptionsEcrit= DB::table('inscriptions')
                ->join('examens','inscriptions.examen_id', '=', 'examens.id')
                ->where('examens.typeExamen', 'ECRIT')
                ->count();
            
            // total pratique inscriptions
            $totalInscriptionsPratique= DB::table('inscriptions')
                ->join('examens', 'inscriptions.examen_id', '=', 'examens.id')
                ->where('examens.typeExamen', 'PRATIQUE')
                ->count();
            
            //nbre inscription réussie à l'examen écrit
            $inscriptionsReussitesEcrit= DB::table('inscriptions')
                ->join('examens','inscriptions.examen_id', '=', 'examens.id')
                ->where('examens.typeExamen', 'ECRIT')
                ->where('inscriptions.reussitExamen', 'oui')
                ->count();
              
            //nbre inscription réussie à l'examen pratique
            $inscriptionsReussitesPratique= DB::table('inscriptions')
                ->join('examens','inscriptions.examen_id', '=', 'examens.id')
                ->where('examens.typeExamen', 'PRATIQUE')
                ->where('inscriptions.reussitExamen', 'oui')
                ->count();    
                
            // calcul de pourcentage de réussite
            $pourcentageReussiteEcrit = $totalInscriptionsEcrit > 0 ? ($inscriptionsReussitesEcrit /$totalInscriptionsEcrit) * 100 : 0;
            $pourcentageReussitePratique = $totalInscriptionsPratique > 0 ? ($inscriptionsReussitesPratique /$totalInscriptionsPratique) * 100 : 0;

        return view ('adminAcc', [
            'data' => $resultatsParCisco,
            'inscriptionTotal' => $usersInscritsTotal,
            'nombreUsersAvecInscriptions' => $nombreUsersAvecInscriptions,
            'nombreUsersSansInscriptions' => $nombreUsersSansInscriptions,
            'nombreUsersAdmisDefinitif' => $nombreUsersAdmisDefinitif,
            'pourcentageReussiteEcrit' => $pourcentageReussiteEcrit,
            'pourcentageReussitePratique' => $pourcentageReussitePratique
        ]);
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
