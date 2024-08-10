<?php

namespace App\Http\Controllers\inscriptionContro;

// use PDF;
use App\Models\User;
use App\Models\Examen;
// use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\FacadePDF;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InscriptionRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InscriptionController extends Controller
{
    
    // public function inscriptionCandidat(Request $request, $user_id, $examen_id)
    // {
    //     //assurer que l'user actuel est authentifié
    //     if(Auth::check()){
    //         //le récupérer par son ID
    //         $user= Auth::user();
    //         $examen= Examen::findOrFail($examen_id);

    //         //assurer que l'id User correspon à id passé en paramètre
    //         if($user->id == $user_id){
    //             //if diplome bacc
    //             if($user->diplomeBacc){
    //                 if($user->dateObtentionBacc){
    //                     $dateObtentionBacc= Carbon::parse($user->dateObtentionBacc);
    //                     $dateDePriseDeService= Carbon::parse($user->dateDePriseDeService);

    //                     $dateLimiteInscriptionBacc = Carbon::parse($examen->debutExamen)->subYears(2);

    //                     //si dateObtentionBacc est dans les 2 ans avant le début de l'examen, on autorise
    //                     if( $dateLimiteInscriptionBacc->greaterThanOrEqualTo($dateDePriseDeService )){
    //                         Inscription::create([
    //                             'user_id' => $user_id,
    //                             'examen_id' => $examen_id,
    //                         ]);
    //                         return to_route('client.index')->with('success', 'Inscription réussie'); 
    //                     }


    //                 }

    //             } //fin if diplomeBacc

    //             //if diplome CAE
    //             if($user->diplomeCAE){
    //                 $dateObtentionCAE= Carbon::parse($user->dateObtentionCAE);
    //                 $dateLimiteInscriptionCAE= Carbon::parse($examen->debutExamen)->subYears(2);

    //                 if( $dateLimiteInscriptionCAE-> greaterThanOrEqualTo($dateObtentionCAE)){
    //                     Inscription::create([
    //                         'user_id' => $user_id,
    //                         'examen_id' => $examen_id,
    //                     ]);
    //                     return to_route('client.index')->with('success', 'Inscription réussie'); 
    //                 }

    //             }// fin if diplomeCAE

               

    //             //rediriger l'user vers confirmation ou page
    //             // return to_route('client.index')->with('success', 'Inscription réussie'); 
    //         }else {
    //             //si les id user sont différents 
    //             return to_route('client.index')->with('error', 'Erreur d\'authentification'); 
    //         }

    //     }else {
    //         return to_route('login')->with('error', 'Veuillez vous authentifer'); 
    //     }

    //     return to_route('client.index')->with('error', 'Vous n\'avez pas les conditions requises sur les dossiers');    

    // }//end func

    public function inscriptionCandidat(Request $request, $user_id, $examen_id)
    {
        //assurer que l'user actuel est authentifié
       
            //le récupérer par son ID
            $user= User::findOrFail($user_id);
            $examen= Examen::findOrFail($examen_id);

            $currentDate= now();

            //vérifier si le candidat est encore en cours d'examen(le crédit n'est pas 0)
            $isCandidatEnCours = User::where('id', $user_id)
                ->where('creditCandidat', '>', 0 )
                ->first();
           
 
            if($isCandidatEnCours){
                $isInscriptionDeCeCandidat= Inscription::where('user_id', $isCandidatEnCours->id)->first();
               
                if ($isInscriptionDeCeCandidat) {
                    return to_route('client.index')->withErrors(['message'=> 'Vous êtes déjà en phase de candidature à des sessions']);    
                }
                
            }


            //assurer que l'id User correspon à id passé en paramètre

                //déjà admis définitif
                $isAdmisEcrit= Inscription::where('user_id', $user_id)
                    ->where('reussitExamen', 'oui')
                    ->whereHas('examen',function($query){
                        $query->where('typeExamen', 'ECRIT');
                    })->exists();

                 
                $isAdmisPratique=Inscription::where('user_id', $user_id)
                    ->where('reussitExamen', 'oui')
                    ->whereHas('examen', function($query){
                        $query->where('typeExamen', 'PRATIQUE');
                    })->exists();

                    // dd($isAdmisEcrit);
                    // dd($isAdmisPratique);  
                    
                //maintenant rediriger    
                if($isAdmisEcrit && $isAdmisPratique){
                    return to_route('client.index')->withErrors(['message'=> 'Vous êtes déjà un enseignant admis définitive']);    
                }
                //vérifier un par un
                //vérifier admission écrit
                // $isAdmisEcrit= User::find($user_id)->inscriptions()->whereHas('examen', functon($query){
                //     $query->where('typeExamen',)
                // })    
               
                 

                // $reussirEcrit= Inscription::where('user_id', $user_id)
                //     ->where('reussitExamen', '1') 
                //     ->whereHas('examen',function($query){
                //         $query->where('typeExamen', 'ECRIT');
                //     })
                //     ->whereHas('examen', function($query){
                //         $query->where('typeExamen', 'PRATIQUE');
                //     })
                //     ->get() ;  
                // dd($reussirEcrit);    

                // if ($admissionDefinitive) {
                //     return to_route('client.index')->withErrors(['message'=> 'Vous êtes déjà un enseignant admis définitive']);    
                // }  

                //inscription existance
                $inscriptionExistante= Inscription::where('user_id', $user_id)
                    ->where('examen_id', $examen_id)
                    ->first();
                if ($inscriptionExistante) {
                    return to_route('client.index')->withErrors(['message'=> 'Vous êtes déjà inscrit(e) sur cet examen']);    
                }    

                //if diplome bacc
                if($user->diplomeBacc){
                    if($user->dateObtentionBacc){
                        $dateObtentionBacc= Carbon::parse($user->dateObtentionBacc);
                        $dateDePriseDeService= Carbon::parse($user->dateDePriseDeService);

                        $dateLimiteInscriptionBacc = Carbon::parse($examen->debutExamen)->subYears(2);

                        //si dateObtentionBacc est dans les 2 ans avant le début de l'examen, on autorise
                        if( $dateLimiteInscriptionBacc->greaterThanOrEqualTo($dateDePriseDeService )){
                            Inscription::create([
                                'user_id' => $user_id,
                                'examen_id' => $examen_id,
                            ]);
                            //et changer le crédit en 2 
                            $user->creditCandidat = 2;
                            $user->save();
                            
                            return to_route('client.index')->with('success', 'Inscription réussie'); 
                        }


                    }

                } //fin if diplomeBacc

                //if diplome CAE
                if($user->diplomeCAE){
                    $dateObtentionCAE= Carbon::parse($user->dateObtentionCAE);
                    $dateLimiteInscriptionCAE= Carbon::parse($examen->debutExamen)->subYears(2);

                    if( $dateLimiteInscriptionCAE-> greaterThanOrEqualTo($dateObtentionCAE)){
                        Inscription::create([
                            'user_id' => $user_id,
                            'examen_id' => $examen_id,
                        ]);
                        //et changer le crédit en 2 
                        $user->creditCandidat = 2;
                        $user->save();

                        return to_route('client.index')->with('success', 'Inscription réussie'); 
                    }

                }// fin if diplomeCAE

                //vérification PériodeInscription
                $isPeriodeinscriptionEcrit= User::find($user_id)->inscriptions()->whereHas('examen', function($query) use($currentDate, $examen_id){
                    $query->where('id', $examen_id)
                        ->where('debutInscription', '<=', $currentDate)
                        ->where('finInscription', '>=', $currentDate);
                })->exists();
                
                if ($isPeriodeinscriptionEcrit) {
                    Inscription::create([
                        'user_id' => $user_id,
                        'examen_id' => $examen_id,
                    ]);
                    //et changer le crédit en 2 
                    $user->creditCandidat = 2;
                    $user->save();

                    return to_route('client.index')->with('success', 'Inscription réussie'); 
                    
                }   

            return to_route('client.index')->withErrors(['message'=> 'Vous n\'avez pas les conditions requises sur les dossiers']);    

    }//end func


    //les inscriptions de client
    public function mesInscriptionsClient()
    {
        //getAllInscription de this client
        $user= Auth::user();
        $mesInscriptions= $user->inscriptions;
        return view ('clientVues.mesInscriptionsClient', ['inscriptions'=> $mesInscriptions]);
    }//end func

    
    //convocation
    public function obtenirConvocation($idInscription, $idCandidat)
    {
        $inscription= Inscription::findOrFail($idInscription);
        $candidat= User::findOrFail($idCandidat);

        //vérifier si l'examen est déjà cloturé
        $idExamen= $inscription->examen_id;
        $examenCloture= Examen::findOrFail($idExamen);
        if($examenCloture->cloture == '0'){
            return redirect()->back()->with('error', 'La distrubition de salle et numéro unique sont encore en cours, veuillez réessayer plus tard');
        }

        //vérifier d'abord s'il a numUnique et salle
        if($inscription->numeroUniqueConvocation == null || $inscription->salle_id == null ){
            return redirect()->back()->with(['error'=> 'Vous n\'avez pas encore de salle ou de numéro unique, veuillez attendre ']);
        }

        //codeQr
        $candidatData= [
            'Centre' => $inscription->salle->centre->nomCentre ,
            'EmplacementCentre' => $inscription->salle->centre->emplacementCentre,
            'Salle' => $inscription->salle->numSalle,
            'Examen' => $inscription->examen->typeExamen,
            'AnneeExamen' => $inscription->examen->anneeExamen,
            'Nom' => $candidat->name,
            'Prenom' => $candidat->prenom,
            'CIN' => $candidat->cinEnseignant
        ];

        // lien vers profil du candidat
        // $profilLink = 'http://127.0.0.1:8000/verification/profilCandidat/'. $candidat->id  ;
        $profilLink = url('http://127.0.0.1:8000/')  ;
        
        // les données et le lien
        $qrData = [
            'Candidat' => $candidatData,
            // 'Profil' => $profilLink
        ];

        // formatez les données
        // $formattedData = "EXAMEN: ". $candidatData['Examen'] . " " . $candidatData['AnneeExamen'] ; 
        // "\nCENTRE: " . $candidatData['Centre'] . " à " . $candidatData['EmplacementCentre'] . "SALLE N°: " . $candidatData['Salle'] . 
        // "\nNOM: " . $candidatData['Nom'] . " " . $candidatData['Prenom'] . 
        // "\nCIN: " . $candidatData['CIN'];

        
        //convertir en JSON
        $jsonData = json_encode($qrData, JSON_PRETTY_PRINT);
        
        // Générer le code QR à partir de ces données 
        // $qrCode = QrCode::size(130)->generate($jsonData);
        $qrCode = QrCode::format('png')->size(210)->generate($jsonData);
        // dd($qrCode);
        

        // dd($inscription);
        return view('clientVues.convocation', [
            'inscription' => $inscription,
            'idInscription' => $idInscription,
            'qrCode' => $qrCode,
            'candidat' => $candidat
        ]);
    }//end func

     //create PDF
    public function createPDF($idInscription)
    {
        // $inscription= Inscription::findOrFail($idInscription);

        //share data to view
        $inscription= Inscription::findOrFail($idInscription);
        

        //vérifier d'abord s'il a numUnique et salle
        if($inscription->numeroUniqueConvocation == null || $inscription->salle_id == null ){
            return redirect()->back()->with(['error'=> 'Vous n\'avez pas encore de salle ou de numéro unique, veuillez attendre ']);
        }
        
        return Pdf::loadView('clientVues.convocation', ['inscription'=> $inscription])->download('telechargement.pdf');
        // view()->share('inscription',$inscription);

        // $pdf= PDF::loadView('client.convocation', ['inscription'=>$inscription]);
        // $pdf= PDF::loadView('clientVues.convocation', ['inscription'=>$inscription]);
        // $pdf= Pdf::loadView('clientVues.convocation', ['inscription'=>$inscription]);
        // return Pdf::loadView('clientVues.convocation', ['inscription'=>$inscription])->save('convo/convoocation.pdf');
        // return $pdf->download('monconvoc.pdf')->stream();
        //download PDF file with download method
        // return $pdf->download('convocation_file.pdf'); 

       
    }//end func


    public function downloadLePDF($idInscription, $idCandidat)
    {
        $inscription= Inscription::findOrFail($idInscription);
        $candidat= User::findOrFail($idCandidat);

        //vérifier si l'examen est déjà cloturé
        $idExamen= $inscription->examen_id;
        $examenCloture= Examen::findOrFail($idExamen);
        if($examenCloture->cloture == '0'){
            return redirect()->back()->with('error', 'La distrubition de salle et numéro unique sont encore en cours, veuillez réessayer plus tard');
        }

        //vérifier d'abord s'il a numUnique et salle
        if($inscription->numeroUniqueConvocation == null || $inscription->salle_id == null ){
            return redirect()->back()->with(['error'=> 'Vous n\'avez pas encore de salle ou de numéro unique, veuillez attendre ']);
        }

        //codeQr
        $candidatData= [
            'Centre' => $inscription->salle->centre->nomCentre ,
            'EmplacementCentre' => $inscription->salle->centre->emplacementCentre,
            'Salle' => $inscription->salle->numSalle,
            'Examen' => $inscription->examen->typeExamen,
            'AnneeExamen' => $inscription->examen->anneeExamen,
            'Nom' => $candidat->name,
            'Prenom' => $candidat->prenom,
            'CIN' => $candidat->cinEnseignant
        ];

        // les données et le lien
        $qrData = [
            'Candidat' => $candidatData,
            // 'Profil' => $profilLink
        ];


        //convertir en JSON
        $jsonData = json_encode($qrData, JSON_PRETTY_PRINT);
        
        // Générer le code QR à partir de ces données 
        // $qrCode = QrCode::size(130)->generate($jsonData);
        $qrCode = QrCode::format('png')->size(230)->generate($jsonData);
        // dd($qrCode);


        // landscape
        return Pdf::loadView('clientVues.convocationDownload', ['inscription'=> $inscription, 'qrCode' => $qrCode])->setPaper('a4', 'portrait')->download('convoc/telechargement.pdf');
        // return Pdf::loadView('clientVues.convocationDownload', ['inscription'=>$inscription])->save('convocation/convocation.pdf');
        // $pdf= PDF::loadView('clientVues.convocation', ['inscription'=>$inscription]);
        // return Pdf::loadView('clientVues.convocation', ['inscription'=>$inscription])->save('convo/convoocation.pdf');
        // return $pdf->download('monconvoc.pdf')->stream();

    }//end func
}
