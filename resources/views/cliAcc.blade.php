<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Cli</title>
        <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
        <link rel="stylesheet" href="/css/clientCss/clientNav.css">
        <link rel="stylesheet" href="/css/clientCss/clientExamen.css">

        <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana1">
        @include('partie.clientNav') 
        
        @auth
            <h1 class="bienvenue" > {{Auth::user()->email}}</h1>
        @endauth 
    </div>
    
    

    <div class="fizarana2">
         
        
        {{-- afficher erreur en modal --}}
        <div class="modal"  id="messageModal" tabindex="-1" role="dialog">
            <div class="modal-content" role="document">
                {{-- <div class="modal-content"> --}}
                    <div class="modal-header errorModal">
                        <h2 class="modal-title-inscription">
                            Message
                        </h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"> &times; </span>
                        </button>
                    </div>

                    <div class="modal-body-inscription">
                        {{-- contenu du message --}}
                    </div>

                    <div class="modal-footer errorModal">
                        <h2>Sur Inscription</h2>
                    </div>

                {{-- </div> --}}
            </div>


        </div>

        {{-- fin afficher erreur en modal --}}


        <div class="container-examen" id="container-examen">
            <div class="row" id="listeExamenToClient">
    
                    @forelse ($examens as $examen)
                        <div class="column">
                            <div class="card">
                            <img src="/mesImages/cae.jpg" alt="exam" style="width:50%; height: 20vh; margin: 4%">
                            <div class="container">
                                <h2>Examen {{$examen->typeExamen}} {{$examen->anneeExamen}} </h2>
                                <h4 class="title">De {{$examen->debutExamen}} à {{$examen->finExamen}}</h4>
                                <h4>Inscription: de <span class="badge badge-secondary"> {{$examen->debutInscription}}</span> à <span class="badge badge-secondary">{{$examen->finInscription}}</span>   </h4>
                                <p></p>
                                @if ($examen->typeExamen == 'ECRIT')
                                    <p> <a class="btn btn-dark btn-lg btn-block" href="{{route('client.inscriptionCandidat', ['user_id' => Auth::user()->id, 'examen_id' => $examen->id]) }}">S'inscrire</a> </p>
                                @else
                                {{-- <p> <a class="btn btn-dark btn-lg btn-block" href="{{route('client.inscriptionCandidat', ['user_id' => Auth::user()->id, 'examen_id' => $examen->id]) }}">S'inscrire</a> </p> --}}
                                    <p><button class="btn btn-secondary btn-lg btn-block" disabled>Inscription auto</button></p>
                                @endif
                              
                            </div>
                            </div>
                        </div>
                    @empty
                        Aucun examen dispo
                    @endforelse

           </div> 
        </div>

        
    </div>
    

    

    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
    <script src="/js/clientjs/clientAccueil.js"></script>
    <script>
        $(document).ready(function() {
            @if ($errors->has('message'))
                // afficher le modal erreur par messsage
                var modalClass= document.querySelectorAll('.successModal');
                modalClass.forEach(element => {
                    element.classList.remove('successModal');
                    element.classList.add('errorModal');
                });

                $('#messageModal .modal-body-inscription').html("{{ $errors->first('message') }}");
                $('#messageModal').modal('show');
            @endif

            @if (session()->has('success'))
                // afficher le modal erreur par messsage
                var modalClass= document.querySelectorAll('.errorModal');
                modalClass.forEach(element => {
                    element.classList.remove('errorModal');
                    element.classList.add('successModal');
                });
               

                $('#messageModal .modal-body-inscription').html("{{ session()->get('success') }}");
                $('#messageModal').modal('show');
            @endif
        })
    </script>
</body>
</html>