<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>télécharger convocation candidat</title>
        <link rel="stylesheet" href="/bootstr/cssBootstr/bootstrap.min.css">
        <link rel="stylesheet" href="/css/clientCss/clientNav.css">
        <link rel="stylesheet" href="/css/clientCss/clientConvocation.css">
        <style>
            .fiandohany{
                position: relative;
                margin-top: 0;
                margin-bottom: 10%;
                width: 100%;
                /* left: 20%; */
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
                margin-right: 5%;
                margin-bottom: 15%;
            }
            
            .vatany{
                margin: 2%;
                margin-top: 20%;
                width: 100%;
            }

            .zap{
                margin-left: 5%
            }

            .etoile{
                margin-left: 25%;
            }
            
            .fiandohany h2, .fiandohanyHavia h4, .fiandohanyHavanana h4, .etoile{
                text-align: center;
            }

            .fiafarany{
                /* display: flex; */
                width: 100%;
                /* justify-content:space-around ;
                align-items: flex-start; */
                margin-bottom: 4%;
            }
            
            .sonia1{
                float: right;
                margin-right: 5%;
            }

            .qrCodeConvoc{
                float: left;
                width: 50%;
                /* border: 2px blue solid; */
                margin-left: 7%;
                margin-right: 2%
            }

        </style>

        <script src="/bootstr/jsBootstr/jquery-3.6.0.min.js')}}"></script>
</head>
<body>
    
    <div class="fizarana2">
        {{-- @foreach ($inscriptions as $inscription)   --}}
            {{-- @dd($inscription)   --}}
            {{-- <div class="logo">
                <img src="" alt="">
            </div> --}}

            <div class="fiandohany">
                <h2>REPOBLIKAN'I MADAGASIKARA</h2>
                <h2>Fitiavana-Tanindrazan-Fandrosoana</h2>
            </div>

            <div class="fiandohany2">
                <div class="fiandohanyHavia">
                    <h4>MINISTERE DE L'EDUCATION NATIONALE</h4>
                    <span class="etoile">**************************</span>
                    <h4>SECRETARIAT GENERAL</h4>
                    <span class="etoile">**************************</span>
                    <h4>DIRECTION REGIONALE DE L'EDUCATION NATIONALE</h4>
                    <h4>AMORON'I MANIA</h4>
                </div>
    
                <div class="fiandohanyHavanana">
                    <h4>CONVOCATION A L'EXAMEN DU CAP</h4>
                  
                    <p>Session du {{$inscription->examen->debutExamen}}  à  {{$inscription->examen->finExamen}}   </p>
                    <p>Centre d'examen:{{$inscription->salle->centre->nomCentre}}</p> 
    
                    <p>N° d'inscription: {{$inscription->numeroUniqueConvocation}} </p>
                </div>
            </div>
            

            <div class="vatany">
                <h4>NOM ET PRENOM: {{$inscription->user->name}} {{$inscription->user->prenom}}</h4>
                <h4>Né(e) le: {{$inscription->user->dateNaissance}} </h4>
                <h4>ETABLISSEMENT: {{$inscription->user->etab->nomEtab}}  <span class="zap"> ZAP: {{$inscription->user->etab->zap->nomZap}}  </span> </h4>
                <h4>CISCO: {{$inscription->user->etab->zap->cisco->nomCisco}}  </h4> 
                
                <div class="redactions">
                    <p>
                        J'ai l'honneur de vous faire savoir que vous êtes convoqué(e) à passer les épreuves {{$inscription->examen->typeExamen}} du CAP,
                        session du {{$inscription->examen->debutExamen}}  au  {{$inscription->examen->finExamen}}  à {{$inscription->salle->centre->nomCentre}}  {{$inscription->salle->centre->emplacementCentre}}  |  SALLE : {{$inscription->salle->numSalle}} 
                    </p>
                    <p>
                        Vous êtes prié(e) de vous présenter à votre centre d'examen muni(e) de la présente convocation ainsi
                        que de votre carte d'identité nationale. L'appel des candidats se fera à 7h30min.
                    </p>
                </div>

                <div class="fiafarany">
                    <div class="qrCodeConvoc">
                        {{-- <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(120)->generate('filaminanabe')) }}" alt=""> --}}
                        <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="Code Qr du candidat">
                    </div>
    
                    <div class="sonia1">
                        <p>Fait à Ambositra * * </p>
                    <p>Le Vice-Président de l'Organisation Générale</p>
                    
                    <p>RAHERIMANDIMBY Andry Tahiriniaina</p>
                    </div>
                </div>

                
            </div>
        {{-- @endforeach --}}


    </div>  
        
    

    <script src="/bootstr/jsBootstr/bootstrap.min.js"></script>
    
</body>
</html>