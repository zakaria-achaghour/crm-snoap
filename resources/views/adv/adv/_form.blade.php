<div class="control-group">
    <label for="demandeur" class="control-label ">demandeur</label>
    <div class="controls ">
        <select class="form-control span8  @error('demandeur') is-invalid @enderror " id="demandeur" name="demandeur">
            <option value=""></option>
            @foreach ($demandeurs as $demandeur)
                <option value="{{ $demandeur->id }}" {{ old('demandeur') == $demandeur->id ? 'selected' : '' }}>
                    {{ $demandeur->firstname .'  '.$demandeur->lastname }}</option>
            @endforeach
        </select>
        <!------- error message --------->
        {{-- @error('network')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>

     @enderror --}}
        @if ($errors->get('demandeur'))
            @foreach ($errors->get('demandeur') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif


    </div>
</div>

<div class="control-group  ">
    <label class="control-label span4" for="network">Résaux</label>
    <div class="controls">
        <select class="form-control span8  @error('network') is-invalid @enderror " id="network" name="network">
            <option value=""></option>
            @foreach ($networks as $network)
                <option value="{{ $network->id }}" {{ old('network') == $network->id ? 'selected' : '' }}>
                    {{ $network->designation }}</option>
            @endforeach
        </select>
     
        @if ($errors->get('network'))
            @foreach ($errors->get('network') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif


    </div>
</div>

{{-- place for rubrique --}}

<div class="control-group inline">
    <label class="control-label">Rubrique</label>
    <div class="controls">
        <label>
            <input type="radio" name="rubrique" value="rp" {{ old('rubrique') == 'rp' ? 'checked' : '' }} />
            RP</label>
        <label>
            <input type="radio" name="rubrique" value="reunion" {{ old('rubrique') == 'reunion' ? 'checked' : '' }} />
            Réunion</label>
        <label>
            <input type="radio" name="rubrique" value="congre" {{ old('rubrique') == 'congre' ? 'checked' : '' }} />
            Congré</label>
        <label>
            <input type="radio" name="rubrique" value="autre" {{ old('rubrique') == 'autre' ? 'checked' : '' }} />
            Autre</label>

        @if ($errors->get('rubrique'))
            @foreach ($errors->get('rubrique') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif
    </div>
</div>

{{-- end place for rubrique --}}
<div class="control-group">
    <label for="regionmc" class="control-label ">{{ __('Region') }}</label>
    <div class="controls ">

        <select name='regionmc' class="span8  @error('regionmc') is-invalid @enderror " id="regionmc">
            <option></option>
            @foreach ($regionmcs as $regionmc)
                <option value="{{ $regionmc->id }}" >
                    {{ $regionmc->designation }} </option>
            @endforeach
        </select>

        @if ($errors->get('regionmc'))
            @foreach ($errors->get('regionmc') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        
        @elseif ($errors->get('ug'))
            @foreach ($errors->get('ug') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @elseif ($errors->get('doctor'))
            @foreach ($errors->get('doctor') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif
    </div>
</div>

<div id="ugDisplay">

</div>

<div id="DoctorDisplay">

</div>

<div id="DoctorInfoDisplay">

</div>

<div class="control-group">
    <label for="nature" class="control-label ">Nature</label>
    <div class="controls ">

        <select name='nature' class="span8 @error('nature') is-invalid @enderror " id="nature">
            <option></option>
            @foreach ($natures as $nature)
                <option value="{{ $nature->id }}" {{ old('nature') == $nature->id ? 'selected' : '' }}>
                    {{ $nature->designation }}</option>
            @endforeach
        </select>

        @if ($errors->get('nature'))
            @foreach ($errors->get('nature') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif
    </div>
</div>

<div class="control-group">
    <label for="dNature" class="control-label ">Details Nature</label>
    <div class="controls ">

        <textarea name="dNature" id="dNature" rows="5" class='span8'>{{ old('dNature') }}</textarea>
        @if ($errors->get('dNature'))
            @foreach ($errors->get('dNature') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif

    </div>
</div>
<div class="control-group">
    <label for="budgetPrev" class="control-label ">Budget Prévu</label>
    <div class="controls ">
        <input type="number" class="span8 form-control" name="budgetPrev" id="budgetPrev"
            value="{{ old('budgetPrev') }}">

        @if ($errors->get('budgetPrev'))
            @foreach ($errors->get('budgetPrev') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif
    </div>
</div>

<div class="control-group">
    <label for="month" class="control-label ">Date de Livraison Prévue</label>
    <div class="controls ">
        <select name='month' class="span8  @error('month') is-invalid @enderror " id="month">
            <option></option>
            @foreach ($months as $month)
                <option value="{{ $month->id }}" {{ old('month') == $month->id ? 'selected' : '' }}>
                    {{ $month->Mois }}</option>
            @endforeach
        </select>
        @if ($errors->get('month'))
            @foreach ($errors->get('month') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif
    </div>
</div>

<div class="row-fluid">
    <div class="control-group span6">
        <label for="debut" class="control-label ">Début</label>
        <div class="controls ">

            <input type="date" class="form-control @error('debut') is-invalid @enderror" name="debut" id="debut"
                value="{{ old('debut') }}">

            @error('debut')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="control-group span6">
        <label for="fin" class="control-label ">Fin</label>
        <div class="controls">
            <input type="date" class="form-control @error('fin') is-invalid @enderror" name="fin" id="fin"
                value="{{ old('fin') }}">

            @error('fin')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<script>
    $("#regionmc").change(function() {

        var regionmc_id = $("#regionmc").val();

        var url = '/getUgByRegionmc/' + regionmc_id;
        $.ajax({
            type: 'GET',
            url: url,
            cache: false,
            success: function(r) {
                $("#ugDisplay").hide().html(r).fadeIn(0);
            }
        });
    });
</script>
