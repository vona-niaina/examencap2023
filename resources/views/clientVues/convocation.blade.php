<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Cli</title>
    <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
    <link rel="stylesheet" href="/css/clientCss/clientNav.css">
    <link rel="stylesheet" href="/css/clientCss/clientConvocation.css">

    <style>
        .fiandohany{
            position: relative;
            margin-top: 7%;
            margin-bottom: 2%;
            width: 50%;
            left: 20%;
        }

        .fiandohany2{
            /* display: flex; */
            width: 100%;
            /* justify-content:space-around ;
            align-items: flex-start; */
            margin-bottom: 4%;
        }

        .fiandohanyHavia{
            float: left;
            width: 50%;
            /* border: 2px blue solid; */
            margin-left: 7%;
            margin-right: 2%
        }

        .fiandohanyHavanana{
            float: right;
            width: 35%;
            /* border: 2px green dotted; */
            margin-right: 2%;
            margin-bottom: 15%
        }
        
        .vatany{
            margin: 2%;
            margin-top: 8%;
            width: 100%;
        }

        .zap{
            margin-left: 5%
        }

        .sonia1{
            float: right;
            margin-right: 5%;
        }

        .etoile{
            margin-left: 25%;
        }

        .fiandohany h3, .fiandohanyHavia h3, .fiandohanyHavanana h3{
            text-align: center;
        }
    </style>

    <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js"></script>
    

        
</head>
<body>
    <div class="fizarana1">
        @include('partie.clientNav') 
    </div>

    <div class="fizarana2">
        {{-- @foreach ($inscriptions as $inscription)   --}}
            {{-- @dd($inscription)   --}}
            <div class="fiandohany">
                <h3>REPOBLIKAN'I MADAGASIKARA</h3>
                <h3>Fitiavana-Tanindrazan-Fandrosoana</h3>
            </div>

            <div class="fiandohany2">
                <div class="fiandohanyHavia">
                    <h3 class="text">MINISTERE DE L'EDUCATION NATIONALE</h3>
                    <span class="etoile">**************************</span>
                    <h3>SECRETARIAT GENERAL</h3>
                    <span class="etoile">**************************</span>
                    <h4>DIRECTION REGIONALE DE L'EDUCATION NATIONALE</h4>
                    <h3>AMORON'I MANIA</h3>
                </div>
    
                <div class="fiandohanyHavanana">
                    <h3>CONVOCATION A L'EXAMEN DU CAP</h3>
                  
                    <p>Session du {{$inscription->examen->debutExamen}}  à  {{$inscription->examen->finExamen}}   </p>
                    <p>Centre d'examen:{{$inscription->salle->centre->nomCentre}} à {{$inscription->salle->centre->emplacementCentre}}</p> 
    
                    <p>N° d'inscription: {{$inscription->numeroUniqueConvocation}} </p>
                </div>
            </div>
            

            <div class="vatany">
                <h3>NOM ET PRENOM: {{$inscription->user->name}} {{$inscription->user->prenom}} </h3>
                <h3>Né(e) le: {{$inscription->user->dateNaissance}} </h3>
                <h3>ETABLISSEMENT: {{$inscription->user->etab->nomEtab}} <span class="zap"> ZAP: {{$inscription->user->etab->zap->nomZap}}  </span>  </h3>
                <h3>CISCO: {{$inscription->user->etab->zap->cisco->nomCisco}}  </h3> 
                
                <div class="redactions">
                    <p>
                        J'ai l'honneur de vous faire savoir que vous êtes convoqué(e) à passer les épreuves {{$inscription->examen->typeExamen}} du CAP,
                        session du {{$inscription->examen->debutExamen}}  au  {{$inscription->examen->finExamen}}  à {{$inscription->salle->centre->nomCentre}}      SALLE : {{$inscription->salle->numSalle}} 
                    </p>
                    <p>
                        Vous êtes prié(e) de vous présenter à votre centre d'examen muni(e) de la présente convocation ainsi
                        que de votre carte d'identité nationale. L'appel des candidats se fera à 7h30min.
                    </p>
                </div>

                <div class="sonia1">
                    <p>Fait à Ambositra * * </p>
                <p>Le Vice-Président de l'Organisation Générale</p>
                
                <p>RAHERIMANDIMBY Andry Tahiriniaina</p>
                </div>

                
            </div>
        {{-- @endforeach --}}

        <a href="{{route('client.downloadLePDF', ['idInscription'=>$inscription->id])}}" class="btn btn-primary">Télécharger</a>
       

    </div>  
        
    

    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
    
</body>
</html>