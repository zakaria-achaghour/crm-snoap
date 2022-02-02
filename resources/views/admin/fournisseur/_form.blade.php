<div class="control-group">
    <label for="code_sage" class="control-label ">Code sage</label>
    <div class="controls ">
        <input type="text" name="code_sage" id="code_sage"
            class="span8 form-control @error('code_sage') is-invalid @enderror"
            value="{{ old('code_sage', $fournisseur->code_sage ?? null) }}">

        @error('code_sage')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="control-group">
    <label for="firstname" class="control-label ">{{ __('designation') }}</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('designation') is-invalid @enderror" name="designation"
            id="designation" placeholder="....." value="{{ old('designation', $fournisseur->designation ?? null) }}">
        @error('designation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label class="control-label">{{ __('Cities') }}</label>
    <div class="controls">
        <select name='ville' id="ville" class="span8 @error('ville') is-invalid @enderror">
            <option value=""></option>
            @foreach ($villes as $ville)
              
              <option value="{{ $ville->id }}" {{ isset($fournisseur) ?($fournisseur->ville_id == $ville->id ? 'selected' : '' ):''}}> {{ $ville->nom }} </option>
    
            @endforeach
        </select>
        @error('ville')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
</div>

<div class="control-group">
    <label class="control-label">{{ __('Statut') }}</label>
    <div class="controls">
        <label class="" for="bloquer">
            <input type="radio" class=" @error('bloquer') is-invalid @enderror" id="bloquer" name="bloquer" value="0"
                required {{ old('bloquer') == 0 ? 'checked' : '' }}
                {{ isset($fournisseur) ? ($fournisseur->statut === '0' ? 'checked' : '') : 'checked' }}>
            {{ __('Activate') }}
        </label>
        <label class="" for="bloquer2">

            <input type="radio" class=" @error('bloquer') is-invalid @enderror" id="bloquer2" name="bloquer" value="1"
                required {{ old('bloquer') == 1 ? 'checked' : '' }}
                {{ isset($fournisseur) ? ($fournisseur->statut === '1' ? 'checked' : '') : '' }}>

            {{ __('Deactivate') }}</label>
        @error('bloquer')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>


<!-------------------- fin champs 6 -------------------------->

<!-------------------- champs 7 -------------------------->

<div class="control-group @if (old('bloquer')==1) '' @else {{ isset($fournisseur) ? ($fournisseur->statut === '0' ? 'hide' : '') : 'hide' }} @endif " id="motif">
    <label for="motif" class="control-label" id="lblmotif">{{ __('Blocking pattern') }}</label>
    <div class="controls">
        <input type="text" class="form-control span8 @error('motif') is-invalid @enderror" name="motif" id="motif"
            value="{{ old('motif', $fournisseur->motif ?? null) }}">
        <!------- error message --------->
        @error('motif')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <!------- fin error message --------->
    </div>
</div>





