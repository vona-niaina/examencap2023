<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification CISCO</title>
    
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
            <h1 class="welcome-admin"> Modifier CISCO</h1>


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
                <h4 class="modal-title">Modification de CISCO</h4>     
                            
                    <form method="POST" action="{{route('admin.modificationCisco',['cisco' => $cisco])}}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="codeCisco">Code Cisco:</label>
                            <input type="text" class="form-control" id="codeCisco" placeholder="Entrer le code Cisco" name="codeCisco" value="{{ $cisco->codeCisco }}" autofocus autocomplete="codeCisco" >
                        </div>
                        <div class="form-group">
                            <label for="nomCisco">Nom Cisco:</label>
                            <input type="text" class="form-control" id="nomCisco" placeholder="Entrer le nom Cisco" name="nomCisco" value="{{ $cisco->nomCisco }}" autofocus autocomplete="nomCisco" onchange="javascript:this.value=this.value.toUpperCase();">
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
          
            
            {{-- modal confirm delete --}}
            <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                            <form method="post" action="#" >
                                @csrf
                                @method('delete')
                                <button type="submit" class=" btn-supprimer btn btn-danger">Supprimer</button> 
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            {{-- fin modal confirm delete --}}
            

        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>

    {{-- <script>
        //pour gérer confirmation modif
        $(document).ready(function(){
            $('#confirmationModal').on('show.bs.modal', function(e){
                let form= $(e.relatedTarget).closest('form'); //trouver le formulaire associé au bouton
                $(this).find('.modal-footer button.btn-primary').click(function(){
                    form.submit(); //soumettre le formulaire lorsque l'utilisateur confirme
                });
            });
        });
    </script> --}}

</body>
</html>