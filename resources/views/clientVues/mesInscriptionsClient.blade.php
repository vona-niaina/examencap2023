<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Cli</title>
        <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
        <link rel="stylesheet" href="/css/clientCss/clientNav.css">
        <link rel="stylesheet" href="/css/clientCss/clientInscription.css">

        <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="fizarana1">
        @include('partie.clientNav') 
    </div>

    <div class="fizarana2">
        {{-- @auth
        <h1 class="bienvenue" >Mes Inscriptions</h1>
        @endauth   --}}
        
         {{-- table --}}
         <div class="container">
           
            
            <h2 class="monEntete">Mes Inscriptions</h2> 
            
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

            {{-- fin message  --}}

            <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                <th>id Inscription</th>      
                <th>Examen</th>
                <th>Résultat</th>
                <th>Centre</th>
                <th>Salle</th>
                <th>N° Unique</th>
                <th>Date Inscription</th>
                <th>Lien </th>
                <th></th>
                
               
                
                </tr>
            </thead>
            <tbody>
                @forelse ($inscriptions as $inscription)
                    <tr>
                        <td>{{$inscription->id}}</td>
                        <td>{{$inscription->examen->typeExamen}} {{$inscription->examen->anneeExamen}}</td>
                        <td>
                            @if ($inscription->reussitExamen === 'En cours')
                                <h3>En cours</h3>
                            @elseif($inscription->reussitExamen === 'oui')
                                <h3 style="color:#04AA6D;">Admis</h3>
                            @elseif($inscription->reussitExamen === 'non')    
                                <h3 style="color:Tomato;">Non admis</h3>
                            @endif        
                        
                        </td>
                        <td>{{$inscription?->salle?->centre?->nomCentre}} {{$inscription?->salle?->centre?->emplacementCentre}}</td>
                        <td>{{$inscription?->salle?->numSalle}}</td>
                        <td>{{$inscription?->numeroUniqueConvocation}}</td>
                        <td>{{$inscription->created_at}}</td>
                        <td> <h3 > <a href="{{ route('client.obtenirConvocation', ['idInscription' =>$inscription->id ]) }}" style="text-decoration: underline">Convocation</a> </h3> </td>
                        <td> <a href="{{route('client.downloadLePDF', ['idInscription'=>$inscription->id])}}" class="btn btn-primary">Télécharger</a></td>
                        {{-- <td> <button class="btn btn-secondary">Modifier</button> </td>
                        <td> <button class=" btn-supprimer btn btn-danger">Supprimer</button> </td> --}}
                    </tr>
                @empty
                    Pas encore d'inscription
                @endforelse
                
            </tbody>
            </table>
        </div>
        {{-- fin table --}}
        
    

    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
    
</body>
</html>