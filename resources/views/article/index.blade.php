<x-layout>

     <x-mastehead title='Tutti gli articoli' />

    <x-display-message/>

    <div class="container">
        <div class="row justify-content-center">
            @foreach ($articles as $article )
            <div class="col-12 col-md-4 mt-2">
                <x-cardArticle :article="$article"/>
                {{-- con la sintassi :product indico che sto passando come parametro un oggetto o un array --}}
            </div>
            @endforeach
        </div>
    </div>

</x-layout>
