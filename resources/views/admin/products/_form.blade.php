<div class="control-group">
    <label for="sage" class="control-label">{{ __('Code Sage') }}</label>
    <div class="controls">
        <input type="text" class="form-control span8 @error('sage') is-invalid @enderror"
        name="sage" id="sage" placeholder="Code sage"  value="{{ old('sage', $product->code_sage ?? null) }}">
        <!------- error message --------->
        @error('sage')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
        <!------- fin error message --------->
    </div>
</div>

<div class="control-group">
    <label for="designation" class="control-label ">Désignation</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('designation') is-invalid @enderror" name="designation" id="designation"
             value="{{ old('designation', $product->designation ?? null) }}">
        @error('designation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label class="control-label">{{ __('Status') }}</label>
    <div class="controls">
        <label>
            <input type="radio" value="1" name="statut"
                {{ old('statut',isset($product->statut) ? $product->statut : 1) == '1' ? 'checked' : '' }} >
            {{ __('Activate') }}</label>

        <label>
            <input type="radio" value="0" name="statut"
                {{ old('statut',isset($product->statut) ? $product->statut : 1) == '0' ? 'checked' : '' }}>
            {{ __('Deactivate') }}</label>
    </div>
</div>




  
  <div class="control-group">
    <label class="control-label" for="dci">DCI</label>
    <div class="controls">
      <select  class="form-control span8 @error('dci') is-invalid @enderror" id="dci" name="dci">
        
        @foreach ($dcis as $dci)
         <option value="{{ $dci->id }}"{{ isset($product) ? ($product->dci_id==$dci->id ? 'selected' :'' ): '' }} >{{ $dci->designation }}</option>
       
        @endforeach
      </select>
      @error('dci')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror
  <!------- fin error message --------->
    </div>
  </div>