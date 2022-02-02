<div class="control-group">
    <label for="firstname" class="control-label ">Nom Et Prénom</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('name') is-invalid @enderror" name="name" id="name"
            value="{{ old('name', $doctor->name ?? null) }}" required>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label for="firstname" class="control-label ">Téléphoner</label>
    <div class="controls ">
        <input type="number" class="span8 form-control @error('phone') is-invalid @enderror" name="phone" id="designation"
         value="{{ old('phone', $doctor->phone ?? null) }}">
        @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label class="control-label">Région</label>
    <div class="controls">
        
        <select name='region' class="span8 @error('region') is-invalid @enderror">
            <option value=""></option>
            @foreach ($regions as $region)
              
              <option value="{{ $region->id }}" {{ isset($doctor) ?($doctor->region_id == $region->id ? 'selected' : '' ):''}}> {{ $region->designation }} </option>
    
            @endforeach
        </select>
        @error('region')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
</div>

<div class="control-group">
    <label class="control-label">{{ __('Cities') }}</label>
    <div class="controls">
        
        <select name='ville' class="span8 @error('ville') is-invalid @enderror">
            <option value=""></option>

            @foreach ($villes as $ville)
              
              <option value="{{ $ville->id }}" {{ isset($doctor) ?($doctor->ville_id == $ville->id ? 'selected' : '' ):''}}> {{ $ville->nom }} </option>
    
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
    <label class="control-label">UG</label>
    <div class="controls">
        
        <select name='ug' class='span8'>
            <option value=""></option>

            @foreach ($ugs as $ug)
              
              <option value="{{ $ug->id }}" {{ isset($doctor) ?($doctor->ug_id == $ug->id ? 'selected' : '' ):''}}> {{ $ug->designation }} </option>
    
            @endforeach
        </select>
    </div>
</div>

<div class="control-group">
    <label for="adresse" class="control-label ">Adresse</label>
    <div class="controls">

        <textarea class="span8 form-control @error('adresse') is-invalid @enderror" name="adresse" id="adresse">{{ old('adresse', $doctor->adresse ?? null) }}</textarea>
       
        @error('adresse')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label class="control-label">Spécialités</label>
    <div class="controls">
        
        <select name='specialty' class="span8 @error('specialty') is-invalid @enderror">
            <option value=""></option>

            @foreach ($specialties as $specialty)
              
              <option value="{{ $specialty->id }}" {{ isset($doctor) ?($doctor->specialty_id == $specialty->id ? 'selected' : '' ):''}}> {{ $specialty->designation }} </option>
    
            @endforeach
          
        </select>
        @error('specialty')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
</div>
<div class="control-group">
    <label class="control-label">Statut MC</label>
    <div class="controls">
        
        <select name='statut' class="span8 @error('statut') is-invalid @enderror">
            <option value="PRIVE" {{(isset($doctor) ? ($doctor->statut_mc == 'PRIVE' ? 'selected' : ''):'' )}}>PRIVE</option>
            <option value="PUBLIC" {{(isset($doctor) ? ($doctor->statut_mc == 'PUBLIC' ? 'selected' : ''):'' )}}>PUBLIC</option>
        </select>
        @error('statut')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
</div>

<div class="control-group">
    <label for="nombre_patients" class="control-label ">Nombre de patients</label>
    <div class="controls ">
        <input type="number" class="span8 form-control @error('nombre_patients') is-invalid @enderror" name="nombre_patients" id="nombre_patients"
            value="{{ old('nombre_patients', $doctor->nombre_patients ?? null) }}">
        @error('nombre_patients')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

