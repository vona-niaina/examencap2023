<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CISCO</title>
    
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
            <h1 class="welcome-admin"> ZAP</h1>


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
                <button type="button" class="btn btn-primary" id="modalAjoutZap" data-toggle="modal" data-target="#myModal">
                Ajouter un ZAP
                </button>
            
                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ajout de ZAP</h4>
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
                            
                            <form method="POST" action="{{ route('admin.ajoutZap') }}">
                                @csrf
                            <div class="form-group">
                                <label for="codeZap">Code ZAP:</label>
                                <input type="text" class="form-control" id="codeZap" placeholder="Entrer le code ZAP" name="codeZap" value="{{ old('codeZap') }}" autofocus autocomplete="codeZap" >
                            </div>
                            <div class="form-group">
                                <label for="nomZap">Nom ZAP:</label>
                                <input type="text" class="form-control" id="nomZap" placeholder="Entrer le nom de ZAP" name="nomZap" value="{{old('nomZap')}}" autofocus autocomplete="nomZap" onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            
                            <div class="form-group">
                                <label for="cisco_id">Son CISCO:</label>
                                <select name="cisco_id" class="custom-select ">
                                    @forelse ($ciscos as $cisco)
                                        {{-- <option value="{{$cisco->id}}" {{ old('cisco_id') === $cisco->id ? 'selected' : '' }}>{{$cisco->nomCisco}}</option> --}}
                                        <option value="{{$cisco->id}}" @selected(old('cisco_id')==$cisco->id)>{{$cisco->nomCisco}}</option>
                                    @empty
                                        <h2>Pas encore de CISCO dispo, Veuillez d'abord en rajouter</h2>
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
                <h2>Liste ZAP</h2>           
                <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <th>id</th>
                    <th>Code ZAP</th>
                    <th>Nom ZAP</th>
                    <th>Son Cisco</th>
                    <th></th>
                    <th></th>
                    
                    </tr>
                </thead>
                <tbody>
                    @forelse ($zaps as $zap)
                        <tr>
                            <td>{{$zap->id}}</td>
                            <td>{{$zap->codeZap}}</td>
                            <td>{{$zap->nomZap}}</td>
                            <td>{{$zap->cisco?->nomCisco}}</td>
                            <td> <a href="{{route('admin.versModificationZap', ['zap' => $zap])}}" class="btn btn-secondary">Modifier</a> </td>
                            <td> <button class=" btn-supprimer btn btn-danger" data-toggle="modal" data-target="#confirmDelete_{{$zap->id}}">Supprimer</button> </td>

                            {{-- modal confirm delete --}}
                            <div class="modal fade" id="confirmDelete_{{$zap->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Confirmation de la suppression</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            Etes-vous sûr de vouloir supprimer ce ZAP? <br> Des établissements correspondant auront de ZAP vide
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post" action="{{route('admin.supprimerZap',['idZap' => $zap->id]) }}" >
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
                        Pas encore de ZAP
                    @endforelse
                    
                </tbody>
                </table>
            </div>
            {{-- fin table --}}

            

            {{ $zaps->links() }}

        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
</body>
</html>