

<div class="control-group">
    <label for="name" class="control-label ">{{__('Name')}}</label>
    <div class="controls ">
        <input type="text" name="name" id="name" class="span8 form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name ?? null) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>