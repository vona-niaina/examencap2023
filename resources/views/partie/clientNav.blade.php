 <!-- Load an icon library -->
 {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}

 {{-- <div class="navbar">
   <a class="active" href="#"><i class="fa fa-fw fa-home"></i> Homez</a>
   <a href="#"><i class="fa fa-fw fa-search"></i> Search</a>
   <a href="#"><i class="fa fa-fw fa-envelope"></i> Contact</a>
   <a href="#"><i class="fa fa-fw fa-user"></i> Login</a>
 </div>  --}}

 <div class="topnav fixed-top" id="myTopnav" >
    <a href="{{route('client.index')}}" class="active"> <i class="fa fa-fw fa-home"></i> Examens</a>
    {{-- <a href="#"><i class="fa fa-fw fa-home"></i>Examens</a> --}}
    <a href="{{route('client.mesInscriptionsClient')}}"><i class="fa fa-fw fa-home"></i>Mes Inscriptions</a>
    
    {{-- <a href="#"><i class="fa fa-fw fa-home"></i>Projection</a>
    <a href="#"><i class="fa fa-fw fa-home"></i>Client</a> --}}
    <a href="/profile"><i class="fa fa-fw fa-envelope"></i>Mon Profil</a>
    {{-- <h3 style="color: aliceblue; position: relative;" >{{Auth::user()->name}}</h3> --}}
    <div class="topnav-right">
          
        <form class="formLogOut" method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Déconnexion') }}
            </x-dropdown-link>
        </form>
     
    </div>
   
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
</div> 