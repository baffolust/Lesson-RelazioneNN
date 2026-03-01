<x-layout>


    <header class="container-fluid">
        <div class="row justify-content-center bg-warning">
            <div class="col-12 text-center">
                <h1> MODIFICA ARTICOLO {{$article->title}} </h1>
            </div>
        </div>

    </header>

    <x-display-message/>

    <x-display-errors/>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">


                <form class="rounded-4 bg-dark text-light p-4 shadow" action="{{ route('article.update', compact('article')) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT') {{-- spoofing del metodo POST.  --}}
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Titolo dell'articolo</label>
                        <input name="title" value="{{ $article->title }}" type="text" class="form-control"
                            id="title">
                    </div>
                    {{-- con value={{old('title')}} indichiamo di mantenere l'ultimo valore del campo --}}

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Sottotitolo dell'articolo</label>
                        <input name="subtitle" value="{{ $article->subtitle }}" type="text" class="form-control"
                            id="subtitle">
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label">Corpo dell'articolo</label>
                        <textarea name="body" id="body" class="form-control" cols="30" rows="10">{{ $article->body }}</textarea>
                        {{-- textarea non ha un valore di default per value e si mette all'interno dei tag --}}
                    </div>
                    <div class="mb-3">
                        <span  class="form-label">Immagine attuale</span>
                        <img src="{{Storage::url($article->img)}}" class="card-img-top" alt="Immagine di {{$article->title}}" srcset="">
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Inserisci nuovam immagine</label>
                        <input name="img" type="file" class="form-control" id="img">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>

</x-layout>
