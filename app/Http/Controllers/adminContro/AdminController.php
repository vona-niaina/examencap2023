<?php

namespace App\Http\Controllers\adminContro;

use App\Models\Zap;
use App\Models\Etab;
use App\Models\Cisco;
use App\Models\Salle;
use App\Models\Centre;
use App\Models\Examen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\adminRequest\ZapRequest;
use App\Http\Requests\adminRequest\EtabRequest;
use App\Http\Requests\adminRequest\CiscoRequest;
use App\Http\Requests\adminRequest\SalleRequest;
use App\Http\Requests\adminRequest\CentreRequest;
use App\Http\Requests\adminRequest\ExamenRequest;

class AdminController extends Controller
{
    public function cisco()
    {
       // dd(Cisco::orderBy('created_at', 'desc')->get());
        
        return view('adminVues.cisco', [
            'ciscos' => Cisco::orderBy('created_at', 'asc')->get(),
            'ciscoForm' => new Cisco()
        ]);
    }//end func

    //ajout cisco
    public function ajoutCisco(CiscoRequest $request)
    {
        $cisco= Cisco::create($request->validated());
        return to_route('admin.cisco')->with('success', 'Le Cisco a bien été ajouté');
    }//end func

    //delete cisco
    public function supprimerCisco($idCisco)
    {
        $ciscoSup= Cisco::whereId($idCisco)->first();
        $ciscoSup->delete();
        // $ciscoSup->id->delete();
        return to_route('admin.cisco')->with('success', 'Le CISCO a bien été supprimé');
        
    }//end func

    public function versModificationCisco(Cisco $cisco)
    {
        // $cisco= Cisco::where('id',$idCisco)->first();
        return view('adminVues.adminModif.modifierCisco', [
            'cisco' => $cisco
        ]);
    }//end func

    //modif cisco
    public function modificationCisco(CiscoRequest $request, Cisco $cisco)
    {
        // $cisco= Cisco::where('id', $idCisco)->first();

        // $cisco->codeCisco = $request->codeCisco;
        // $cisco->nomCisco = $request->nomCisco;
        // $cisco->save();
        $cisco->update($request->validated());

        return to_route('admin.cisco')->with('success', 'Le Cisco a bien été modifié');

    }//end func

    //********************ZAP ************************************************************************************/
    public function zap()
    {
       //dd(Cisco::orderBy('created_at', 'desc')->get());
    //    $zap= DB::table('zaps')->paginate(10);
       $monZap = Zap::paginate(10);
    //    dd($monZap);
       //$zapp= Zap::find(1);
    //    dd($zapp->cisco->nomCisco);
    //    $zapp= Cisco::find(1)->zaps()->first();
    //    $ciscoss= Cisco::with('zap')->get();
    //    foreach ($monZap as $monZa){
    //     dd($monZa->cisco?->codeCisco);
    //        // $za= $ciscosss->zap?->nomZap;
    //    }
       
    // //    $zapp= $ciscoss->zap?->nomZap;
    //    dd($zapp);
       //dd($zapp->nomZap);

        return view('adminVues.zap', [
            'zaps' => $monZap,
            'ciscos' =>Cisco::orderBy('nomCisco', 'asc')->get()
        ]);
    }//end func

    public function ajoutZap(ZapRequest $request)
    {
        // dd($request->validated());
        $zap= Zap::create($request->validated());
        // dd($zap);
        // $zap = new Zap;
        // $zap->codeZap = $request->codeZap;
        // $zap->nomZap = $request->nomZap;
        // $zap->cisco_id = $request->cisco_id;

        // $zap->save();
       
        return to_route('admin.zap')->with('success', 'Le ZAP a bien été ajouté');
    }//end func

    public function supprimerZap($idZap)
    {
        $zap= Zap::whereId($idZap)->first();
        $zap->delete();
        // $ciscoSup->id->delete();
        return to_route('admin.zap')->with('success', 'Le ZAP a bien été supprimé');
    }// end func

    //vers edit
    public function versModificationZap(Zap $zap)
    {
        // $cisco= Cisco::where('id',$idCisco)->first();


        return view('adminVues.adminModif.modifierZap', [
            'zap' => $zap,
            'ciscos' =>Cisco::orderBy('nomCisco', 'asc')->get()
        ]);
    }//end func

    //modif zap
    public function modificationZap(ZapRequest $request, Zap $zap)
    {
        $zap->update($request->validated());

        return to_route('admin.zap')->with('success', 'Le Zap a bien été modifié');

    }//end func

    //********************fin ZAP ************************************************************************************/


     //********************ETAB ************************************************************************************/
     public function etab()
     {
        $monEtab = Etab::paginate(10);

         return view('adminVues.etab', [
             'etabs' => $monEtab,
             'zaps' =>Zap::orderBy('nomZap', 'asc')->get()
         ]);
     }//end func
 
     public function ajoutEtab(EtabRequest $request)
     {
         // dd($request->validated());
         $etab= Etab::create($request->validated());
        
         return to_route('admin.etab')->with('success', 'L\'étalissement a bien été ajouté');
     }//end func


     //supprimer etab
     public function supprimerEtab($idEtab)
    {
        $etab= Etab::whereId($idEtab)->first();
        $etab->delete();
        // $ciscoSup->id->delete();
        return to_route('admin.etab')->with('success', 'L\'Etab a bien été supprimé');
    }// end func


    //vers edit
    public function versModificationEtab(Etab $etab)
    {
       
        return view('adminVues.adminModif.modifierEtab', [
            'etab' => $etab,
            'zaps' =>Zap::orderBy('nomZap', 'asc')->get()
        ]);
    }//end func

    //modif etab
    public function modificationEtab(EtabRequest $request, Etab $etab)
    {
        $etab->update($request->validated());

        return to_route('admin.etab')->with('success', 'L\'Etab a bien été modifié');

    }//end func


 
     //********************fin ETAB ************************************************************************************/


      //********************Centre ************************************************************************************/
      public function centre()
      {
         $monCentre = Centre::paginate(10);
 
          return view('adminVues.centre', [
              'centres' => $monCentre,
              'etabs' =>Etab::orderBy('nomEtab', 'asc')->get()
          ]);
      }//end func
  

      //ajout centre
      public function ajoutCentre(CentreRequest $request)
      {
          // dd($request->validated());
          $centre= Centre::create($request->validated());
         
          return to_route('admin.centre')->with('success', 'Le centre a bien été ajouté');
      }//end func

      //supprimer centre
     public function supprimerCentre($idCentre)
     {
         $centre= Centre::whereId($idCentre)->first();
         $centre->delete();
         // $ciscoSup->id->delete();
         return to_route('admin.centre')->with('success', 'Le centre a bien été supprimé');
     }// end func

     //vers edit
    public function versModificationCentre(Centre $centre)
    {
       
        return view('adminVues.adminModif.modifierCentre', [
            'centre' => $centre,
            'etabs' =>Etab::orderBy('nomEtab', 'asc')->get()
        ]);
    }//end func

    //modif centre
    public function modificationCentre(CentreRequest $request, Centre $centre)
    {
        $centre->update($request->validated());

        return to_route('admin.centre')->with('success', 'Le centre a bien été modifié');

    }//end func

  
      //********************fin CENTRE ************************************************************************************/


      //********************Salle ************************************************************************************/
      public function salle($idCentre)
      {
        // $monSalle = Salle::paginate(10);
        //$monCentre = Salle::find($idCentre);
       // dd($idCentre);
        $monSalle = Salle::where('centre_id',$idCentre)->paginate(10);
        // $monSalle = Salle::select('id', 'numSalle', 'capaciteSalle', 'centre_id')
        //             ->where('centre_id',$idCentre)
        //             ->get();

          return view('adminVues.salle', [
              'salles' => $monSalle,
            //   'centres' =>Centre::orderBy('nomCentre', 'asc')->get()
              'centres' =>Centre::where('id',$idCentre)->get()
          ]);
      }//end func
  
      public function ajoutSalle(SalleRequest $request)
      {
          // dd($request->validated());
          $salle= Salle::create($request->validated());
          //$idCentre = $salle->
         
        //   return to_route('admin.salle',['idCentre'=>1])->with('success', 'La salle a bien été ajouté');
        return to_route('admin.centre')->with('success', 'La salle a bien été ajouté');
      }//end func

      //suppression salle
      public function supprimerSalle($idSalle)
     {
         $salle= Salle::whereId($idSalle)->first();
         $salle->delete();
         // $ciscoSup->id->delete();
         return to_route('admin.centre')->with('success', 'La salle a bien été supprimé');
     }// end func

     //vers edit
    public function versModificationSalle(Salle $salle)
    {   
        $centre= $salle->centre;
                  
        return view('adminVues.adminModif.modifierSalle', [
            'salle' => $salle,
            'centres' =>Centre::where('id', $centre->id)->orderBy('nomCentre', 'asc')->get()
        ]);
    }//end func

    //modif salle
    public function modificationSalle(SalleRequest $request, Salle $salle)
    {
        $salle->update($request->validated());

        return to_route('admin.centre')->with('success', 'La salle a bien été modifiée');

    }//end func

  
      //********************fin salle ************************************************************************************/


      //********************examen ************************************************************************************/
      public function examen()
      {
         $monExamen = Examen::orderBy('anneeExamen', 'desc')->paginate(5);
 
          return view('adminVues.examen', [
              'examens' => $monExamen,
              //'etabs' =>Etab::orderBy('nomEtab', 'asc')->get()
          ]);
      }//end func
  
      public function ajoutExamen(ExamenRequest $request)
      {
          // dd($request->validated());
          $examen= Examen::create($request->validated());
         
          return to_route('admin.examen')->with('success', 'l\'Examen a bien été ajouté');
      }//end func
  
      
      //suppression examen
      public function supprimerExamen($idExamen)
     {
         $examen= Examen::whereId($idExamen)->first();
         $examen->delete();
         // $ciscoSup->id->delete();
         return to_route('admin.examen')->with('success', 'L\'examen a bien été supprimé');
     }// end func

     //vers edit
    public function versModificationExamen(Examen $examen)
    {   
                       
        return view('adminVues.adminModif.modifierExamen', [
            'examen' => $examen,
        ]);
    }//end func

    //modif examen
    public function modificationExamen(ExamenRequest $request, Examen $examen)
    {
        $examen->update($request->validated());

        return to_route('admin.examen')->with('success', 'L\'examen a bien été modifié');

    }//end func

      //********************fin CENTRE ************************************************************************************/
}
