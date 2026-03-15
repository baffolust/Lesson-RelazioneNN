<x-layout>

     <x-mastehead title='I miei prodotti' />


    <div class="container">
        <div class="row justify-content-center">
            @foreach ($products as $product )
            <div class="col-12 col-md-4">
                <x-cardProduct :product="$product"/>
                {{-- con la sintassi :product indico che sto passando come parametro un oggetto o un array --}}
            </div>
            @endforeach
        </div>
    </div>

</x-layout>
