  <div class="control-group">
    <label class="control-label" for="responsable">Responsable</label>
    <div class="controls">
      <select  class="form-control span8 @error('responsable') is-invalid @enderror" id="responsable" name="responsable">
        <option value=""></option>
        @foreach ($responsables as $responsable)
         <option value="{{ $responsable->id }}"{{ isset($objectif) ? (($objectif->user_id == $responsable->id) ? 'selected' :'' ): '' }} >{{ $responsable->lastname}} {{ $responsable->firstname}}</</option>
        @endforeach
      </select>
      <!------- error message --------->
      @error('responsable')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
</div>

<div id="ugDisplay">

</div>

<script>
    $("#responsable").change(function() {

        var user_id = $("#responsable").val();
        var url = '/getUg/'+user_id;
        $.ajax({
            type: 'GET',
            url:url ,
            cache:false,
            success: function(r) {
                $("#ugDisplay").hide().html(r).fadeIn(0);
            }
        });


    });
</script>