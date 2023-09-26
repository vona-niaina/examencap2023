<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil candidat</title>
    
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/profilCandidat.css">
    <link rel="stylesheet" href="/css/adminCss/adminNav.css">
    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin"> Profil Candidat</h1>
            <div class="fizarana21">

            
                <div class="infoCandidat">

                    {{-- message succes --}}
                    @if (session()->has('success'))
                        <div class="alert alert-info" role="alert">
                            <strong>{{ session()->get('success') }}</strong>
                        </div>
                    @endif

                    {{-- fin message profil candidat --}}
                    <h2>Information Candidat</h2>       
                    <p>Nom: {{$candidat->name}}</p>
                    <p>Prénom: {{$candidat->prenom}}</p>
                    <p>email: {{$candidat->email}} </p> 
                    <p>Date de Naissance: {{$candidat->dateNaissance}} </p> 
                    <p>CIN: {{$candidat->cinEnseignant}} </p>  
                    <p>Etab: {{$candidat->etab->nomEtab}}</p>  
                    <p>Zap: {{$candidat?->etab?->zap?->nomZap}}</p> 

                    <h2>Ses inscriptions</h2>
                    @if ($inscriptions->count()>0)
                        <ul>
                            @foreach ($inscriptions as $inscription)
                                <li>
                                    Examen: {{ $inscription->examen->typeExamen }} {{ $inscription->examen->anneeExamen }} 
                                    {{ $inscription->examen->reussitExamen }}  <br>
                                {{-- Centre:  {{ $inscription->salle->centre->nomCentre}} {{ $inscription->salle->centre->emplacementCentre}} Salle:  {{ $inscription->salle->numSalle}}  --}}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        Aucune inscription
                    @endif
                    {{-- fin infos inscription --}}
                </div>


                <div class="infoDiplome">

                    {{-- carousel image dossier --}}
                    <h2>Dossier</h2>   
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="background-color: rgb(41, 35, 35);position: relative;width: 90%;">
                        
                        {{-- indicateur de dispositive --}}
                        <ol class="carousel-indicators">
                            {{--Photo d'identité  --}}
                            <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>

                            {{-- diplome CAE --}}
                            @if ($candidat->diplomeCAE)
                                <li data-target="#carouselExampleControls" data-slide-to="1"></li>
                            @endif

                            {{-- diplome Bacc --}}
                            @if ($candidat->diplomeBacc)
                                <li data-target="#carouselExampleControls" data-slide-to="2"></li>
                            @endif

                            {{--Certiicat administratif --}}
                            <li data-target="#carouselExampleControls" data-slide-to="3"></li>

                        </ol>
                        {{-- fin indicateur de dispositif --}}

                        <div class="carousel-inner">
                            
                            {{--Photo d'identité  --}}
                            <div class="carousel-item active" >
                                <img src="{{ Storage::url($candidat->photoIdentite) }}" alt="photoIdentite" class="d-block w-100 dossierCandidat">
                                
                            </div>

                            {{-- diplome CAE --}}
                            @if ($candidat->dateObtentionCAE)
                                <div class="carousel-item">
                                    <img src="{{ Storage::url($candidat->diplomeCAE) }}" class="d-block w-100 dossierCandidat" alt="diplomeCAE">
                                    <div class="carousel-caption">
                                        <h3 style="color: black;text-align: center;font-size: 100%; font-family: 'Courier New', Courier, monospace"> 
                                            CAE:{{$candidat->dateObtentionCAE}}
                                        </h3>
                                    </div> 
                                </div>
                            @endif

                            {{-- diplome Bacc --}}
                            @if ($candidat->dateObtentionBacc)
                                <div class="carousel-item">
                                    <img src="{{ Storage::url($candidat->diplomeBacc) }}" class="d-block w-100 dossierCandidat" alt="diplomeCAE">
                                    <div class="carousel-caption">
                                        <h3 style="color: black;text-align: center;font-size: 100%; font-family: 'Courier New', Courier, monospace"> 
                                            Bacc:{{$candidat->dateObtentionBacc}}
                                        </h3>
                                    </div> 
                                </div>
                            @endif

                            {{-- d-block w-100 --}}
                            {{--Certiicat administratif --}}
                            <div class="carousel-item">
                                <img src="{{ Storage::url($candidat->certificatAdministratif) }}" alt="certificatAdministratif" class="d-block w-100 dossierCandidat" >
                                <div class="carousel-caption">
                                    <h3 style="color: black;text-align: center;font-size: 100%; font-family: 'Courier New', Courier, monospace"> 
                                        Prise de Service:{{$candidat->dateDePriseDeService}}
                                    </h3>
                                </div> 
                            </div>

                        </div>  
                        
                        <a href="#carouselExampleControls" class="caroussel-control-prev" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Précédent</span>
                        </a>

                        <a href="#carouselExampleControls" class="caroussel-control-next" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Suivant</span>
                        </a>
                    </div>   

                    {{-- fin carousel image dossier --}}
                </div>   
            </div>    
        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
</body>
</html>