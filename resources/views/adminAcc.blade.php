<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pageAdmin</title>
        <link rel="stylesheet" href="bootstr/cssBootstr/bootstrap.min.css">
        <link rel="stylesheet" href="css/adminCss/adminIndex.css">
        <link rel="stylesheet" href="css/adminCss/adminNav.css">
        <script src="bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
       
</head>
<body>
    <div class="fizarana">
        <div class="fizarana1">
            @include('partie.adminNav') 
        </div>
        
        <div class="fizarana2">
            <h1 class="welcome-admin">Statistique</h1>

            {{-- simple statistique --}}
            <div class="simpleStatistique">
                <div class="inscriptionTotal nombreStat card">
                    <h4>Inscriptions</h4>
                    <h2>{{ $inscriptionTotal }} </h2>
                </div>

                <div class="nombreUsersAvecInscriptions nombreStat">
                    <h4>Enseignants Inscrits</h4>
                    <h2>{{ $nombreUsersAvecInscriptions }}</h2> 
                </div>

                <div class="nombreUsersSansInscriptions nombreStat">
                    <h4>Enseignants non inscrits</h4>
                    <h2>{{ $nombreUsersSansInscriptions }}</h2> 
                </div>

                <div class="nombreUsersAdmisDefinitif nombreStat">
                    <h4>Admis définitives</h4>
                <h2>{{ $nombreUsersAdmisDefinitif }}</h2>
                </div>
            </div>
            

            <div class="chartStat">
                {{-- chart pourcentageAdmis définitive --}}
                <div class="poucentageParCisco card" >
                    <h2>% Admis définitives par CISCO</h2>
                    <canvas id="ciscoChart" data-cisco-data="{{ json_encode($data) }}" aria-label="chart" role="img"></canvas>

                </div>

                {{-- chart pie ecrit pratique --}}
                <div class="ecritPratique card" >
                    <h4>% de réussite d'Ecrit et Pratique</h4>
                    <h1 id="pourcentageReussiteEcrit" style="display: none">{{$pourcentageReussiteEcrit}}</h1>
                    <h1 id="pourcentageReussitePratique" style="display: none">{{$pourcentageReussitePratique}}</h1>
                    <canvas id="pieCanvas" aria-label="chart" role="img"></canvas>

                </div>   
            </div>
             

            
        </div>
    </div>
  
    
    <script src="bootstr/jsBootstr/chart.min.js"></script>
    <script src="js/adminJs/adminNav.js"></script>
    <script src="js/adminJs/chartIndex.js"></script>
    <script src="bootstr/jsBootstr/bootstrap.min.js"></script>
</body>
</html>