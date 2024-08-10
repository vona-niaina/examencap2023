<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Routing\Middleware\SubstituteBindings;
use App\Http\Controllers\adminContro\AdminController;
use App\Http\Controllers\clientContro\ClientController;
use App\Http\Controllers\adminContro\InscriptionAdminController;
use App\Http\Controllers\inscriptionContro\InscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/admi', '\App\Http\Controllers\TestController@adminIndex')->name('admi');
Route::get('/cli', '\App\Http\Controllers\TestController@cliIndex')->name('cli');


//******************************* */ admin *************************************************************************************
Route::prefix('admin')->name('admin.')->middleware(['auth', 'checkrole:1'])->group(function(){
    // cisco
    Route::get('/cisco', [AdminController::class, 'cisco'])->name('cisco');
    Route::post('/cisco', [AdminController::class, 'ajoutCisco'])->name('ajoutCisco');
    Route::delete('/ciscoSuppression/{idCisco}', [AdminController::class, 'supprimerCisco'])->name('supprimerCisco');
    Route::get('/versModificationCisco/{cisco}', [AdminController::class,'versModificationCisco'])->name('versModificationCisco');
    Route::put('/ciscoModification/{cisco}', [AdminController::class, 'modificationCisco'])->name('modificationCisco');
    //fin cisco

    // zap
    Route::get('/zap', [AdminController::class, 'zap'])->name('zap');
    Route::post('/zap', [AdminController::class, 'ajoutZap'])->name('ajoutZap');
    Route::delete('/zapSuppression/{idZap}', [AdminController::class, 'supprimerZap'])->name('supprimerZap');
    Route::get('/versModificationZap/{zap}', [AdminController::class,'versModificationZap'])->name('versModificationZap');
    Route::put('/zapModification/{zap}', [AdminController::class, 'modificationZap'])->name('modificationZap');
    // fin zap

    // etab
    Route::get('/etab', [AdminController::class, 'etab'])->name('etab');
    Route::post('/etab', [AdminController::class, 'ajoutEtab'])->name('ajoutEtab');
    Route::delete('/etabSuppression/{idEtab}', [AdminController::class, 'supprimerEtab'])->name('supprimerEtab');
    Route::get('/versModificationEtab/{etab}', [AdminController::class,'versModificationEtab'])->name('versModificationEtab');
    Route::put('/etabModification/{etab}', [AdminController::class, 'modificationEtab'])->name('modificationEtab');
    // fin etab

    // centre
    Route::get('/centre', [AdminController::class, 'centre'])->name('centre');
    Route::post('/centre', [AdminController::class, 'ajoutCentre'])->name('ajoutCentre');
    Route::delete('/centreSuppression/{idCentre}', [AdminController::class, 'supprimerCentre'])->name('supprimerCentre');
    Route::get('/versModificationCentre/{centre}', [AdminController::class,'versModificationCentre'])->name('versModificationCentre');
    Route::put('/centreModification/{centre}', [AdminController::class, 'modificationCentre'])->name('modificationCentre');
    // fin centre

     // salle
     Route::get('/salle/{idCentre}', [AdminController::class, 'salle'])->name('salle');
     Route::post('/salle', [AdminController::class, 'ajoutSalle'])->name('ajoutSalle');
    Route::delete('/salleSuppression/{idSalle}', [AdminController::class, 'supprimerSalle'])->name('supprimerSalle');
    Route::get('/versModificationSalle/{salle}', [AdminController::class,'versModificationSalle'])->name('versModificationSalle');
    Route::put('/salleModification/{salle}', [AdminController::class, 'modificationSalle'])->name('modificationSalle');
     // fin 
     
     // examen
     Route::get('/examen', [AdminController::class, 'examen'])->name('examen');
     Route::post('/examen', [AdminController::class, 'ajoutExamen'])->name('ajoutExamen');
     Route::delete('/examenSuppression/{idExamen}', [AdminController::class, 'supprimerExamen'])->name('supprimerExamen');
     Route::get('/versModificationExamen/{examen}', [AdminController::class,'versModificationExamen'])->name('versModificationExamen');
    Route::put('/examenModification/{examen}', [AdminController::class, 'modificationExamen'])->name('modificationExamen');
     // fin salle

     //candidat par examen
     Route::get('/candidatParExamen/{idExamen}', [InscriptionAdminController::class, 'candidatParExamen'])->name('candidatParExamen');
     Route::get('/enleverNumeroUnique/{idInscription}', [InscriptionAdminController::class, 'setNullNumUnique'])->name('setNullNumUnique'); 
     Route::get('/detacherDeSalle/{idInscription}/{idExamen}', [InscriptionAdminController::class, 'detacherDeSalle'])->name('detacherDeSalle'); 
     Route::get('/deleteInscription/{idInscription}/{idExamen}', [InscriptionAdminController::class, 'deleteInscription'])->name('deleteInscription'); 
     //fin candidat par examen  

     //profil candidat
     Route::get('/profilCandidat/{idCandidat}', [InscriptionAdminController::class, 'profilCandidat'])->name('profilCandidat');
     //fin profil candidat

     //affecter par zap  
     Route::get('/affectationSalle/{idExamen}', [InscriptionAdminController::class, 'affecterParZap'])->name('affecterParZap');
     Route::get('/affectationDonneesZap/{idZap}/{idExamen}/{nbCandidatsSansSalle}', [InscriptionAdminController::class, 'affecterParZapCentreSalle'])->name('affecterParZapCentreSalle');
       //modifier maintenant salle_id null de users by idZap 
     Route::post('/modificationSalleInscriptions/{idZap}/{idExamen}/{idSalle}', [InscriptionAdminController::class, 'modifierSalleNullIdZapAffectation'])->name('modificationAffectationZapSalleNull');  
     //fin affecter par zap  

     //générer num Unique
     Route::get('/genererNumUnique/{idExamen}', [InscriptionAdminController::class,'genererNumUnique'])->name('genererNumUnique');
     //fin generer numUnique

     //modifier résultat
     Route::post('/modifierResultat,{idExamen}', [InscriptionAdminController::class, 'modifierResultat'])->name('modifierResultat');
     //fin modifier résultat

     //importer candidat pratique  
     Route::get('/importerCandidatPratique/{idExamen}', [InscriptionAdminController::class, 'importerCandidatPratique'])->name('importerCandidatPratique');
     //fin importer candidat pratique

     //cloturer examen
     Route::post('/cloturerExamen/{idExamen}', [InscriptionAdminController::class, 'cloturerExamen'])->name('cloturerExamen');
     //fin cloturer examen

});

//**********************************fin admin *********************************************************************** */





// ******************************************************client*******************************************************************

Route::prefix('client')->name('client.')->middleware(['auth', 'checkrole:0'])->group(function(){
    // Route::get('/andrana', [AdminController::class, 'cisco'])->name('andrana');
    Route::get('/accueil', [ClientController::class, 'index'])->name('index');
    // Route::get('/cli', '\App\Http\Controllers\ClientController@cliIndex')->name('cli');
    Route::get('/inscription/examen/{user_id}/{examen_id}', [InscriptionController::class, 'inscriptionCandidat'])->name('inscriptionCandidat');

    //mesInscriptionsClient
    Route::get('/mesInscription', [InscriptionController::class, 'mesInscriptionsClient'])->name('mesInscriptionsClient');

    // getConvocationdeL'examen inscriptions
    Route::get('/obtenirConvocation/{idInscription}/{idCandidat}',[InscriptionController::class, 'obtenirConvocation'])->name('obtenirConvocation');

    //createPDF
    Route::get('/AfficherConvocation/{idInscription}',[InscriptionController::class, 'createPDF'])->name('createPDF');

    //down PDF
    Route::get('/TelechargerConvocation/{idInscription}/{idCandidat}',[InscriptionController::class, 'downloadLePDF'])->name('downloadLePDF');
});

//**********************************fin client *********************************************************************** */





Route::get('/', function () {
    return view('welcome');
});

Route::get('/foo', '\App\Http\Controllers\TestController@foo',);
Route::get('/bar', '\App\Http\Controllers\TestController@bar',);

//redirection
// Route::group(['middleware' => ['auth', 'checkrole:1']], function(){
//     //Route pour admin
//     Route::get('/admin', function(){
//         return view('admin');
//     });
// });

// Route::group(['middleware' => ['auth', 'checkrole:0']], function(){
//     //Route pour client
//     Route::get('/dashboard', function(){
//         return view('dashboard');
//     })->name('dashboard');;
// });


// Route::get('/dashboard', function () {
//     if(auth()->user()->admin){
//         return view('admin');
//     }else{
//         return view('dashboard');
//     }
    
// })->name('dashboard');

// Route:middleware(['auth'])->group(function(){
//     //dashboard
//     Route::get('/dashboard', function(){
//         if(Auth::user()->admin){
//             return view('adminAcc');
//         }else{
//             return view('dashboard');
//         }
//     })->name('dashboard');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
