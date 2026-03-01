<div class="card" style="width: 18rem;">
    <img src="{{Storage::url($product->img)}}" class="card-img-top" alt="...">
    {{-- 
    la card adesso ha ricevuto come parametro l'oggetto $product. Indico il percorso salvato nell'attributo img 
    Nella card va utilizzata il metodo statico Storage::url() che ricostruisce il percorso della file nella cartella storage locale
    --}}
    <div class="card-body">
        <h5 class="card-title">{{$product->name}}</h5>
        <p class="card-text">{{$product->description}}</p>
        <p class="card-text">Creato da: {{$product->user->name}}</p>
        {{-- TRAVERSAL MODEL --}}
        <p class="card-text">{{$product->price}} €</p>
    </div>
</div>
