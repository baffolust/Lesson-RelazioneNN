<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
        <a class="nav-link" href="{{route('product.index')}}">Prodotti</a>
        <a class="nav-link" href="{{route('article.index')}}">Articoli</a>
        @auth
          
        <a class="nav-link" href="{{route('product.create')}}">Inserisci Prodotto</a>
        <a class="nav-link" href="{{route('article.create')}}">Inserisci Articolo</a>
        @endauth
        
        @if (Auth::user())
        {{-- 
        Auth::user() è un metodo della classe Auth che restituisce i valori dell'utente. Ritorna NULL se si è loggati 
        Con questo controllo si attivano e disattivano i tasti registrati, login e logout in base alla sessione
        --}}
        @endif

        @guest
        {{-- codice che viene eseguito solo se l'utente NON è Autenticato --}}
        <a class="nav-link" href="{{route('register')}}">Registrati</a>
        <a class="nav-link" href="{{route('login')}}">Login</a>
        @endguest
        
        @auth
        {{-- codice che viene eseguito solo se l'utente è Autenticato --}}
        <form action="{{route('logout')}}" method="POST">
          @csrf
          <button class="nav-link" type="submit">Logout</button>
        </form>
        <a class="nav-link" href="#">Benvenuto {{Auth::user()->name}}</a>    
        @endauth

        {{-- 
        - Modifica del tag in <form> per supportare il metodo POST 
        - Per poter cliccare devo aggiungere un bottone di tipo submit
        - class="nav-link" è spostata dal form al button per omologare lo stile
          --}}
      </div>
    </div>
  </div>
</nav>