
<div class="control-group">
    <label for="demandeur" class="control-label ">demandeur </label>
    <div class="controls ">
        <select class="form-control span8  @error('demandeur') is-invalid @enderror " id="demandeur" name="demandeur">
            <option value=""></option>
            @foreach ($demandeurs as $demandeur)
                <option value="{{ $demandeur->id }}"  {{ old('demandeur',$adv->user_id) == $demandeur->id ? 'selected' : '' }}>
                    {{ $demandeur->firstname .'  '.$demandeur->lastname }}</option>
            @endforeach
        </select>
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
                <option value="{{ $network->id }}" {{ old('network',$adv->network_id) == $network->id ? 'selected' : '' }}>
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
<div class="control-group">
    <label for="regionmc" class="control-label ">{{ __('Region') }} </label>
    <div class="controls ">

        <select name='regionmc' class="span8  @error('regionmc') is-invalid @enderror " id="regionmc">
            <option></option>
            @foreach ($regionmcs as $regionmc)
                <option value="{{ $regionmc->id }}" {{ old('regionmc',isset($adv->regionmc)?$adv->regionmc:'') == $regionmc->id ? "selected" :"" }} >
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
@include('adv.adv.ug',$adv)
</div>

<div id="DoctorDisplay">
@include('adv.adv.doctors')
</div>

<div id="DoctorInfoDisplay">
    {{-- @include('adv.adv.doctorInfo') --}}

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