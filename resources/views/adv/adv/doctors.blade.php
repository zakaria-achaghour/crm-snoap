

   <div class="control-group">
    <label for="doctor" class="control-label ">Médecin </label>
    <div class="controls">
        <select class="form-control span8 @error('doctor') is-invalid @enderror "  id="doctor"
            name="doctor">
            <option value=""></option>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}"  {{ old('doctor',isset($adv->doctor_id)?$adv->doctor_id:'') == $doctor->id ? "selected" :"" }} >{{ $doctor->name  .' | '. $doctor->adresse  .' | '. $doctor->specialty->designation}}</option>
              
                @endforeach
        </select>
        <!------- error message --------->
          @if ($errors->get('doctor'))
            @foreach ($errors->get('doctor') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br><h6>{{ $msg }}</h6> </li>
                </ul>
            @endforeach
            @endif

        <!------- fin error message --------->
    </div>
</div>

<script>
    $("#doctor").change(function() {
    
      var doctor_id = $("#doctor").val();
     
      var url = '/getDoctorInfo/'+doctor_id;
      $.ajax({
          type: 'GET',
          url:url ,
          cache:false,
          success: function(r) {
              $("#DoctorInfoDisplay").html(r).fadeIn(0);
          }
      });


   });
</script>
<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>