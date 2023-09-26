<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Centre</title>
    
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminCss/adminCentre.css">
    <link rel="stylesheet" href="/css/adminCss/adminNav.css">
    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin"> CENTRE</h1>


            {{-- message succes --}}
            @if (session()->has('success'))
                <div class="alert alert-info" role="alert">
                    <strong>{{ session()->get('success') }}</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">Erreur,veuillez vérifier dans le formulaire</div>
            @endif

            {{-- fin message centre --}}

           


            {{-- debut modal --}}
            <div class="container">
            
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-primary" id="modalAjoutCentre" data-toggle="modal" data-target="#myModal">
                Ajouter un Centre
                </button>
            
                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ajout de Centre</h4>
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
                            
                            <form method="POST" action="{{ route('admin.ajoutCentre') }}">
                                @csrf
                            <div class="form-group">
                                <label for="nomCentre">Nom Centre:</label>
                                <input type="text" class="form-control" id="nomCentre" placeholder="Entrer le nom du Centre" name="nomCentre" value="{{ old('nomCentre') }}" autofocus autocomplete="nomCentre" onchange=" javascript: return this.value = this.value.toUpperCase();">
                            </div>
                                                        
                            <div class="form-group">
                                <label for="emplacementCentre">Emplacement du Centre:</label>
                                <select name="emplacementCentre" class="custom-select ">
                                    @forelse ($etabs as $etab)
                                        <option value="{{$etab->zap?->nomZap}} - {{$etab->nomEtab}}" @selected(old('emplacementCentre')==$etab->zap?->nomZap.' - '.$etab->nomEtab ) >{{$etab->zap?->nomZap}} - {{$etab->nomEtab}} </option>
                                    @empty
                                        <h2>Pas encore d'etab pour emplacement de centre dispo, Veuillez d'abord en rajouter</h2>
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="texteNumCandidat">Prefixe pour Numero candidat:</label>
                                <input type="text" class="form-control" id="texteNumCandidat" placeholder="F.06 / " name="texteNumCandidat" value="{{old('texteNumCandidat')}}" autofocus autocomplete="texteNumCandidat" onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>

                            {{-- <div class="form-group">
                                <label for="nombre">Nombre de salle:</label>
                                <input type="number" class="form-control" id="nomCentre" placeholder="Entrer le nom du Centre" name="nomCentre" value="{{ old('nomCentre') }}" autofocus autocomplete="nomCentre" onchange=" javascript: return this.value = this.value.toUpperCase();">
                            </div> --}}
                                
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
                <h2>Liste Centres</h2>           
                <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <th>id</th>
                    <th>Nom Centre</th>
                    <th>Emplacement Centre</th>
                    <th>Prefixe N° Candidat</th>
                    <th>Nombre Salle</th>
                    <th>Lien Salle</th>
                    <th></th>
                    <th></th>
                    
                    </tr>
                </thead>
                <tbody>
                    @forelse ($centres as $centre)
                        <tr> 
                            
                            <td>{{$centre->id}}</td>
                            <td>{{$centre->nomCentre}}</td>
                            <td>{{$centre->emplacementCentre}}</td>
                            <td>{{$centre->texteNumCandidat}}</td>
                            <td>{{$centre->salles->count()}}</td>
                            <td><a href="{{route('admin.salle', ['idCentre' => $centre->id ])}}">Lien salle </a></td>
                           
                            {{-- <td></td> {{$centre->cisco?->nomCisco}} --}}
                            
                            <td> <a href="{{route('admin.versModificationCentre', ['centre' => $centre])}}" class="btn btn-secondary">Modifier</a> </td>
                            <td> <button class=" btn-supprimer btn btn-danger" data-toggle="modal" data-target="#confirmDelete_{{$centre->id}}">Supprimer</button> </td>

                            {{-- modal confirm delete --}}
                            <div class="modal fade" id="confirmDelete_{{$centre->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Confirmation de la suppression</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            Etes-vous sûr de vouloir supprimer ce centre? <br> Ses salles seront également supprimées
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post" action="{{route('admin.supprimerCentre',['idCentre' => $centre->id]) }}" >
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
                        Pas encore de Centre
                    @endforelse
                    
                </tbody>
                </table>
            </div>
            {{-- fin table --}}

            


            {{ $centres->links() }}

        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
</body>
</html>