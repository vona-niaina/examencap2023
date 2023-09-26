<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification ZAP</title>
    
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminCss/adminZap.css">
    <link rel="stylesheet" href="/css/adminCss/adminNav.css">
    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin"> Modifier ZAP</h1>


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

            {{-- fin message erreur --}}

           


            {{-- debut form modif --}}
            <div class="container">
                <h4 class="modal-title">Modification de Zap</h4>     
                            
                    <form method="POST" action="{{route('admin.modificationZap',['zap' => $zap])}}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="codeZap">Code ZAP:</label>
                            <input type="text" class="form-control" id="codeZap" placeholder="Entrer le code ZAP" name="codeZap" value="{{$zap->codeZap }}" autofocus autocomplete="codeZap" >
                        </div>
                        <div class="form-group">
                            <label for="nomZap">Nom ZAP:</label>
                            <input type="text" class="form-control" id="nomZap" placeholder="Entrer le nom de ZAP" name="nomZap" value="{{$zap->nomZap}}" autofocus autocomplete="nomZap" onchange="javascript:this.value=this.value.toUpperCase();">
                        </div>
                        
                        <div class="form-group">
                            <label for="cisco_id">Son CISCO:</label>
                            <select name="cisco_id" class="custom-select ">
                                @forelse ($ciscos as $cisco)
                                    {{-- <option value="{{$cisco->id}}" {{ old('cisco_id') === $cisco->id ? 'selected' : '' }}>{{$cisco->nomCisco}}</option> --}}
                                    <option value="{{$cisco->id}}" @selected($zap->cisco_id == $cisco->id)>{{$cisco->nomCisco}}</option>
                                @empty
                                    <h2>Pas encore de CISCO dispo, Veuillez d'abord en rajouter</h2>
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