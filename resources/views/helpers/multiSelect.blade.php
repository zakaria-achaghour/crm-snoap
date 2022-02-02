<div class="control-group selectetsearch">
    <select multiple name='medecin_write[]' id="medecin_write" >
        <option></option>
        @foreach ($medecins as $medecin)
            <option value="{{ $medecin->id }}" >DR. {{ $medecin->name }}</option>
        @endforeach
    </select>
        
</div>
</div>
<script>
      var select = document.getElementById("medecin_write");
        multi(select, {
            non_selected_header: "",
            selected_header: ""
        });
</script>