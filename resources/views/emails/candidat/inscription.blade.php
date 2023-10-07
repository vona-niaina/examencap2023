<x-mail::message>
# Inscription refusée 

Vos dossiers ne sont pas authentiques.

{{-- <x-mail::button :url="''">
Votre profil
</x-mail::button> --}}
{{-- <a href="{{route('profile.edit')}}">Voir votre profil</a>  --}}
{{-- <a href="{{ route('client.mesInscriptionsClient') }}">Voir vos inscriptions</a> --}}
@component('mail::button', ['url'=>'http://localhost:8000/profile'])
    Voir profil
@endcomponent

Merci,<br>
DREN Amoron'i mania
{{-- {{ config('app.name') }} --}}
</x-mail::message>
