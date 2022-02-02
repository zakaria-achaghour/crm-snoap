<div class="control-group">
    <label for="firstname" class="control-label ">Désignation</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('designation') is-invalid @enderror" name="designation" id="designation"
        value="{{ old('designation', $category->designation ?? null) }}">
        @error('designation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>