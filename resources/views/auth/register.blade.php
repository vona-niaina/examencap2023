<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" onchange="javascript:this.value=this.value.toUpperCase();" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- prenom -->
        <div>
            <x-input-label for="prenom" :value="__('Prénom')" />
            <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="prenom" />
            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
        </div>

        {{-- date de naissance --}}
        <div>
            <x-input-label for="dateNaissance" :value="__('Date de Naissance')" />
            <x-text-input id="dateNaissance" class="block mt-1 w-full" type="date" name="dateNaissance" :value="old('dateNaissance')" required autofocus autocomplete="dateNaissance" />
            <x-input-error :messages="$errors->get('dateNaissance')" class="mt-2" />
        </div>

         <!-- cin -->
         <div>
            <x-input-label for="cinEnseignant" :value="__('CIN')" />
            <x-text-input id="cinEnseignant" class="block mt-1 w-full" type="text" name="cinEnseignant" :value="old('cinEnseignant')" required autofocus autocomplete="cinEnseignant" />
            <x-input-error :messages="$errors->get('cinEnseignant')" class="mt-2" />
        </div>

        {{-- Photo d'identité --}}
        <div>
            <x-input-label for="photoIdentite" :value="__('Photo d\'Identité ')" />
            <x-text-input id="photoIdentite" class="block mt-1 w-full" type="file" name="photoIdentite" :value="old('photoIdentite')" autofocus autocomplete="certificatAdministratif" />
            <x-input-error :messages="$errors->get('photoIdentite')" class="mt-2" />
        </div>

        {{-- Etablissement --}}
        <div class="mt-4">
            <x-input-label for="etab_id" :value="__('Etablissement')" />
            <select name="etab_id" id="etab_id" class="block- w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @forelse ($etabs as $etab)
                    <option value="{{$etab->id}}" @selected(old('etab_id') == $etab->id) > {{$etab->nomEtab}} </option>
                @empty
                    Pas encore d'établissement disponible
                @endforelse
            </select>
           
            {{-- <x-input-select name="etab_id" id="eta_id" />
            @forelse ($etabs as $etab)
                <option value="{{$etab->id}}" > {{$etab->nomEtab}} </option>
            @empty
                Pas encore d'établissement disponible
            @endforelse --}}
            <x-input-error :messages="$errors->get('etab_id')" class="mt-2" />
        </div>
        {{-- <div class="form-group">
            <br> <label for="zap_id">Son ZAP:</label>
             <select name="zap_id" class="custom-select ">
                 @forelse ($zaps as $zap)
                     <option value="{{$zap->id}}">{{$zap->nomZap}}</option>
                 @empty
                     <h2>Pas encore de ZAP dispo, Veuillez d'abord en rajouter</h2>
                 @endforelse
             </select>
        </div> --}}

        <!-- CAE dateObtention  diplome  et fileUploads  pattern="\d{2}/\d{2}/\d{4}|" --> 
        <div class="row">
            <div class="col">
                <x-input-label for="dateObtentionCAE" :value="__('date Obtention de CAE')" />
                <x-text-input id="dateObtentionCAE" class="block mt-1 w-full" type="date" name="dateObtentionCAE" :value="old('dateObtentionCAE',null)" autofocus autocomplete="dateObtentionCAE" />
                <x-input-error :messages="$errors->get('dateObtentionCAE')" class="mt-2" />
            </div>         

            <div class="col">        
                <x-input-label for="diplomeCAE" :value="__('Image de diplôme CAE')" />
                <x-text-input id="diplomeCAE" class="block mt-1 w-full" type="file" name="diplomeCAE" :value="old('diplomeCAE')" autofocus autocomplete="diplomeCAE" />
                <x-input-error :messages="$errors->get('diplomeCAE')" class="mt-2" />
            </div>
        </div>
        <!-- bacc date Obtention  et fileUpload  diplome -->
        <div class="row">
            <div class="col">
                <x-input-label for="dateObtentionBacc" :value="__('date Obtention du BACC')" />
                <x-text-input id="dateObtentionBacc" class=" col " type="date" name="dateObtentionBacc" :value="old('dateObtentionBacc')" autofocus autocomplete="dateObtentionBacc"/>
                <x-input-error :messages="$errors->get('dateObtentionBacc')" class="mt-2" />
            </div>   

            <div class="col">
                <x-input-label for="diplomeBacc" :value="__('diplomeBacc')" />
                <x-text-input id="diplomeBacc" class="col" type="file" name="diplomeBacc" :value="old('diplomeBacc')" autofocus autocomplete="diplomeBacc" />
                <x-input-error :messages="$errors->get('diplomeBacc')" class="mt-2" />
            </div>
        </div>

        <!-- certificatAdministratif fileUploads et date prise de service-->
        <div>
            <x-input-label for="dateDePriseDeService" :value="__('Date prise de service')" />
            <x-text-input id="dateDePriseDeService" class=" col " type="date" name="dateDePriseDeService" :value="old('dateDePriseDeService')" autofocus autocomplete="dateDePriseDeService" />
            <x-input-error :messages="$errors->get('dateDePriseDeService')" class="mt-2" />

            <x-input-label for="certificatAdministratif" :value="__('Certificat Administratif')" />
            <x-text-input id="certificatAdministratif" class="block mt-1 w-full" type="file" name="certificatAdministratif" :value="old('certificatAdministratif')" autofocus autocomplete="certificatAdministratif" />
            <x-input-error :messages="$errors->get('certificatAdministratif')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de Passe')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer Mot de Passe')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
