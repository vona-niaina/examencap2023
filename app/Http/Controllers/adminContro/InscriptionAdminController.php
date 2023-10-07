<?php

namespace App\Http\Controllers\adminContro;

use App\Models\Zap;
use App\Models\User;
use App\Models\Centre;
use App\Models\Examen;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CandidatInscriptionMail;
use Illuminate\Support\Facades\Schema;
use App\Jobs\SendInscriptionEffaceMailJob;
use App\Http\Requests\adminRequest\AffectationZapSalle;

class InscriptionAdminController extends Controller
{

    //candidat par examen
    public function candidatParExamen($idExamen)
    {
        $examens= Examen::with('inscriptions')->findOrFail($idExamen);
        // $countEffectif= $examens->inscription
        $inscription= $examens->inscriptions()->paginate(10);

        //effectif
        $nombreAdmis= DB::table('inscriptions')
            ->where('examen_id', $idExamen)
            ->where('reussitExamen', 'oui')
            ->count();
            
        $nombreNonAdmis= DB::table('inscriptions')
            ->where('examen_id', $idExamen)
            ->where('reussitExamen', 'non')
            ->count();  

        $nombreEnCours= DB::table('inscriptions')
            ->where('examen_id', $idExamen)
            ->where('reussitExamen', 'En cours')
            ->count();

        $nombreTotalInscrit= DB::table('inscriptions')
            ->where('examen_id', $idExamen)
            ->count();  
        //fin effectif      

       // dd($inscription  );
       return view('adminVues.candidatParExamen', [
        'examens' => $examens,
        'inscriptions' => $inscription,
        'nombreAdmis' => $nombreAdmis,
        'nombreNonAdmis' => $nombreNonAdmis,
        'nombreEnCours' => $nombreEnCours,
        'nombreTotalInscrit' => $nombreTotalInscrit

       ]);
    } //end func


    //profil de candidat 
    public function profilCandidat($idCandidat)
    {
        $candidat = User::findOrFail($idCandidat);

        //les inscriptions de ce candidat:
        $inscriptions= $candidat->inscriptions;

        return view('profilCandidat', [
            'candidat' => $candidat,
            'inscriptions' => $inscriptions

        ]);
    }//end func

    // affecterParZap
    public function affecterParZap($idExamen)
    {
        $examens= Examen::with('inscriptions')->findOrFail($idExamen);

        //vérifier si cisco_id n'est pas null
        $zapVerifi= Zap::all();
        foreach ($zapVerifi as $zapVerifii) {
            if ($zapVerifii->cisco_id == null) {
                return redirect()->back()->with(['error'=> 'Certaines valeurs dans ZAP n\'ont pas de valeur complet ']);
            }
        }

        //d'abord vérifier s'il n'y a pas de colonne nul
        // $tableName= 'zaps';
        // $hasNullColumn = false;

        //     //Récupérer les informations sur la table
        //     // $columns = Schema::getColumnListing($tableName);
        //     $columns = DB::select('SHOW COLUMNS FROM ' . $tableName );

        //     //Parcourir chaque colonne et vérifier s'il y a des valeurs null
        //     foreach ($columns as $column) {
        //         // $isNull = Schema::hasColumn($tableName, $column) && Schema::table($tableName, function($table) use ($column) {
        //         //     $table->whereNotNull($column);
        //         // } );
                
        //         // if(!$isNull){
        //         //     $hasNullColumn = true;
        //         //     break;
        //         // }
        //         if($column->Null === 'YES'){
        //             $hasNullColumn = true;
        //             break;
        //         }
        //     }

        //     if (!$hasNullColumn) {
        //         return redirect()->back()->with(['error'=> 'Certaines valeurs dans ZAP n\'ont pas de valeur complet ']);
        //     }

        // récupérer distinct zap des candidats inscrits à idExamen
        $distinctZaps= Zap::whereHas('users.inscriptions', function($query) use ($idExamen){
            $query->where('examen_id', $idExamen);
        })
        ->distinct()
        ->get();


        // dd($distinctZaps);

        foreach ($distinctZaps as $distinctZap) {

             //récupérer pour chaque zap le nombre de candidats inscrits:
             $nombreCandidatsInscrits= $distinctZap->users()->whereHas('inscriptions', function($query) use ($idExamen){
                $query->where('examen_id', $idExamen);
             })->count();

             //récupérer pour chaque zap le nombre de candidat avec un idSalle:
             $nombreCandidatsAvecSalle= $distinctZap->users()->whereHas('inscriptions', function($query) use ($idExamen){
                $query->where('examen_id', $idExamen)
                      ->whereNotNull('salle_id');
             })->count();

             //récupérer pour chaque zap le nombre de candidat sans un idSalle:
             $nombreCandidatsSansSalle= $distinctZap->users()->whereHas('inscriptions', function($query) use ($idExamen){
                $query->where('examen_id', $idExamen)
                      ->whereNull('salle_id');
             })->count();


             //stocker les donées dans un tableau associatif
             $affectationPourView[] = [
                'zap' => $distinctZap,
                'candidatsTotal' => $nombreCandidatsInscrits,
                'candidatsAvecSalle' => $nombreCandidatsAvecSalle,
                'candidatsSansSalle' => $nombreCandidatsSansSalle
             ]; 
        }

        //dd($affectationPourView);
        return view('adminVues.affectationParZap' ,[
            'donneesZap' => $affectationPourView,
            'examens' => $examens
        ]);
    
    }//fin affecterParZap


    // affecterParZap vers CentreSalle
    public function affecterParZapCentreSalle($idZap ,$idExamen, $nbCandidatsSansSalle)
    {
        //getCentres
        // $centres = Centre::with('salles')->get();
        // $salle = Salle::
        // dd($centres);

        // $centresAvecSalleEtCandidats= [];

        // foreach($centres as $centre){
        //     $centresAvecSalleEtCandidats[]= [
        //         'centre' => $centre,
        //         'salles' => $centre->salles,
        //         // 'nombreCandidatsInscrits' => $centre->salles->map(function($salle) use ($idExamen){
        //         //     return Inscription::where('examen_id', $idExamen)->where('salle_id', $salle->id)->count();
        //         'nombreCandidatsInscrits' => Inscription::where('examen_id', $idExamen)->where('salle_id', $salles->id)->count()
                    
            
        //     ];
        // }
        $centresAvecSalle = Centre::with('salles')->get();
        $data = [];
        foreach($centresAvecSalle as $centre){
            $centreData= [
                'id'=>$centre->id,
                'nom'=> $centre->nomCentre,
                'emplacement' =>$centre->emplacementCentre,
                'salles' => []
            ];

            foreach ($centre->salles as $salle) {
                // dd($salle->numSalle);
                
                $nombreCandidatsInscrits = Inscription::where('examen_id', $idExamen)
                    ->where('salle_id', $salle->id)
                    ->count();
                    // dd($nombreCandidatsInscrits);
                $salleData = [
                    'idSalle' => $salle->id,
                    'numSalle' => $salle->numSalle,
                    'capaciteSalle' => $salle->capaciteSalle,
                    'nombreCandidatInscrits' => $nombreCandidatsInscrits
                ];

                $centreData['salles'][] = $salleData; 
            }

            $data[] = $centreData;
           
        }

        // foreach($centresAvecSalle as $centre){
        //     $salleAvecCandidats = [];

        //     foreach ($centre->salles as $salle) {
        //         // dd($salle->numSalle);
                
        //         $nombreCandidatsInscrits = Inscription::where('examen_id', $idExamen)
        //             ->where('salle_id', $salle->id)
        //             ->count();
        //             // dd($nombreCandidatsInscrits);
        //         $salleAvecCandidats = [
        //             'idSalle' => $salle->id,
        //             'numSalle' => $salle->numSalle,
        //             'capaciteSalle' => $salle->capaciteSalle,
        //             'nombreCandidatInscrits' => $nombreCandidatsInscrits
        //         ];
        //     }

        //     $centre->salles= $salleAvecCandidats;
        //     // dd($centre->salles);
            
           
        // }
    //    dd($centresAvecSalle);
    // dd($data);
        return view('adminVues.salleCentreAffectationZap' ,[
            'data' => $data,
            'idZap' =>$idZap,
            'idExamen' => $idExamen,
            'nbCandidatsSansSalle' => $nbCandidatsSansSalle
            //'centresAvecSalles' => $centresAvecSalle
        ]);

        // $affectationPourView[] = [
        //     'centre' => $centres,
        //     'salle' => $centres->salle,
        //     'nombreCandidatsInscrits' => $nombreCandidatsInscrits,
        //     'idZap' => $idZap,
        //     'idExamen' => $idExamen
        //  ]; 
    
        //get centreSalle (salle: idSalle, capacité, nombreCandidat dans inscriptions avec ce idSalle pour ce idEXamen)
        //$centreSalle= 

        // return view('adminVues.salleCentreAffectationZap' ,[
        //     'centresAvecSalleEtCandidats' => $centresAvecSalleEtCandidats,
        //     'idZap' => $idZap,
        //     'idExamen' => $idExamen
        //     // 'examens' => $examens
        // ]);

    }//fin affecterParZapCentreSalle 


    //modifier affectation salle pour des users dans zap where salle_id null
    public function modifierSalleNullIdZapAffectation(AffectationZapSalle $request,$idZap, $idExamen, $idSalle)
    {
        // dd($idSalle);
        //récupérer les utiliateurs correspndant
        $nombreCandidatsSansSalle = $request->input('nombreCandidatAAffecterSansSalle');
        if ($nombreCandidatsSansSalle < 1) {
            return redirect()->back()->with(['error'=> 'Le nombre de candidat à affecter doit être supérieur à 0 ']);
        }

        $utilisateurs = User::whereHas('etab', function($query) use ($idZap){
            $query->where('zap_id', $idZap);
        })->whereHas('inscriptions', function($query) use ($idExamen){
            $query->where('examen_id', $idExamen)->whereNull('salle_id');
        })->orderBy('name', 'ASC')->take($nombreCandidatsSansSalle)->get();

        //mettre à jour la salle  dans inscritions
        foreach ($utilisateurs as $utilisateur) {
            $utilisateur->inscriptions()->update(['salle_id' => $idSalle]);
        }

        // return redirect()->back()->with('success', 'Les candidats ont été bien affecté à la salle');
        // Route::get('/candidatParExamen/{idExamen}', [InscriptionAdminController::class, 'candidatParExamen'])->name('candidatParExamen');
        // candidatParExamen
        return to_route('admin.candidatParExamen', ['idExamen'=>$idExamen])->with('success', 'Candidats affectés à la salle acvec succès');

    }//end func


    //générer num unique
    public function genererNumUnique(Request $request,$idExamen)
    {

        //vérifier d'abord si tous les candidats ont déjà une salle
        $inscriptionVer= Inscription::where('examen_id', $idExamen)
                ->where('salle_id', '=', null)
                ->count();
        
        if ($inscriptionVer > 0) {
            return redirect()->back()->with('error', 'Il faut d\'abord attribuer une salle à tous les candidats');
        }        

        $centres= Centre::whereHas('salles.inscriptions',function($query) use ($idExamen){
            $query->where('examen_id', $idExamen);
        })->get();

        foreach ($centres as $centre) {
            $candidats= User::whereIn('id', function($query) use ($centre, $idExamen) {
                $query->select('user_id')
                    ->from('inscriptions')
                    ->join('salles', 'inscriptions.salle_id', '=', 'salles.id')
                    ->where('salles.centre_id', '=', $centre->id)
                    ->where('inscriptions.examen_id', $idExamen)
                    ->orderBy('users.name')
                    ->orderBy('salles.numSalle');
            })->get();

            $prefixeCentre= $centre->texteNumCandidat;
            $numeroUnique= 1;

            foreach ($candidats as $candidat) {
                // dd($candidat->inscriptions->numeroUniqueConvocation);
                $candidat->inscriptions()->update(['numeroUniqueConvocation'=> sprintf('%s%04d', $prefixeCentre, $numeroUnique) ]);
                // dd($candidat->inscriptions->numeroUniqueConvocation);
                $numeroUnique++;
            }
        }

        return to_route('admin.candidatParExamen', ['idExamen'=>$idExamen])->with('success', 'Numéro unique attribué avec succèss');
    }//end func
    
    
    //gestionResultat examen
    public function modifierResultat(Request $request, $idExamen)
    {
        //typeExamen
        // $examen= Examen::where('id',$idExamen)->get();
        $examen= Examen::findOrFail($idExamen);
        $typeExamen= $examen->typeExamen; 
        
        
        //obtenir les données
        $resultats= $request->input('reussitExamen', []);
        // dd($resultats);
        $selection= $request->input('selection', []);
        
        if(empty($selection)){
            return redirect()->back()->with('error', 'Vous n\'avez rien coché sur cette modification');
        }

        //parcourir les idInscription
        foreach ($selection as $idInscription) {
            //vérifier si l'idInscription existe et s'il y a un résultat sélectionné
            if (isset($resultats[$idInscription])) {
                // $candidat = User::where
                $inscription= Inscription::findOrFail($idInscription);

                //créditCandidat Actuel
                $creditCandidatActuel = $inscription->user->creditCandidat;
                // dd($creditCandidatActuel);
                // $nouveauResultat= $request->input('reussitExamen')
                // dd($inscription->user->creditCandidat);

                // dd($inscription);
                if ($typeExamen == 'ECRIT') {
                    //condition sur input et base pour modifier crédit
                    
                    //Depuis en cours
                    if ($inscription->reussitExamen == "En cours") {
                        //vers en cours et admis ne change pas le crédit de user

                        //vers non admis
                        if($resultats[$idInscription] == "non"){
                            $inscription->user()->update(['creditCandidat' => 0 ]);    
                        } 
                    }elseif ($inscription->reussitExamen == "oui") { //depuis admis
                        //vers en cours et admis lui meme ne change pas le crédit de user
                        //vers non admis
                        if($resultats[$idInscription] == "non"){
                            $inscription->user()->update(['creditCandidat' => 0 ]);  
                        }

                    }elseif($inscription->reussitExamen == "non"){ //depuis non admis
                        //vers en cours ou admis
                        if($resultats[$idInscription] == "oui" || $resultats[$idInscription] == "En cours"){
                            $inscription->user()->update(['creditCandidat' => 2 ]);  
                        }
                    }
                    
                }elseif($typeExamen == 'PRATIQUE'){
                    //Depuis en cours
                    if ($inscription->reussitExamen == "En cours") {
                        //vers en cours et admis ne change pas le crédit de user

                        //vers non admis
                        if($resultats[$idInscription] == "non"){
                            $inscription->user()->update(['creditCandidat' => $creditCandidatActuel-1 ]);    
                        } 
                    }elseif ($inscription->reussitExamen == "oui") { //depuis admis
                        //vers en cours et admis lui meme ne change pas le crédit de user
                        //vers non admis
                        if($resultats[$idInscription] == "non"){
                            $inscription->user()->update(['creditCandidat' => $creditCandidatActuel-1]);  
                        }

                    }elseif($inscription->reussitExamen == "non"){ //depuis non admis
                        //vers en cours ou admis
                        if($resultats[$idInscription] == "oui" || $resultats[$idInscription] == "En cours"){
                            $inscription->user()->update(['creditCandidat' => $creditCandidatActuel+1 ]);  
                        }
                    }
                }

                //mettre à jour le résultat sur cette inscription
                Inscription::where('id', $idInscription)->update(['reussitExamen' => $resultats[$idInscription]]);
            } 
        }

        //rediriger vers la page précédente
        return redirect()->back()->with('success', 'Résultat mis à jour avec succès');

    }//end func


    // importerCandidatPratique
    public function importerCandidatPratique($idExamen)
    {
        //mettre en condition s'il en encore de résultat en cours dans les inscriptions
        $inscriptionResultat= Inscription::where('reussitExamen', 'En cours')
            ->where('examen_id', '!=', $idExamen)
            ->count();
        if ($inscriptionResultat > 0) {
            return redirect()->back()->with('error', 'Tous les résultats encore en cours doivent être clôturés');
        }


        //inscrire tous les candidats dans les session précédentes dont le crédit > 0
        $candidatsEligibles= User::where('creditCandidat', '>' , 0)
            ->where('admin', 0)
            ->whereDoesntHave('inscriptions',function($query) use ($idExamen){
                //excluer les candidats déjà inscrits à this exam
                $query->where('examen_id', $idExamen); 
            })
            ->whereDoesntHave('inscriptions', function($query){
                $query->whereHas('examen', function($subquery){
                    $subquery->where('typeExamen', 'PRATIQUE');
                })->where('reussitExamen','oui');
            })->get();
            // ->whereDoesntHave('inscriptions', function($query) {
            //     $query->whereIn('reussitExamen', ['pratique'])
            // })

        if ($candidatsEligibles->count()) {
            foreach ($candidatsEligibles as $candidatPratique) {
                Inscription::create([
                    'user_id' => $candidatPratique->id,
                    'examen_id' => $idExamen
                ]);
            }
            
            return redirect()->back()->with('success', 'Importation candidats en pratique réussit');
        }else {
            return redirect()->back()->with('error', 'Plus aucun candidat éligible pour cet examen pratique');
        }
        


    }//end func


    //set Null NumUnique
    public function setNullNumUnique($idInscription)
    {
        $inscription = Inscription::findOrFail($idInscription);
        $inscription->numeroUniqueConvocation = null;
        $inscription->save();

        return redirect()->back()->with('success', 'Suppression de Numéro Unique avec succès');
    }//end func

    // détacherDeSalle
    public function detacherDeSalle($idInscription)
    {
        $inscription = Inscription::findOrFail($idInscription);
        $inscription->salle_id = null;
        $inscription->numeroUniqueConvocation = null;
        $inscription->save();

        return redirect()->back()->with('success', 'Candidat détaché de la salle avec succès');
    }//end func

    // deleteInscription

    public function deleteInscription($idInscription)
    {
        $inscription = Inscription::findOrFail($idInscription);
        $inscription->delete();
        // dd($inscription->user);
        
        // Mail::send(new CandidatInscriptionMail($inscription->user));
        //job 

        // envoie de mail pour ce delete
        SendInscriptionEffaceMailJob::dispatch($inscription->user);
        // dd($inscription);
        //dispatch(new SendInscriptionEffaceMail($inscription));

        return redirect()->back()->with('success', 'Inscription supprimée');
    }//end func


}
