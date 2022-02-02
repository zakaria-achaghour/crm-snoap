<div class="control-group">
    <label class="control-label">UG</label>
    <div class="controls">
        <select multiple name='ugs[]' id="ug"  class='span8' >
            <option value=""></option>
            @foreach ($ugs as $ug)
                <option value="{{ $ug->id }}">{{ $ug->designation }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    
</script>

<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>