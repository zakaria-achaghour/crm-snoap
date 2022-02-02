
<div class="row-fluid">
    <div class="control-group">
        <label for="Speciality" class="control-label ">Info médecin</label>
        <div class="controls ">
            <input type="text" class="span8 form-control text-center" name="Speciality" id="Speciality" disabled
                value="{{ $doctor->specialty->designation . ', '. $doctor->nombre_patients . ' patients '}}">
                
        </div>
    </div>
</div>