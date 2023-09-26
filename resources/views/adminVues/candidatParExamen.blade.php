<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Candidat par Examen</title>
    
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminCss/adminCandidatParExamen.css">
    <link rel="stylesheet" href="/css/adminCss/adminNav.css">
    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin"> Candidat dans cet Examen</h1>


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

            {{-- fin message candidat par examen --}}

                  

            {{-- table --}}
            <div class="container">
                {{-- !empty($inscriptions) && count($inscriptions) --}}
                @if (count($inscriptions) > 0)
                    <div class="enteteExamen">
                        <div class="effectifExamen">
                            <h4 class="effectif">Admis: {{$nombreAdmis}} </h4>     
                            <h4 class="effectif">Non admis: {{$nombreNonAdmis}}</h4>    
                            <h4 class="effectif">En cours: {{$nombreEnCours}}</h4>          
                            <h4 class="effectif">Total: {{$nombreTotalInscrit}}</h4> 
                        </div>
                        
                        <a href="{{route('admin.affecterParZap', ['idExamen'=>$examens->id])}}" id="affecterParZap" class="btn btn-primary">Affecter par Zap</a>  
                        <a href="{{route('admin.genererNumUnique', ['idExamen'=>$examens->id])}}" id="genererNumUnique" class="btn btn-primary">Générer N° unique</a>  
                    </div>
                      
                @else
                    <button class="btn btn-secondary" id="affecterParZap" disabled>Affecter par Zap</button>
                @endif

                {{-- if type pratique  --}}
                @if ($examens->typeExamen == "PRATIQUE")
                    <a href="{{route('admin.importerCandidatPratique', ['idExamen'=>$examens->id])}}" id="importerCandidatPratique" class="btn btn-primary">Importer candidat</a>  
                @endif
                    
                
                
                <h2>Liste des candidats de cet examen {{$examens->typeExamen}} {{$examens->anneeExamen}}</h2>     
                
                {{-- input recherche dans table  --}}
                <input type="text" id="myInput" onkeyup="myFunction()" style=" width: 50%; font-size: 16px;padding: 12px 20px 12px 40px;border: 1px solid #ddd; margin-bottom: 12px;" placeholder="Rechercher par centre">

                <form action="{{route('admin.modifierResultat', ['idExamen'=> $examens->id])}}" method="post">
                    @csrf

                    <table class="table table-striped" id="myTable">
                    <thead class="thead-dark">
                        <tr>
                        <th>X</th>
                        <th>id Inscription</th>
                        <th>id Candidat</th>
                        <th>Nom / Prénom</th>
                        <th>Email</th>
                        <th>X Résultat X</th>
                        <th>Salle</th>
                        <th>N° Unique</th>
                        <th> @if ($examens->typeExamen == "ECRIT") 
                                Date Inscription
                            @else
                                Date importation
                            @endif   
                        </th>
                        <th>Lien Voir plus</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inscriptions as $inscription)
                            <tr>
                                <td>
                                    {{-- <div class="custom-control custom-checkbox custom-control-inline custom-control-lg"> --}}
                                    
                                        {{-- <label class="container">  --}}
                                        <input type="checkbox" name="selection[]" value="{{$inscription->id}}" > 
                                        {{-- <label class="custom-control-label" for="{{$inscription->id}}">c</label> --}}
                                        {{-- <span class="checkmark"></span> --}}
                                    {{-- </div>     --}}
                                </td>
                                <td>{{$inscription->id}}</td>
                                <td>{{$inscription->user->id}}</td>
                                <td>{{$inscription->user->name}} {{$inscription->user->prenom}}</td>
                                <td>{{$inscription->user->email}}</td>
                                {{-- <td>{{$inscription->reussitExamen}}</td> --}}
                                <td>
                                    <div class="form-group" style="width:130px;">
                                        <select name="reussitExamen[{{ $inscription->id }}]" class="custom-select">
                                            <option value="En cours" @if ($inscription->reussitExamen === 'En cours') selected @endif >En cours</option>
                                            <option value="oui" @if ($inscription->reussitExamen === 'oui') selected @endif>Admis</option>
                                            <option value="non" @if ($inscription->reussitExamen === 'non') selected @endif>Non Admis</option>

                                        </select>
                                    </div>    
                                </td>
                                <td>{{$inscription?->salle?->numSalle}} - {{$inscription?->salle?->centre?->nomCentre}} {{$inscription?->salle?->centre?->emplacementCentre}}</td>
                                <td>{{$inscription->numeroUniqueConvocation}}</td>
                                <td>{{$inscription->created_at}}</td>
                                <td> <a href="{{route('admin.profilCandidat', ['idCandidat' =>$inscription->user->id ])}}">Profil candidat</a> </td>
                                <td> <button type="button" class=" btn-supprimer btn btn-danger tdSuppression" data-toggle="modal" data-target="#confirmDeleteNumUnique_{{$inscription->id}}">Enlever N°unique</button> </td>


                                {{-- modal confirm delete numUnique--}}
                                <div class="modal fade" id="confirmDeleteNumUnique_{{$inscription->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Confirmation de la suppression de N° Unique</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Etes-vous sûr de vouloir supprimer son Numéro Unique d'examen?
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{route('admin.setNullNumUnique',['idInscription' => $inscription->id]) }}" class=" btn-supprimer btn btn-danger">Supprimer</a> 
                                            
                                                {{-- <form method="post" action="{{route('admin.setNullNumUnique',['idInscription' => $inscription->id]) }}" >
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" class=" btn-supprimer btn btn-danger">Supprimer</button> 
                                                </form> --}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- fin modal confirm delete numUnique --}}



                                <td> <button type="button" class=" btn-supprimer btn btn-danger tdSuppression"  data-toggle="modal" data-target="#detacherDeSalle_{{$inscription->id}}" >Détacher de salle</button> </td>

                                {{-- modal confirm detacherDeSalle--}}
                                <div class="modal fade" id="detacherDeSalle_{{$inscription->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Demande de confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Etes-vous sûr de vouloir détacher le candidat de la salle?
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{route('admin.detacherDeSalle',['idInscription' => $inscription->id]) }}" class=" btn-supprimer btn btn-danger">Supprimer</a> 
                                            
                                                {{-- <form method="post" action="{{route('admin.setNullNumUnique',['idInscription' => $inscription->id]) }}" >
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" class=" btn-supprimer btn btn-danger">Supprimer</button> 
                                                </form> --}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- fin modal confirm detacherDeSalle --}}


                                <td> <button type="button" class=" btn-supprimer btn btn-danger tdSuppression" data-toggle="modal" data-target="#deleteInscription_{{$inscription->id}}">Supprimer inscription</button> </td>

                                {{-- modal confirm deleteInscription--}}
                                <div class="modal fade" id="deleteInscription_{{$inscription->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Confirmation de la suppression d'inscription</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Etes-vous sûr de vouloir supprimer son inscription à cet examen?
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{route('admin.deleteInscription',['idInscription' => $inscription->id]) }}" class=" btn-supprimer btn btn-danger">Supprimer</a> 
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- fin modal confirm deleteInscription --}}



                            </tr>
                        @empty
                            Pas encore d'inscription
                        @endforelse
                        
                    </tbody>
                    </table>
                    @if (count($inscriptions) > 0)
                        <button class="btn btn-primary btn-lg" type="submit">Valider la modification de résultat</button>
                    @endif    
                </form>    
            </div>
            {{-- fin table --}}

            

            {{ $inscriptions->links() }}

        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>

    <script>
        function myFunction() {
          // Declare variables
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          table = document.getElementById("myTable");
          tr = table.getElementsByTagName("tr");
        
          // Loop through all table rows, and hide those who don't match the search query
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[6];
            if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }
          }
        }
        </script>

</body>
</html>