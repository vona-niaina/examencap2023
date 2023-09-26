<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Examen</title>
    
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
            <h1 class="welcome-admin"> Examen</h1>


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
                <button type="button" class="btn btn-primary" id="modalAjoutExamen" data-toggle="modal" data-target="#myModal">
                Ajouter un Examen
                </button>
            
                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ajout d'Examen</h4>
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
                            
                            <form method="POST" action="{{ route('admin.ajoutExamen') }}">
                                @csrf
                                
                                <label for="typeExamenEtab">Type d'examen</label> 
                                <div class="custom-control custom-radio ">
                                    <input type="radio" class="custom-control-input" id="typeExamenEcrit" name="typeExamen" value="ECRIT" {{old('typeExamen') === 'ECRIT' ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="typeExamenEcrit">Ecrit</label> <br>
                                </div>   
    
                                <div class="custom-control custom-radio ">
                                    <input type="radio" class="custom-control-input" id="typeExamenPratique" name="typeExamen" value="PRATIQUE" {{old('typeExamen') === 'PRATIQUE' ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="typeExamenPratique">Pratique</label> <br>
                                </div>

                                <div class="form-group">
                                    <label for="anneeExamen">Année de l'examen:</label>
                                    <input type="number" class="form-control" id="anneeExamen" placeholder="Entrer l'année de l'examen comme 2023" name="anneeExamen" value="{{ old('anneeExamen') }}" autofocus autocomplete="anneeExamen" >
                                </div>
                                                            
                                <div class="form-group">
                                    <label for="debutExamen">Debut Examen: </label>
                                    <input type="date" id="debutExamen" name="debutExamen" value="{{ old('debutExamen') }}">
                                </div>

                                <div class="form-group">
                                    <label for="finExamen">Fin Examen: </label>
                                    <input type="date" id="finExamen" name="finExamen" value="{{ old('finExamen') }}">
                                </div>

                                <div class="form-group">
                                    <label for="debutInscription">Debut Inscription: </label>
                                    <input type="date" id="debutInscription" name="debutInscription" value="{{ old('debutInscription') }}">
                                </div>

                                <div class="form-group">
                                    <label for="finInscription">Fin Inscription: </label>
                                    <input type="date" id="finInscription" name="finInscription" value="{{ old('finInscription') }}">
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
                <h2>Liste d'Examen</h2>           
                <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <th>id</th>
                    <th>Type</th>
                    <th>Année</th>
                    <th>Debut Examen</th>
                    <th>Fin Examen</th>
                    <th>Debut Inscription</th>
                    <th>Fin Inscription</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    
                    </tr>
                </thead>
                <tbody>
                    @forelse ($examens as $examen)
                        <tr>
                            <td>{{$examen->id}}</td>
                            <td>{{$examen->typeExamen}}</td>
                            <td>{{$examen->anneeExamen}}</td>
                            <td>{{$examen->debutExamen}}</td>
                            <td>{{$examen->finExamen}}</td>
                            <td>{{$examen->debutInscription}}</td>
                            <td>{{$examen->finInscription}}</td>
                            <td> <a href="{{route('admin.candidatParExamen', ['idExamen' => $examen->id])}}">Liste candidat</a> </td>
                            {{-- <td><a href="{{route('admin.candidat', ['idExam' => $centre->id ])}}">Lien salle </a></td> --}}
                            {{-- <td></td> {{$centre->cisco?->nomCisco}} --}}
                            
                            <td> <a href="{{route('admin.versModificationExamen', ['examen' => $examen])}}" class="btn btn-secondary">Modifier</a> </td>
                            <td> <button class=" btn-supprimer btn btn-danger" data-toggle="modal" data-target="#confirmDelete_{{$examen->id}}">Supprimer</button> </td>

                            {{-- modal confirm delete --}}
                            <div class="modal fade" id="confirmDelete_{{$examen->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Confirmation de la suppression</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            Etes-vous sûr de vouloir supprimer cet Examen? <br> Tous les inscriptions correspondantes seront effacées
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post" action="{{route('admin.supprimerExamen',['idExamen' => $examen->id]) }}" >
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
                        Pas encore d'examen dispo
                    @endforelse
                    
                </tbody>
                </table>
            </div>
            {{-- fin table --}}

            

            {{ $examens->links() }}

        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
</body>
</html>