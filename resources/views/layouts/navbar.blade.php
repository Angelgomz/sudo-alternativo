<nav class="nav navbar navbar-expand-lg navbar-light bg-light">
   <a class="navbar-brand" href="#">Sudo Calendar </a>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
   </button>
   <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
         <li class="nav-item active pl-1 ">
            <a class="" aria-current="page" href="#">Home</a>
         </li>
         @if(Auth::id())
            <li class="nav-item pl-1">
                     <a>
                     Hola, {{ session()->get('email') }}
                     </a>
               </li>         
               <li class="nav-item pl-1">
                     <a href="/sudo-alt/public/logout">Cerrar Sesion</a>
               
               </li>
         @endif
     </ul>
   </div>
</nav>