
<div class="control-group">
    <label for="name" class="control-label "></label>
    <div class="controls ">

            <select name='delegue' class='span8'>
                <option></option>
                @foreach ($delegues as $delegue)
                    <option value="{{ $delegue->id }}" {{ isset($limite) ? ($limite->user_id == $delegue->id ? 'selected' : ''):'' }}>
                        {{ $delegue->firstname .'  '.$delegue->lastname }}  </option>
                @endforeach
            </select>
       
        @error('delegue')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label for="nbPrive" class="control-label ">Nombre Visite Privié</label>
    <div class="controls ">
        <input type="number" class="span8 form-control @error('nbPrive') is-invalid @enderror" name="nbPrive" id="nbPrive"
           value="{{ old('nbPrive', $limite->visite_prive ?? null) }}">
        @error('nbPrive')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label for="nbPublic" class="control-label ">Nombre Visite Public</label>
    <div class="controls ">
        <input type="number" class="span8 form-control @error('nbPublic') is-invalid @enderror" name="nbPublic" id="nbPublic"
           value="{{ old('nbPublic', $limite->visite_public ?? null) }}">
        @error('nbPublic')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
