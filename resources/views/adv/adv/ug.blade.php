
<div class="control-group">
    <label class="control-label">UG</label>
    <div class="controls">
        
        <select name='ug' class="span8 @error('ug') is-invalid @enderror " id="ug">
            <option value=""></option>

            @foreach ($ugs as $ug)
              
              <option value="{{ $ug->id }}"  {{ old('ug',isset($adv->ug)?$adv->ug:'') == $ug->id ? "selected" :"" }}> {{ $ug->designation }} </option>
    
            @endforeach
        </select>
        @if ($errors->get('ug'))
        @foreach ($errors->get('ug') as $msg)
            <ul class="list-unstyled text-danger">
                <li> <br><h6>{{ $msg }}</h6> </li>
            </ul>
        @endforeach
        @endif

    </div>
</div>

<script>
      $("#ug").change(function() {
       
        var ug_id = $("#ug").val();
        var url = '/getDoctorsByUg/'+ug_id;
        $.ajax({
            type: 'GET',
            url:url ,
            cache:false,
            success: function(r) {
                $("#DoctorDisplay").html(r).fadeIn(0);
            }
        });


     });
</script>

<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>