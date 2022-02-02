

<!------------------ champs 1 ------------------>
<input type="hidden" id="delegue" value="{{ Auth::id() }}">
<div class="control-group" id="date_strt">
    <label class="control-label">De: </label>
    <div class="controls">
        <input type="date" class="form-control @if ($errors->get('nom')) is-invalid @endif"
        name="de" id="de" value="{{ old('de', $week_start ?? '') }}">
        &nbsp;&nbsp;A:&nbsp;&nbsp;
        <input type="date" class="form-control  @if ($errors->get('nom')) is-invalid @endif"
        name="a" id="a" value="{{ old('a', $week_end ?? '') }}">

        <!------- error message --------->
        @if ($errors->get('nom'))
            @foreach ($errors->get('nom') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> {{ $msg }} </li>
                </ul>
            @endforeach
        @endif
        <!------- fin error message --------->
        <!------- error message --------->
        @if ($errors->get('nom'))
            @foreach ($errors->get('nom') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> {{ $msg }} </li>
                </ul>
            @endforeach
        @endif
        <!------- fin error message --------->
    </div>
</div>
<!------------------ fin champs 1 ------------------>

<!------------------ champs 1 ------------------>
@if(isset($delegues))
<div class="control-group" id="pharmacie">
    <label class="control-label">Délégué</label>
    <div class="controls">
            <select name='delegue' id="selected_delegue" class=''>
                <option value="{{ Auth::user()->id }}" >{{ Auth::user()->firstname }}  {{ Auth::user()->lastname }} </option>
                @foreach ($delegues as $delegue)
                    <option value="{{ $delegue->id }}" >{{ $delegue->firstname }}  {{ $delegue->lastname }} </option>
                @endforeach
            </select>
        
        @error('delegue')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
@endif
<div class="control-group" id="pharmacie">
    <label class="control-label">UG</label>
    <div class="controls">

        <select class="form-control @error('ug') is-invalid @enderror" id="ug" name="ug">
            <option value=""></option>
            @for ($i = 0; $i < count($ugs); $i++)
                <!-- { (old("pharmacie") == $pharmacie[$i]->id  ? "selected":"") }  Define the selected option with the old input -->
                <option value="{{ $ugs[$i]->id }}">
                    {{ $ugs[$i]->designation }} </option>
            @endfor
        </select>
        @error('ug')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
        
    </div>
</div>
<script>
        
    $("#selected_delegue").change(function() {
        
        $("#delegue").val($(this).val());
        
    });

</script>
