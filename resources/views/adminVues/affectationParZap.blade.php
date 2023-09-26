<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AffectationParZap</title>
    
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/adminCss/adminAffectationParZap.css">
    <link rel="stylesheet" href="/css/adminCss/adminNav.css">
    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin"> Affectation par Zap</h1>


            {{-- message succes --}}
            @if (session()->has('success'))
                <div class="alert alert-info" role="alert">
                    <strong>{{ session()->get('success') }}</strong>
                </div>
            @endif

            {{-- fin message cisco --}}

           


            
            {{-- table --}}
            <div class="container">
                <h2>Liste Groupe Zap pour examen {{$examens->typeExamen}} {{$examens->anneeExamen}} </h2>           
                <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <th>(Cisco)</th>
                    <th>id Zap</th>
                    <th>Nom Zap</th>
                    <th>Nombre de candidats inscrits</th>
                    <th>Nombre de candidats avec Salle</th>
                    <th>Nombre de candidats sans Salle</th>
                    <th></th>
                    <th></th>
                    
                    </tr>
                </thead>
                <tbody>
                    @forelse ($donneesZap as $info)
                        <tr>
                            <td>({{$info['zap']->cisco->nomCisco}})</td>
                            <td>{{$info['zap']->id}}</td>
                            <td>{{$info['zap']->nomZap}}</td>
                            <td>{{$info['candidatsTotal']}}</td>
                            <td>{{$info['candidatsAvecSalle']}}</td>
                            <td> <strong> {{$info['candidatsSansSalle']}} </strong></td> 
                            <td><a class="btn btn-primary" href="{{route('admin.affecterParZapCentreSalle', [ 'idZap'=> $info['zap']->id, 'idExamen' => $examens->id, 'nbCandidatsSansSalle'=> $info['candidatsSansSalle']  ] )}}">Affecter en Salle...</a></td>
                            
                            {{-- <td> <button class="btn btn-secondary">Affecter</button> </td> --}}
                            {{-- <td> <button class=" btn-supprimer btn btn-danger">Supprimer</button> </td> --}}
                        </tr>
                    @empty
                        Pas d'inscrits
                    @endforelse
                    
                </tbody>
                </table>
            </div>
            {{-- fin table --}}

            {{-- <button data-toggle="collapse" class="btn btn-primary" data-target="#demo">Collapsible</button>

            <div id="demo" class="collapse">
                Lorem ipsum dolor text....
            </div>  --}}

        </div>
    </div>


    <script src="/js/adminJs/adminNav.js"></script>
    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
</body>
</html>