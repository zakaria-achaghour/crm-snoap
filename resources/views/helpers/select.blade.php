<select class="form-control @error('{{ $name }}') is-invalid @enderror" id='{{ $name }}' name='{{ $name }}'>
    <option value=""></option>
    @for ($i = 0; $i < count($data); $i++)
        <option value="{{ $data[$i]->id }}">
            {{ $data[$i]->designation }} </option>
    @endfor
</select>