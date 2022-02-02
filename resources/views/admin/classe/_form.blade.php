<div class="control-group">
    <label for="firstname" class="control-label ">Désignation</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('designation') is-invalid @enderror" name="designation" id="designation"
            placeholder="Désignation" value="{{ old('designation', $classe->designation ?? null) }}">
        @error('designation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="control-group">
    <label for="type" class="control-label ">Type</label>
    <div class="controls ">
        <select  class="form-control span8 @error('type') is-invalid @enderror" id="type" name="type">
            <option></option>
        
            @foreach ($types as $type)
             <option value="{{ $type }}" {{ isset($classe) ? ($classe->type==$type ? 'selected' :'' ): '' }} >{{ $type }}</option>
           
            @endforeach
          </select>
        @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

  

