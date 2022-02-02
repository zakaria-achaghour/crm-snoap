<div class="widget-box principle">
    <div class="widget-title "> <span class="icon"> <i class="icon-beaker"></i> </span>
        <h5>Détail ADV</h5>
    </div>
    <div class="widget-content nopadding">



        <div class="control-group">
            <label for="demandeur" class="control-label ">demandeur</label>
            <div class="controls ">
                <input type="text" class="span8 form-control text-center" name="demandeur" id="demandeur" disabled
                    value="{{ $adv->user->firstname . ' ' . $adv->user->lastname }}">

            </div>
        </div>

        <div class="control-group">
            <label for="network" class="control-label ">Résaux</label>
            <div class="controls ">
                <input type="text" class="span8 form-control text-center" name="network" id="network" disabled
                    value="{{ $adv->network->designation }}">

            </div>
        </div>

        <div class="control-group">
            <label for="rubrique" class="control-label ">Rubrique</label>
            <div class="controls ">
                <input type="text" class="span8 form-control text-center" name="rubrique" id="rubrique" disabled
                    value="{{ $adv->rubrique }}">
            </div>
        </div>


        <div class="control-group">
            <label for="ug" class="control-label ">Ug</label>
            <div class="controls ">
                <input type="text" class="span8 form-control text-center" name="ug" id="ug" disabled
                    value="{{ $adv->doctor->ug->designation }}">

            </div>
        </div>


        <div class="control-group">
            <label for="doctor" class="control-label ">Medecin</label>
            <div class="controls ">
                <input type="text" class="span8 form-control text-center" name="doctor" id="doctor" disabled
                    value="{{ $adv->doctor->name }}">

            </div>
        </div>

        <div class="control-group">
            <label for="Speciality" class="control-label ">Info médecin</label>
            <div class="controls ">
                <input type="text" class="span8 form-control text-center" name="Speciality" id="Speciality" disabled
                    value="{{ $adv->doctor->specialty->designation . ',   ' . $adv->doctor->nombre_patients . ' patients ' }}">

            </div>
        </div>

        <div class="control-group">
            <label for="nature" class="control-label ">Nature</label>
            <div class="controls ">
                <input type="text" class="span8 form-control text-center" name="nature" id="nature" disabled
                    value="{{ $adv->nature->designation }}">

            </div>
        </div>

        <div class="control-group">
            <label for="dNature" class="control-label  ">Details Nature</label>
            <div class="controls ">
                <textarea name="dNature" id="dNature" rows="5" disabled
                    class='span8'>{{ $adv->nature_detail }}</textarea>


            </div>
        </div>

        <div class="control-group">
            <label for="budgetPrev" class="control-label ">Budget Prévu</label>
            <div class="controls ">
                <input type="number" class="span8 form-control text-center" name="budgetPrev" id="budgetPrev" disabled
                    value="{{ $adv->budget_prev }}">
            </div>
        </div>

        <div class="control-group">
            <label for="month" class="control-label ">Date de Livraison Prévue</label>
            <div class="controls ">
                <input type="text" class="span8 form-control text-center" name="month" id="month" disabled
                    value="{{ $adv->month->Mois }}">
            </div>
        </div>
        <div class="row-fluid">
            <div class="control-group span6">
                <label for="debut" class="control-label ">Début</label>
                <div class="controls ">

                    <input type="text" class="form-control @error('debut') is-invalid @enderror" name="debut" id="debut"
                        disabled value="{{ $adv->date_debut }}">
                </div>
            </div>
            <div class="control-group span6">
                <label for="fin" class="control-label ">Fin</label>
                <div class="controls">
                    <input type="text" class="form-control @error('fin') is-invalid @enderror" name="fin" id="fin"
                        disabled value="{{ $adv->date_fin }}">
                </div>
            </div>
        </div>

    </div>
</div>


<div class="widget-box secondaire">

    <div class="logo-print">
        <img src="{{ asset('layout/img/logo3.jpg')}}" alt="logo">
    </div>

    <div class="widget-content nopadding">
        <h3 class="text-center">Détail ADV</h3>

        <div class="group-print">
            <div class="span6">
                <p for="demandeur" class="titleprint">demandeur :</p>
                <p class="resprint">{{ $adv->user->firstname . ' ' . $adv->user->lastname }}</p>
            </div>

            <div class="span6">
                <p for="network" class="titleprint">Résaux :</p>
                <p class="resprint">{{ $adv->network->designation }}</p>
            </div>
        </div>

        <div class="group-print">
            <div class="span6">
                <p for="rubrique" class="titleprint">Rubrique :</p>
                <p class="resprint">{{ $adv->rubrique }}</p>
            </div>

            <div class="span6">
                <p for="ug" class="titleprint">Ug :</p>
                <p class="resprint">{{ $adv->doctor->ug->designation }}</p>
            </div>
        </div>

        <div class="group-print">
            <div class="span6">
                <p for="doctor" class="titleprint">Medecin :</p>
                <p class="resprint">{{ $adv->doctor->name }}</p>
            </div>

            <div class="span6">
                <p for="Speciality" class="titleprint">Info médecin :</p>
                <p class="resprint">
                    {{ $adv->doctor->specialty->designation . ',   ' . $adv->doctor->nombre_patients . ' patients ' }}
                </p>
            </div>
        </div>

        <div class="group-print">
            <div class="span6">
                <p for="nature" class="titleprint">Nature :</p>
                <p class="resprint">{{ $adv->nature->designation }}</p>
            </div>

            <div class="span6">
                <p for="dNature" class="titleprint">Details Nature :</p>
                <p class="resprint">{{ $adv->nature_detail }}</p>
            </div>
        </div>

        <div class="group-print">
            <div class="span6">
                <p for="budgetPrev" class="titleprint">Budget Prévu :</p>
                <p class="resprint">{{ $adv->budget_prev }}</p>
            </div>

            <div class="span6">
                <p for="month" class="titleprint">Date de Livraison Prévue :</p>
                <p class="resprint">{{ $adv->month->Mois }}</p>
            </div>
        </div>

        <div class="group-print">
            <div class="span6">
                <p for="debut" class="titleprint">Début :</p>
                <p class="resprint">{{ $adv->date_debut }}</p>
            </div>

            <div class="span6">
                <p for="fin" class="titleprint">Fin :</p>
                <p class="resprint">{{ $adv->date_fin }}</p>
            </div>
        </div>

    </div>
</div>

<div class="visa">
    <p>Signature</p>
</div>

<script>
    $(document).ready(function() {
        $('.secondaire').hide();
        $('.visa').hide();
    })

        
</script>
