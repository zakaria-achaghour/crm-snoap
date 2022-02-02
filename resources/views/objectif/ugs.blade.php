<div class="control-group">
    <label class="control-label">UG</label>
    <div class="controls">
        <select name='ugs' id="ug"  class='span8' >
            <option value=""></option>
            @foreach ($ugs as $ug)
                <option value="{{ $ug->id }}">{{ $ug->designation }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="control-group" id="date_strt">
    <label class="control-label">De: </label>
    <div class="controls">
        <input type="date" class="form-control "
        name="de" id="de" value="">
        &nbsp;&nbsp;A:&nbsp;&nbsp;
        <input type="date" class="form-control  "
        name="a" id="a" value="">
        <!------- fin error message --------->
    </div>
</div>
  
<div class="control-group">
    <label for="montant" class="control-label ">Montant</label>
    <div class="controls ">
        <input type="number" class="span8 form-control @error('montant') is-invalid @enderror" name="montant" id="montant"
             value="{{ old('montant', $objectif->montant ?? null) }}">
        @error('montant')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="control-group">
    <label for="medecine" class="control-label ">Nombre Médecin</label>
    <div class="controls ">
        <input type="number" class="span8 form-control @error('medecine') is-invalid @enderror" name="medecine" id="medecine"
             value="{{ old('medecine', $objectif->nombre_medecine ?? null) }}">
        @error('medecine')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>