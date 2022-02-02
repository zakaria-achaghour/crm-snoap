<div class="control-group">
    <label for="firstname" class="control-label ">{{ __('Name') }}</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('nom') is-invalid @enderror" name="nom" id="nom"
            placeholder="{{ __('Name') }}" value="{{ old('nom', $ville->nom ?? null) }}">
        @error('nom')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
    <div class="control-group">
    <label for="name" class="control-label ">{{ __('Region') }}</label>
    <div class="controls ">

            <select name='region' class='span8'>
                <option></option>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}" {{ isset($ville) ? ($ville->region->id == $region->id ? 'selected' : ''):'' }}>
                        {{ $region->nom }} </option>
                @endforeach
            </select>
       
        @error('region')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
