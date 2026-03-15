<x-layout>


    <x-mastehead title='Login' />

    <x-display-errors/>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-6">
                <form class="rounded-4 bg-dark text-light p-4 shadow" action="{{ route('login') }}" method="POST">
                    {{-- impostare la action="{{route('regiser')}}" e il method="POST" --}}
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Registrati</button>
                </form>
            </div>
        </div>
    </div>

</x-layout>
