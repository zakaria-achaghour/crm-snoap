<div class="control-group">
    <label for="num" class="control-label ">Num</label>
    <div class="controls ">
        <input type="number" class="span8 form-control @error('num') is-invalid @enderror" name="num" id="num"
         value="{{ old('num', $num ?? null) }}">
        @error('num')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

