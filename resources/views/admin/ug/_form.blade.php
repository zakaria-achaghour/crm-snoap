<div class="control-group">
    <label for="firstname" class="control-label ">Désignation</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('designation') is-invalid @enderror" name="designation" id="designation"
            placeholder="Désignation" value="{{ old('designation', $ug->designation ?? null) }}">
        @error('designation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label for="num" class="control-label ">num ugs</label>
    <div class="controls ">

            <select name='num[]' class='span8' multiple>
                <option></option>
                @foreach ($numugs as $num)
                    <option value="{{ $num->id }}" 
                        {{ isset($ug) ? (in_array($num->id,$nums)  ? 'selected' :'' ): '' }}>
                        {{ $num->id }} </option>
                @endforeach
            </select>
       
        @error('num')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="control-group">
    <label for="name" class="control-label ">{{ __('Region') }}</label>
    <div class="controls ">

            <select name='regionmc' class='span8'>
                <option></option>
                @foreach ($regionmcs as $regionmc)
                    <option value="{{ $regionmc->id }}" {{ isset($ug) ? ($ug->regionmc_id == $regionmc->id ? 'selected' : ''):'' }}>
                        {{ $regionmc->designation }} </option>
                @endforeach
            </select>
       
        @error('regionmc')
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
            <input type="radio" class=" @error('bloquer') is-invalid @enderror" id="bloquer" name="bloquer" value="1"
                required {{ old('bloquer') == "1" ? 'checked' : '' }}
                {{ isset($ug) ? ($ug->statut === "1" ? 'checked' : '') : 'checked' }}>
            {{ __('Activate') }}
        </label>
        <label class="" for="bloquer2">

            <input type="radio" class=" @error('bloquer') is-invalid @enderror" id="bloquer2" name="bloquer" value="0"
                required {{ old('bloquer') == "0" ? 'checked' : '' }}
                {{ isset($ug) ? ($ug->statut === "0" ? 'checked' : '') : '' }}>

            {{ __('Deactivate') }}</label>
        @error('bloquer')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>