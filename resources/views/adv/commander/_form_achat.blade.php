<input type="hidden" value="{{ $adv->id }}" id="adv_id">
<!----------------  Budget réel HT Input --------->
<div class="control-group">
    <label for="budgetReel" class="control-label ">Budget réel HT</label>
    <div class="controls ">
        <input type="number" class="span8 form-control" name="budgetReel" id="budgetReel"
            value="{{ old('budgetReel',$adv->budget_reel) }}">

        @if ($errors->get('budgetReel'))
            @foreach ($errors->get('budgetReel') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif
    </div>
</div>

<!--------------------------  Budget TVA --------------------->
<div class="control-group">
    <label for="tva" class="control-label ">TVA %</label>
    <div class="controls ">
        <input type="number" class="span8 form-control" name="tva" id="tva" value="{{ old('tva',$adv?$adv->tva:20) }}">

        @if ($errors->get('tva'))
            @foreach ($errors->get('tva') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif
    </div>
</div>

<!--------------------  Fournisseur Input --------->
<div class="control-group">
    <label for="fournisseur" class="control-label ">Fournisseur</label>
    <div class="controls ">
        <select name='fournisseur' class="span8  @error('fournisseur') is-invalid @enderror " id="fournisseur">
            <option></option>
            @foreach ($fournisseurs as $fournisseur)
                <option value="{{ $fournisseur->id }}"
                    {{ old('fournisseur',$adv->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>
                    {{ $fournisseur->designation }}</option>
            @endforeach
        </select>
        @if ($errors->get('fournisseur'))
            @foreach ($errors->get('fournisseur') as $msg)
                <ul class="list-unstyled text-danger">
                    <li> <br>
                        <h6>{{ $msg }}</h6>
                    </li>
                </ul>
            @endforeach
        @endif
    </div>
</div>
