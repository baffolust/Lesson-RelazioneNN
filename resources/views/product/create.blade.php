<x-layout>


     <x-mastehead title='Inserisci Prodotto' />

    <x-display-message/>

    <x-display-errors/>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">


                <form class="rounded-4 bg-dark text-light p-4 shadow" action="{{ route('product.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Prodotto</label>
                        <input name="name" value="{{ old('name') }}" type="text" class="form-control"
                            id="name">
                        {{-- con value={{old('name')}} indichiamo di mantenere l'ultimo valore del campo --}}
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione prodotto</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ old('description') }}</textarea>
                        {{-- textarea non ha un valore di default per value e si mette all'interno dei tag --}}
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prezzo</label>
                        <div class="d-flex">
                            <input name="price" value="{{ old('price') }}" type="text" class="form-control"
                                id="price">
                            <span> € </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Inserisci immagine</label>
                        <input name="img" type="file" class="form-control" id="img">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>

</x-layout>
