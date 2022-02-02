<div class="control-group">
    <label for="designation" class="control-label ">Désignation</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('designation') is-invalid @enderror" name="designation" id="designation"
             value="{{ old('designation', $grossiste->designation ?? null) }}">
        @error('designation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
    <div class="control-group">
    <label for="ville" class="control-label ">Ville</label>
    <div class="controls ">

            <select name='ville' class='span8'>
                <option></option>
                @foreach ($villes as $ville)
                    <option value="{{ $ville->id }}" {{ isset($grossiste) ? ($grossiste->ville->id == $ville->id ? 'selected' : ''):'' }}>
                        {{ $ville->nom }} </option>
                @endforeach
            </select>
       
        @error('ville')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
