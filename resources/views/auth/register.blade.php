<x-layout>


    <header class="container-fluid">
        <div class="row justify-content-center bg-warning">
            <div class="col-12 text-center">
                <h1> Registrati </h1>
            </div>
        </div>

    </header>

    <x-display-errors/>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-6">
                <form class="rounded-4 bg-dark text-light p-4 shadow" action="{{route('register')}}" method="POST">
                    {{-- impostare la action="{{route('regiser')}}" e il method="POST" --}}
                    @csrf

                    {{-- creare i 4 input attesi dalla request di register --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Conferma Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary">Registrati</button>
                </form>
            </div>
        </div>
    </div>

</x-layout>
