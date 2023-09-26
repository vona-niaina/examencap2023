<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CISCO</title>
    
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminCss/adminCisco.css">
    <link rel="stylesheet" href="/css/adminCss/adminNav.css">
    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin"> CISCO</h1>


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
                <button type="button" class="btn btn-primary" id="modalAjoutCisco" data-toggle="modal" data-target="#myModal">
                Ajouter un CISCO
                </button>
            
                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ajout de CISCO</h4>
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
                            
                            <form method="POST" action="{{ route('admin.ajoutCisco') }}">
                                @csrf
                            <div class="form-group">
                                <label for="codeCisco">Code Cisco:</label>
                                <input type="text" class="form-control" id="codeCisco" placeholder="Entrer le code Cisco" name="codeCisco" value="{{ old('codeCisco') }}" autofocus autocomplete="codeCisco" >
                            </div>
                            <div class="form-group">
                                <label for="nomCisco">Nom Cisco:</label>
                                <input type="text" class="form-control" id="nomCisco" placeholder="Entrer le nom Cisco" name="nomCisco" value="{{old('nomCisco')}}" autofocus autocomplete="nomCisco" onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                    
                    </div>
                </div>
                </div>
                
            </div>    
            {{-- fin modal --}}




       
          

            {{-- table --}}
            <div class="container">
                <h2>Liste Cisco</h2>           
                <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <th>id</th>
                    <th>Code CISCO</th>
                    <th>Nom CISCO</th>
                    <th></th>
                    <th></th>
                    
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ciscos as $ciscos)
                        <tr>
                            <td>{{$ciscos->id}}</td>
                            <td>{{$ciscos->codeCisco}}</td>
                            <td>{{$ciscos->nomCisco}}</td>
                            {{-- <td> <a href="{{route('admin.versModificationCisco', ['idCisco' => $ciscos->id])}}" class="btn btn-secondary">Modifier</a> </td> --}}
                            <td> <a href="{{route('admin.versModificationCisco', ['cisco' => $ciscos])}}" class="btn btn-secondary">Modifier</a> </td>
                            <td> 
                                <button type="button" class=" btn-supprimer btn btn-danger" data-toggle="modal" data-target="#confirmDelete_{{$ciscos->id}}">Supprimer</button>   
                                
                                {{-- modal confirm delete --}}
                                <div class="modal fade" id="confirmDelete_{{$ciscos->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Confirmation de la suppression</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Etes-vous sûr de vouloir supprimer ce cisco? <br> Des Zaps correspondant auront de CISCO vide
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{route('admin.supprimerCisco',['idCisco' => $ciscos->id]) }}" >
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class=" btn-supprimer btn btn-danger">Supprimer</button> 
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- fin modal confirm delete --}}
                            </td>
                        </tr>
                    @empty
                        Pas encore de cisco
                    @endforelse
                    
                </tbody>
                </table>
            </div>
            {{-- fin table --}}
            
            

            
            

        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
</body>
</html>