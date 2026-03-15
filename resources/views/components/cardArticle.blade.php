<div class="card" style="width: 18rem;">
    <img src="{{ Storage::url($article->img) }}" class="card-img-top" alt="...">
    {{-- 
    la card adesso ha ricevuto come parametro l'oggetto $article. Indico il percorso salvato nell'attributo img 
    Nella card va utilizzata il metodo statico Storage::url() che ricostruisce il percorso della file nella cartella storage locale
    --}}
    <div class="card-body">
        <h5 class="card-title">{{ $article->title }}</h5>
        <h6 class="card-subtitle">{{ $article->subtitle }}</h6>
        <p class="card-text">{{ $article->body }}</p>
        @if ($article->tags->isNotEmpty()) {{-- metodo che restituisce true se tags ha almeno un elemento, altrimenti restituisce false --}}
            @foreach ($article->tags as $tag)
                <span class="badge text-bg-dark my-2">#{{ $tag->name }}</span>
            @endforeach
        @endif
        <a href="{{ route('article.show', compact('article')) }}" class="btn btn-primary d-block">Vedi articolo</a>
        {{-- 
        Laravel permette di passare l'intero oggetto article, ricavandone solo l'id
        Solitamente si passa il parametro con la sintassi ['id' => $article->id]
        --}}
        @auth

            <a href="{{ route('article.edit', compact('article')) }}" class="btn btn-warning">Modifica articolo</a>
            <form action="{{ route('article.destroy', compact('article')) }}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger" type="submit">Elimina articolo</button>
            </form>
        @endauth
    </div>
</div>
