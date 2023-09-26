<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification ZAP</title>
    
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminCss/adminEtab.css">
    <link rel="stylesheet" href="/css/adminCss/adminNav.css">
    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin"> Modifier Etab</h1>


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

            {{-- fin message cisco --}}

           


            {{-- debut form modif --}}
            <div class="container">
                <h4 class="modal-title">Modification d'Etab</h4>     
                            
                    <form method="POST" action="{{route('admin.modificationEtab',['etab' => $etab])}}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="codeEtab">Code Etab:</label>
                            <input type="text" class="form-control" id="codeEtab" placeholder="Entrer le code Etab" name="codeEtab" value="{{ $etab->codeEtab }}" autofocus autocomplete="codeEtab" >
                        </div>
                        <div class="form-group">
                            <label for="nomEtab">Nom Etab:</label>
                            <input type="text" class="form-control" id="nomEtab" placeholder="Entrer le nom de l'Etab" name="nomEtab" value="{{ $etab->nomEtab }}" autofocus autocomplete="nomEtab" onchange="javascript:this.value=this.value.toUpperCase();">
                        </div>

                        {{-- codeSecteur --}}
                        <label for="codeSecteurEtab">Code Secteur</label> 
                        <div class="custom-control custom-radio ">
                            <input type="radio" class="custom-control-input" id="codeSecteurEtab0" name="codeSecteurEtab" value="0" {{$etab->codeSecteurEtab == '0' ? 'checked' : ''}}>
                            <label class="custom-control-label" for="codeSecteurEtab0">0</label> <br>
                        </div>   

                        <div class="custom-control custom-radio ">
                            <input type="radio" class="custom-control-input" id="codeSecteurEtab1" name="codeSecteurEtab" value="1" {{ $etab->codeSecteurEtab == '1' ? 'checked' : ''}}>
                            <label class="custom-control-label" for="codeSecteurEtab1">1</label> <br>
                        </div>

                        <br> <label for="NiveauEtab">Code Niveau</label> 
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="codeNiveauEtab1" name="codeNiveauEtab" value="1" {{ $etab->codeNiveauEtab == '1' ? 'checked' : ''}}>
                            <label class="custom-control-label" for="codeNiveauEtab1">1</label> <br>
                        </div> 

                        <div class="custom-control custom-radio ">   
                            <input type="radio" class="custom-control-input" id="codeNiveauEtab2" name="codeNiveauEtab" value="2" {{ $etab->codeNiveauEtab == '2' ? 'checked' : ''}}>
                            <label class="custom-control-label" for="codeNiveauEtab2">2</label> <br>
                        </div>    

                        <div class="custom-control custom-radio ">    
                            <input type="radio" class="custom-control-input" id="codeNiveauEtab3" name="codeNiveauEtab" value="3" {{ $etab->codeNiveauEtab == '3' ? 'checked' : ''}}>
                            <label class="custom-control-label" for="codeNiveauEtab3">3</label> <br>
                        </div>

                        <div class="form-group">
                            <br> <label for="zap_id">Son ZAP:</label>
                             <select name="zap_id" class="custom-select ">
                                 @forelse ($zaps as $zap)
                                     {{-- <option value="{{$zap->id}}" {{ old('zap_id') === $zap->id ? 'selected' : '' }}>{{$zap->nomZap}}</option> --}}
                                     <option value="{{$zap->id}}" @selected($etab->zap_id == $zap->id) >{{$zap->nomZap}}</option>
                                    
                                 @empty
                                     <h2>Pas encore de ZAP dispo, Veuillez d'abord en rajouter</h2>
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