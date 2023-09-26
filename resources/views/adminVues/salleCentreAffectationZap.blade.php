<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Les CentresSalle</title>
    
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminCss/adminAffectationParZap.css">
    <link rel="stylesheet" href="/css/adminCss/adminNav.css">
    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin "> Affectation Centre Salle</h1>


            {{-- message succes --}}
            @if (session()->has('success'))
                <div class="alert alert-info" role="alert">
                    <strong>{{ session()->get('success') }}</strong>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{ session()->get('error') }}</strong>
                </div>
            @endif

            {{-- fin message  --}}

           
            {{-- @foreach ($centresAvecSalleEtCandidats as $centreAvecSalles)
                <div class="accordion" id="centre-{{ $centreAvecSalles['centre']->id }}">
                    <div class="card">
                        <div class="card-header" id="heading-{{ $centreAvecSalles['centre']->id }}">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{ $centreAvecSalles['centre']->id }}" aria-expanded="true" aria-controls="collapse-{{ $centreAvecSalles['centre']->id }}">
                                    {{ $centreAvecSalles['centre']->nomCentre }}
                                </button>    
                            </h2> 
                        </div>

                        <div id="collapse-{{ $centreAvecSalles['centre']->id }}" class="collapse" aria-labelledby="heading-{{ $centreAvecSalles['centre']->id }}" data-parent="#centre-{{ $centreAvecSalles['centre']->id }}" >
                            <div class="card-body">
                                <ul>
                                    @foreach ($centreAvecSalles['salles'] as $salle)
                                        <li>
                                            {{ $salle->numSalle }}
                                            <span class="badge badge-primary" >{{ $centreAvecSalles['nombreCandidatsInscrits'][$loop->index] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div> --}}
                
            {{-- @empty
                Pas de salle --}}
            {{-- @endforeach --}}
            <div class="container">    
                @foreach ($data as $centre)
                    <h2 class="mb-3"> 
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#centre-{{$centre['id']}}">
                            {{$centre['nom']}} - {{$centre['emplacement']}} 
                        </button>
                        
                    </h2>
                    {{-- @dd($centre['salles']) --}}
                    <div id="centre-{{ $centre['id'] }}" class="collapse">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID salle </th>
                                    <th>N° Salle</th>
                                    <th>Capacité max</th>
                                    <th>Nombre Candidats Inscrit</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($centre['salles'] as $salle)
                                    <tr>

                                    {{-- <td>{{$salle['idSalle']}}</td> --}}
                                        <td> {{$salle['idSalle']}} </td> 
                                        <td> {{$salle['numSalle']}} </td>    
                                        <td> {{$salle['capaciteSalle']}} </td> 
                                        <td> {{$salle['nombreCandidatInscrits']}} </td>   
                                        <td>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-{{$salle['idSalle']}}">
                                                 Selectionner 
                                            </button>
                                        </td>
                                    </tr>      
                                    {{-- modal --}}
                                    <div class="modal fade" id="modal-{{ $salle['idSalle'] }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $salle['idSalle']}}-label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" >
                                                
                                                <div class="modal-header" style="background-color:DodgerBlue; color: white">
                                                    <h3 class="modal-title" id="modal-{{ $salle['idSalle'] }}-label">Détails affectation en salle</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-level="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    {{-- <p>id salle: <span id="idSalle_{{$salle['idSalle']}}">{{$salle['idSalle']}}</span> Num salle: {{$salle['numSalle']}}  </p> --}}
                                                    <p>Num salle: {{$salle['numSalle']}} </p>
                                                    <p>Capacité:  <span id="capaciteSalle_{{$salle['idSalle']}}">{{$salle['capaciteSalle']}}</span> </p>
                                                    <p>candidats inscrits dedans: {{$salle['nombreCandidatInscrits']}} </p>    

                                                    <p>Reste Place:  <span id="restePlaceSalle_{{$salle['idSalle']}}">0</span>/ <span id="capaciteFinal_{{$salle['idSalle']}}">{{$salle['capaciteSalle']-$salle['nombreCandidatInscrits']}}</span> </p>   
                                                    
                                                    {{-- <p>(max)capacité final = capacité - candidats dedans | candidat à mettre augmente -> candidat sans salle zap diminue|  </p> --}}
                                                    <p>idZap: {{$idZap}} </p>
                                                    <p>Candidat sans salle de ce zap: <span id="candidatSansSalleZap_{{$salle['idSalle']}}">{{$nbCandidatsSansSalle}}</span></p>
                                                    <p>Valeur maximum à entrer: <span id="valeurMaxInput_{{$salle['idSalle']}}">{{$nbCandidatsSansSalle}}</span></p>
                                                    {{-- <p>idExamen: {{$idExamen}}</p> --}}

                                                    <form action="{{ route('admin.modificationAffectationZapSalleNull', ['idZap'=>$idZap, 'idExamen'=>$idExamen, 'idSalle'=>$salle['idSalle'] ]) }}" method="POST">
                                                        @csrf
                                                        <input type="number" name="nombreCandidatAAffecterSansSalle" value="0" readonly id="inputInt_{{$salle['idSalle']}}" data-candidatSansSalleInitial="{{$nbCandidatsSansSalle}}" data-inputInitial="0" max="{{$salle['capaciteSalle']-$salle['nombreCandidatInscrits']}}" min="1"  >
                                                        <button class="btn btn-primary btn-lg">Valider</button>
                                                    </form>

                                                    <div class="incrementation">
                                                        <button id="btnDecrementer_{{$salle['idSalle']}}" class="btn btn-secondary" onclick="decrementer({{$salle['idSalle']}})">-</button>
                                                        <button id="btnIncrementer_{{$salle['idSalle']}}" class="btn btn-secondary" onclick="incrementer({{$salle['idSalle']}})">+</button>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    
                                                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Fermer</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                @endforeach
            </div>        
            {{-- <button data-toggle="collapse" class="btn btn-primary" data-target="#demo">Collapsible</button>

            <div id="demo" class="collapse">
                Lorem ipsum dolor text....
            </div>  --}}

        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>

    <script>
        
                function incrementer(salleId) {
                    let btnIncrementer = document.getElementById('btnIncrementer_'+salleId);
                    let inputInt = document.getElementById('inputInt_'+salleId);
                    let candidatSansSalleZap = document.getElementById('candidatSansSalleZap_'+salleId);
                    let valeurMaxInput= parseInt(document.getElementById('valeurMaxInput_'+salleId).innerText);

                    let capaciteFinalSalle = document.getElementById('capaciteFinal_'+salleId);
                    let restePlaceSalle = document.getElementById('restePlaceSalle_'+salleId);
                    // if (inputInt && candidatSansSalleZap) {
                        //valueur actuel de input
                        let valueActuelInput = parseInt(inputInt.value);
                      
                        let candidatSansSalleZapInt = parseInt(candidatSansSalleZap.innerText);
                        let capaciteFinalInt= parseInt(capaciteFinalSalle.innerText);
                        let restePlaceSalleInt= parseInt(restePlaceSalle.innerText);
                        
                        // //augmenter la valeur de l'input et dimiuer celui de span
                        if(valueActuelInput <  valeurMaxInput &&  restePlaceSalleInt < capaciteFinalInt){
                            valueActuelInput++;
                            inputInt.value = valueActuelInput;

                            restePlaceSalleInt++;
                            restePlaceSalle.textContent = restePlaceSalleInt;

                            candidatSansSalleZap.textContent = parseInt(candidatSansSalleZap.textContent) - 1;
                              

                            // if(candidatSansSalleZap==0){
                            //     btnIncrementer.disabled= true;
                            // }
                        }
                        

                    // }
                }

                function decrementer(salleId) {
                    let btnDecrementer = document.getElementById('btnDecrementer_'+salleId);
                    let inputInt = document.getElementById('inputInt_'+salleId);
                    let candidatSansSalleZap = document.getElementById('candidatSansSalleZap_'+salleId);
                    let valeurMaxInput= parseInt(document.getElementById('valeurMaxInput_'+salleId).innerText);

                    let restePlaceSalle = document.getElementById('restePlaceSalle_'+salleId);

                    let valueActuelInput = parseInt(inputInt.value);
                      
                    let candidatSansSalleZapInt = parseInt(candidatSansSalleZap.innerText);
                    let restePlaceSalleInt= parseInt(restePlaceSalle.innerText);
                    //diminuer la valeur de l'input et augmenter la valeur de candidatSansSalleZap
                    if (valueActuelInput > 0) {
                        valueActuelInput-- ;
                        inputInt.value = valueActuelInput;
                        
                        restePlaceSalleInt--;
                        restePlaceSalle.textContent = restePlaceSalleInt;

                        candidatSansSalleZap.textContent = parseInt(candidatSansSalleZap.textContent) + 1;
                    }
                }
    </script>

</body>
</html>