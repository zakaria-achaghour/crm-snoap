

<div class="control-group">
    <label for="firstname" class="control-label ">{{ __('Name') }}</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('nom') is-invalid @enderror" name="nom" id="nom"
            placeholder="{{ __('Name') }}" value="{{ old('nom', $region->nom ?? null) }}">
        @error('nom')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
