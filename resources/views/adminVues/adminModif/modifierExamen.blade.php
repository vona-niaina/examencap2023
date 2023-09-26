<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification ZAP</title>
    
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminCss/adminExamen.css">
    <link rel="stylesheet" href="/css/adminCss/adminNav.css">
    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin"> Modifier Examen</h1>


            {{-- message succes --}}
            @if (session()->has('success'))
                <div class="alert alert-info" role="alert">
                    <strong>{{ session()->get('success') }}</strong>
                </div>
            @endif


             {{-- message erreur --}}
             @if ($errors->any())
                <h3>Erreur:</h3>
                @foreach($errors->all() as $error)
                    <div style="color:red"> {{ $error }}</div>
                @endforeach
            @endif

            {{-- fin message examen --}}

           


            {{-- debut form modif --}}
            <div class="container">
                <h4 class="modal-title">Modification d'examen</h4>     
                            
                    <form method="POST" action="{{route('admin.modificationExamen',['examen' => $examen])}}">
                        @csrf
                        @method('put')
                        <label for="typeExamenEtab">Type d'examen</label> 
                                <div class="custom-control custom-radio ">
                                    <input type="radio" class="custom-control-input" id="typeExamenEcrit" name="typeExamen" value="ECRIT" @checked($examen->typeExamen === 'ECRIT') > 
                                    <label class="custom-control-label" for="typeExamenEcrit">Ecrit</label> <br>
                                </div>   
    
                                <div class="custom-control custom-radio ">
                                    <input type="radio" class="custom-control-input" id="typeExamenPratique" name="typeExamen" value="PRATIQUE" @checked($examen->typeExamen === 'PRATIQUE')>
                                    <label class="custom-control-label" for="typeExamenPratique">Pratique</label> <br>
                                </div>

                                <div class="form-group">
                                    <label for="anneeExamen">Année de l'examen:</label>
                                    <input type="number" class="form-control" id="anneeExamen" placeholder="Entrer l'année de l'examen comme 2023" name="anneeExamen" value="{{ $examen->anneeExamen }}" autofocus autocomplete="anneeExamen" >
                                </div>
                                                            
                                <div class="form-group">
                                    <label for="debutExamen">Debut Examen: </label>
                                    <input type="date" id="debutExamen" name="debutExamen" value="{{ $examen->debutExamen }}">
                                </div>

                                <div class="form-group">
                                    <label for="finExamen">Fin Examen: </label>
                                    <input type="date" id="finExamen" name="finExamen" value="{{ $examen->finExamen }}">
                                </div>

                                <div class="form-group">
                                    <label for="debutInscription">Debut Inscription: </label>
                                    <input type="date" id="debutInscription" name="debutInscription" value="{{ $examen->debutInscription }}">
                                </div>

                                <div class="form-group">
                                    <label for="finInscription">Fin Inscription: </label>
                                    <input type="date" id="finInscription" name="finInscription" value="{{ $examen->finInscription }}">
                                </div>
                        
                        {{-- modal button vers confirm --}}
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmationModal">Modifier</button>

                        <div class="modal fade " id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Etes-vous sûr de vouloir effectuer cette modification?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </form>
            </div>    
         
        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
</body>
</html>