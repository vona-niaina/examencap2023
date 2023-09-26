<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ETAB</title>
    
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
            <h1 class="welcome-admin"> ETAB</h1>


            {{-- message succes --}}
            @if (session()->has('success'))
                <div class="alert alert-info" role="alert">
                    <strong>{{ session()->get('success') }}</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">Erreur,veuillez vérifier dans le formulaire</div>
            @endif

            {{-- fin message cisco --}}

           


            {{-- debut modal --}}
            <div class="container">
            
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-primary" id="modalAjoutEtab" data-toggle="modal" data-target="#myModal">
                Ajouter un ETAB
                </button>
            
                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ajout d'Etab</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="container">
                             {{-- message erreur --}}
                            @if ($errors->any())
                                <h3>Erreur insertion:</h3>
                                @foreach($errors->all() as $error)
                                    <div style="color:red"> {{ $error }}</div>
                                @endforeach
                            @endif
                            
                            <form method="POST" action="{{ route('admin.ajoutEtab') }}">
                                @csrf
                            <div class="form-group">
                                <label for="codeEtab">Code Etab:</label>
                                <input type="text" class="form-control" id="codeEtab" placeholder="Entrer le code Etab" name="codeEtab" value="{{ old('codeEtab') }}" autofocus autocomplete="codeEtab" >
                            </div>
                            <div class="form-group">
                                <label for="nomEtab">Nom Etab:</label>
                                <input type="text" class="form-control" id="nomEtab" placeholder="Entrer le nom de l'Etab" name="nomEtab" value="{{old('nomEtab')}}" autofocus autocomplete="nomEtab" onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>

                            {{-- codeSecteur --}}
                            <label for="codeSecteurEtab">Code Secteur</label> 
                            <div class="custom-control custom-radio ">
                                <input type="radio" class="custom-control-input" id="codeSecteurEtab0" name="codeSecteurEtab" value="0" {{old('codeSecteurEtab') === '0' ? 'checked' : ''}}>
                                <label class="custom-control-label" for="codeSecteurEtab0">0</label> <br>
                            </div>   

                            <div class="custom-control custom-radio ">
                                <input type="radio" class="custom-control-input" id="codeSecteurEtab1" name="codeSecteurEtab" value="1" {{old('codeSecteurEtab') === '1' ? 'checked' : ''}}>
                                <label class="custom-control-label" for="codeSecteurEtab1">1</label> <br>
                            </div>

                            {{-- <div class="row"> --}}
                                {{-- <div class="col-50">
                                    <br> <label for="codeSecteurEtab">Code Secteur</label> 
                                </div>
                                <div class="col-75">
                                    <input type="radio" class="custom-control-input" id="codeSecteurEtab0" name="codeSecteurEtab" value="0">
                                    <label class="custom-control-label" for="codeSecteurEtab0">0</label> <br>
                                    
                                    <input type="radio" class="custom-control-input" id="codeSecteurEtab1" name="codeSecteurEtab" value="1">
                                    <label class="custom-control-label" for="codeSecteurEtab1">1</label> <br>
                                </div>
                              
                            </div> --}}

                            {{-- codeNiveau --}}
                            <br> <label for="NiveauEtab">Code Niveau</label> 
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="codeNiveauEtab1" name="codeNiveauEtab" value="1" {{old('codeNiveauEtab') === '1' ? 'checked' : ''}}>
                                <label class="custom-control-label" for="codeNiveauEtab1">1</label> <br>
                            </div> 

                            <div class="custom-control custom-radio ">   
                                <input type="radio" class="custom-control-input" id="codeNiveauEtab2" name="codeNiveauEtab" value="2" {{old('codeNiveauEtab') === '2' ? 'checked' : ''}}>
                                <label class="custom-control-label" for="codeNiveauEtab2">2</label> <br>
                            </div>    

                            <div class="custom-control custom-radio ">    
                                <input type="radio" class="custom-control-input" id="codeNiveauEtab3" name="codeNiveauEtab" value="3" {{old('codeNiveauEtab') === '3' ? 'checked' : ''}}>
                                <label class="custom-control-label" for="codeNiveauEtab3">3</label> <br>
                            </div>

                            {{-- <div class="row">
                                <div class="col-25">
                                    <label for="NiveauEtab">Code Niveau</label> 
                                </div>
                                <div class="col-75">
                                    <input type="radio" class="custom-control-input" id="codeNiveauEtab1" name="codeNiveauEtab" value="1">
                                    <label class="custom-control-label" for="codeNiveauEtab1">1</label> <br>
                                    
                                    <input type="radio" class="custom-control-input" id="codeNiveauEtab2" name="codeNiveauEtab" value="2">
                                    <label class="custom-control-label" for="codeNiveauEtab2">2</label> <br>

                                    <input type="radio" class="custom-control-input" id="codeNiveauEtab3" name="codeNiveauEtab" value="3">
                                    <label class="custom-control-label" for="codeNiveauEtab3">3</label> <br>
                                </div>
                              
                            </div> --}}
                            
                            <div class="form-group">
                               <br> <label for="zap_id">Son ZAP:</label>
                                <select name="zap_id" class="custom-select ">
                                    @forelse ($zaps as $zap)
                                        {{-- <option value="{{$zap->id}}" {{ old('zap_id') === $zap->id ? 'selected' : '' }}>{{$zap->nomZap}}</option> --}}
                                        <option value="{{$zap->id}}" @selected(old('zap_id') == $zap->id) >{{$zap->nomZap}}</option>
                                       
                                    @empty
                                        <h2>Pas encore de ZAP dispo, Veuillez d'abord en rajouter</h2>
                                    @endforelse
                                </select>
                            </div>
                                
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    
                    </div>
                </div>
                </div>
                
            </div>    
            {{-- fin modal --}}


       
          

            {{-- table --}}
            <div class="container">
                <h2>Liste Etab</h2>           
                <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <th>id</th>
                    <th>Code Etab</th>
                    <th>Nom Etab</th>
                    <th>Code Secteur</th>
                    <th>Code Niveau</th>
                    <th>Son Zap</th>
                    <th></th>
                    <th></th>
                    
                    </tr>
                </thead>
                <tbody>
                    @forelse ($etabs as $etab)
                        <tr>
                            <td>{{$etab->id}}</td>
                            <td>{{$etab->codeEtab}}</td>
                            <td>{{$etab->nomEtab}}</td>
                            <td>{{$etab->codeSecteurEtab}}</td>
                            <td>{{$etab->codeNiveauEtab}}</td>
                            <td>{{$etab->zap?->nomZap}}</td>
                            <td> <a href="{{route('admin.versModificationEtab', ['etab' => $etab])}}" class="btn btn-secondary">Modifier</a> </td>
                            <td> <button class=" btn-supprimer btn btn-danger" data-toggle="modal" data-target="#confirmDelete_{{$etab->id}}">Supprimer</button> </td>

                            {{-- modal confirm delete --}}
                            <div class="modal fade" id="confirmDelete_{{$etab->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Confirmation de la suppression</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            Etes-vous sûr de vouloir supprimer cet Etab? <br> Des ensignants correspondant auront d'Etab vide
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post" action="{{route('admin.supprimerEtab',['idEtab' => $etab->id]) }}" >
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class=" btn-supprimer btn btn-danger">Supprimer</button> 
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{-- fin modal confirm delete --}}

                        </tr>
                    @empty
                        Pas encore d'Etab
                    @endforelse
                    
                </tbody>
                </table>
            </div>
            {{-- fin table --}}

            


            {{ $etabs->links() }}

        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
</body>
</html>