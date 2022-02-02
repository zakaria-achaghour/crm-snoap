<div class="control-group">
    <label for="designation" class="control-label ">Désignation</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('designation') is-invalid @enderror" name="designation" id="designation"
            placeholder="Désignation" value="{{ old('designation', $dci->designation ?? null) }}">
        @error('designation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="classes">Classe</label>
    <div class="controls">
      <select  class="form-control span8 @error('classe') is-invalid @enderror" id="classe" name="classe">
        <option></option>
        @foreach ($classes as $classe)
         <option value="{{ $classe->id }}"{{ isset($dci) ? ($dci->classe_id==$classe->id ? 'selected' :'' ): '' }} >{{ $classe->designation }}</option>
       
        @endforeach
      </select>
      <!------- error message --------->
      @error('classes')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror
  <!------- fin error message --------->
    </div>
  </div>

