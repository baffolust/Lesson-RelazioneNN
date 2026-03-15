<div class="col-6 col-md-4 mb-3">
    <div class="form-check">
        <input class="form-check-input" name="tags[]" type="checkbox" value="{{$tag->id}}" id="{{$tag->name}}">
        {{-- 
        Con il nome tags[], la request interpreta che il tipo di dato è un array
        Associo value= tag->id per identificare univocamente il checkbox che viene checkato dall'utente 
        --}}

        <label class="form-check-label" for="{{$tag->name}}"> {{$tag->name }} </label>
    </div>
</div>
