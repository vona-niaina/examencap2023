<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification Salle</title>
    
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminCss/adminSalle.css">
    <link rel="stylesheet" href="/css/adminCss/adminNav.css">
    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin"> Modifier Salle</h1>


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

            {{-- fin message salle --}}

           


            {{-- debut form modif --}}
            <div class="container">
                <h4 class="modal-title">Modification de Salle</h4>     
                            
                    <form method="POST" action="{{route('admin.modificationSalle',['salle' => $salle])}}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="numSalle">Numéro de Salle:</label>
                            <input type="number" class="form-control" id="numSalle" placeholder="Entrer le numéro de Salle" name="numSalle" value="{{ $salle->numSalle }}" autofocus autocomplete="numSalle" >
                        </div>

                        <div class="form-group">
                            <label for="capaciteSalle">Capacité de Salle:</label>
                            <input type="number" class="form-control" id="capaciteSalle" placeholder="Entrer la capacité de la Salle" name="capaciteSalle" value="{{ $salle->capaciteSalle }}" autofocus autocomplete="capaciteSalle" >
                        </div>
                                                    
                        <div class="form-group">
                            <label for="centre_id">Son centre:</label>
                            <select name="centre_id" class="custom-select ">
                                @forelse ($centres as $centre)
                                    <option value="{{$centre->id}}">{{$centre->nomCentre}} </option>
                                @empty
                                    <h2>Pas encore de centre dispo, Veuillez d'abord en rajouter</h2>
                                @endforelse
                            </select>
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