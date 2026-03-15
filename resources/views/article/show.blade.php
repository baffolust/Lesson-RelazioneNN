<x-layout>

     <x-mastehead title='Articolo {{$article->title}}' />


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 mt-2">
                <x-cardArticle :article="$article"/>
                {{-- con la sintassi :product indico che sto passando come parametro un oggetto o un array --}}
            </div>
        </div>
    </div>

</x-layout>
