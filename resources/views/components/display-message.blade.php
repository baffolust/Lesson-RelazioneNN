{{-- snippet che inserisce un messaggio di successo --}}

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif