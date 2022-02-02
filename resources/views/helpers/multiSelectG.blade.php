<div class="control-group selectetsearch">
    <select multiple name='grossistes[]' id="grossistes" >
        <option></option>
        @foreach ($grossistes as $Grossiste)
            <option value="{{ $Grossiste->id }}" >{{ $Grossiste->designation }}</option>
        @endforeach
    </select>
        
</div>
</div>
<script>
      var select = document.getElementById("grossistes");
        multi(select, {
            non_selected_header: "",
            selected_header: ""
        });
</script>