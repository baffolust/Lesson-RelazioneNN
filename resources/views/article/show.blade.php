<x-layout>

    <header class="container-fluid">
        <div class="row justify-content-center bg-warning">
            <div class="col-12 text-center">
                <h1> Articolo {{$article->title}} </h1>
            </div>
        </div>

    </header>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 mt-2">
                <x-cardArticle :article="$article"/>
                {{-- con la sintassi :product indico che sto passando come parametro un oggetto o un array --}}
            </div>
        </div>
    </div>

</x-layout>
