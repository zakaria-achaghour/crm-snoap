<div class="control-group">
    <label class="control-label" for="client">{{ __('Name Pharmacy')}}</label>

    <div class="controls">
        <select class="form-control span11 @error('client') is-invalid @enderror" id="client" name="client">
            <option value=""></option>
            @foreach ($clients as $cl)
                <option value="{{ $cl->id }}"
                    {{ isset($cheque) ? ($cheque->client_id == $cl->id ? 'selected' : '') : '' }}>{{ $cl->nom }}
                    -
                    {{ $cl->sage }}</option>
            @endforeach
        </select>
    </div>
</div>



<div class="control-group">
    <label for="montant" class="control-label ">{{ __('Amount')}}</label>
    <div class="controls">
        <input type="number" step="any" class="form-control span11 @error('montant') is-invalid @enderror" name="montant"
            id="montant" placeholder="montant" value="{{ old('montant', $cheque->montant ?? null) }}">
        <!------- error message --------->
        @error('montant')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <!------- fin error message --------->
    </div>
</div>

<div class="control-group">
    <label for="paye" class="control-label ">{{ __('Amount paid')}}</label>
    <div class="controls">
        <input type="number"  step="any" class="form-control span11 @error('paye') is-invalid @enderror" name="paye"
            id="paye" placeholder="montant payé" value="{{ old('paye', $cheque->paye ?? 0) }}">
        <!------- error message --------->
        @error('paye')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <!------- fin error message --------->
    </div>
</div>

<div class="control-group">
    <label for="observation" class="control-label ">Observation</label>
    <div class="controls ">
        <input type="text" class="span11 form-control @error('observation') is-invalid @enderror" name="observation"
            id="observation" value="{{ old('observation', $cheque->observation ?? null) }}">
        @error('observation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="control-group">
    <label for="date_recouvrement" class="control-label ">{{ __('Collection date')}}</label>
    <div class="controls">
        <input type="date" class="form-control span11 @error('date_recouvrement') is-invalid @enderror"
            name="date_recouvrement" id="date_recouvrement" placeholder="date_recouvrement"
            value="{{ old('date_recouvrement', $cheque->date_recouvrement ?? null) }}">
        <!------- error message --------->
        @error('date_recouvrement')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <!------- fin error message --------->
    </div>
</div>