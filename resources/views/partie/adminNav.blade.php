<!-- Load an icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- The sidebar -->
<div class="sidenav">
  <a href="{{route('admi')}}"><i class="fa fa-fw fa-home"><img src="/mesImages/home_24px.png" alt="" style="width:22px;"></i> Home</a>
  
  {{-- <a href="#clients"><i class="fa fa-fw fa-user"></i> Candidat</a> --}}
  <a href="{{route('admin.examen')}}"><i class="fa fa-fw fa-user"></i> Examen</a>
  <a href="{{route('admin.centre')}}"><i class="fa fa-fw fa-user"></i> Centre</a>
  {{-- <a href="#clients"><i class="fa fa-fw fa-user"></i> Salle</a> --}}
  {{-- <a href="#clients"><i class="fa fa-fw fa-user"></i> Inscriptions</a> --}}
  
  <a href="{{route('admin.cisco')}}"><i class="fa fa-fw fa-user"></i> CISCO</a>
  <a href="{{route('admin.zap')}}"><i class="fa fa-fw fa-user"></i> ZAP</a>
  <a href="{{route('admin.etab')}}"><i class="fa fa-fw fa-wrench"></i> ETAB</a>
 
  
 
  <button class="dropdown-btn">Moi
    <i class="fa fa-caret-down"><img style="width:30px;" src="/mesImages/iDropdown.png" alt="ic"></i>
  </button>
  <div class="dropdown-container">
    <a href="/profile"><i class="fa fa-fw fa-envelope"></i>Mon Profil</a>
    <div >
    <form method="POST" action="{{ route('logout') }}" class="deconnexion-nav">
      @csrf

      <x-dropdown-link :href="route('logout')"
        onclick="event.preventDefault();
        this.closest('form').submit();">
        {{ __('Déconnexion') }}
      </x-dropdown-link>
    </form>
  </div>
   
  </div>
  
  
  
</div> 