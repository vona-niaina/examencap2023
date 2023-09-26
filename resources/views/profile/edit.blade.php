<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            @if ($user->diplomeBacc != null)
                <div>
                    <x-input-label for="dateObtentionBacc" :value="__('dateObtentionBacc')" />
                    <x-text-input id="dateObtentionBacc" name="dateObtentionBacc" type="text" class="mt-1 block w-full" :value="old('dateObtentionBacc', $user->dateObtentionBacc)" autofocus autocomplete="dateObtentionBacc" />
                    <x-input-error class="mt-2" :messages="$errors->get('dateObtentionBacc')" />
                </div>

                <div class="p-2 sm:p-5 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Diplôme bacc') }}
                            </h2>
                        </header>
                        <img src="{{ Storage::url($user->diplomeBacc) }}" alt="diplomeBacc">
                    </div>
                </div>
            @else
               <h1> Pas de diplomeBacc </h1>
            @endif

            @if ($user->diplomeCAE != null)
                <div class="space-y-1 " >
                    <x-input-label for="dateObtentionCAE" :value="__('Date Obtention de CAE')" />
                    <x-text-input id="dateObtentionCAE" name="dateObtentionCAE" type="text" class="mt-1 block" :value="old('dateObtentionCAE', $user->dateObtentionCAE)" autofocus autocomplete="dateObtentionCAE" />
                    <x-input-error class="mt-2" :messages="$errors->get('dateObtentionCAE')" />
                </div>
                <div class="p-2 sm:p-5 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Diplôme CAE') }}
                            </h2>
                        </header>
                        <img src="{{ Storage::url($user->diplomeCAE) }}" alt="diplomeCAE">
                    </div>
                </div>
            @else
               <h1> Pas de diplomeCAE </h1>
            @endif
           
            @if ($user->certificatAdministratif != null)
                <div class="space-y-1 " >
                    <x-input-label for="dateDePriseDeService" :value="__('Date de Prise de Service')" />
                    <x-text-input id="dateDePriseDeService" name="dateDePriseDeService" type="text" class="mt-1 block" :value="old('dateDePriseDeService', $user->dateDePriseDeService)" autofocus autocomplete="dateDePriseDeService" />
                    <x-input-error class="mt-2" :messages="$errors->get('dateDePriseDeService')" />
                </div>

                <div class="p-2 sm:p-5 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('certificatAdministratif') }}
                            </h2>
                        </header>
                        <img src="{{ Storage::url($user->certificatAdministratif) }}" alt="certificatAdministratif">
                    </div>
                </div>
            @else
            <h1> Pas de certificatAdministratif </h1>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
