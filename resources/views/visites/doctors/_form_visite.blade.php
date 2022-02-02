
<h2 class="text-center">{{ $doctor->name.' - '.$doctor->specialite }}</h2>
<div class="row-fluid">
    <div class="span6">
        <div class="widget-box responsive-table-x ">
            <div class="widget-title h_demande"  data-toggle="collapse" href="#collapseG3" > <span class="icon"> <i class="icon-chevron-down"></i> </span>
                <h5 class="h_demande">HISTORIQUE (DEMANDE SPECIALE)</h5>
            </div>
            <div class="widget-content nopadding updates collapse in" id="collapseG3">
                <input type="hidden" id="demande" value="{{ count($demandes) }}">
                @if (count($demandes)>0)
                    
                    @foreach ($demandes as $demande )

                    <div class="new-update clearfix"> <i class="icon-comment-alt"></i> <span class="update-notice">
                        <strong>{{ $demande->firstname .' '. $demande->lastname}}</strong> 
                        <span>{{ $demande->demande_special }}</span> </span> <span class="update-date">
                        <span class="update-day">{{ date('d', strtotime($demande->created_at))}}</span>{{ date('M', strtotime($demande->created_at))}}</span> 
                    </div>

                    @endforeach

                @else

                    <div class="form-actions">
                        <div class="alert alert-error">
                            <strong>Aucune Demande </strong> 
                        </div>
                    </div>

                @endif
               
            </div>
        </div>  
    </div>
    <div class="span6">
        <div class="widget-box responsive-table-x">
            <div class="widget-title h_product" data-toggle="collapse" href="#collapseG4" > <span class="icon"> <i class="icon-chevron-down"></i> </span>
                <h5 class="h_product">HISTORIQUE (ENQUETE)</h5>
            </div>
            <div class="widget-content nopadding "  id="collapseG4">
                <input type="hidden" id="h_product" value="{{ count($demandes) }}">
                @php
                    $nb=0;
                @endphp
                @foreach ($h_produits as $h_produit)
                    @if ($h_produit->qte!=NULL)
                    @php
                        $nb++;
                    @endphp
                    @endif                    
                @endforeach
                @if (($nb)>0)
                    
                    <table class="table table-bordered">
                        <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Date</th>
                                </tr>
                        </thead>
                        <tbody>
                        @foreach ($h_produits as $h_produit)
                            @if ($h_produit->qte!=NULL)
                                <tr>
                                    <td class="table-action">{{ $h_produit->designation }}</td>
                                    <td class="table-action">{{ $h_produit->qte}}</td>
                                    <td class="table-action">{{ \Carbon\Carbon::parse(  $h_produit->created_at)->format('d/m/Y') }}</td>
                                </tr>
                            @endif
                            
                        @endforeach
                        </tbody>
                    </table>

                @else

                    <div class="form-actions">
                        <div class="alert alert-error">
                            <strong>Aucune enquête </strong> 
                        </div>
                    </div>

                @endif
                
            </div>
        </div>
    </div>
</div>

<div class="widget-box">
    <div class="widget-title {{isset($visite)?'widget-title-green':''}}"> <span class="icon"> <i class="icon-user-md"></i> </span>
        <h5 class="{{isset($visite)?'widget-title-green':''}}">{{ $doctor->name.' - '.$doctor->specialite }} {{isset($visite)? ' - ('. $visite->nombre_patient .')':'' }}</h5>
    </div>
    <div class="widget-content nopadding">
        <input type="hidden" name="visiteStep" id="visiteStep" value="{{isset($visite)?$visite->step:''}}">
        <input type="hidden" name="visiteID" id="visiteID" value="{{isset($visite)?$visite->id:''  }}">
        <input type="hidden" name="visite_fin" id="visite_fin" value="{{isset($visite)?$visite->fin:0  }}">

        <input type="hidden" id="demandeSpecial" value="{{isset($visite)?$visite->demande_special:''}}">
        
        <input type="hidden" name="doctorId" id="doctor_id" value="{{$doctor->id}}">
        <input type="hidden" name="motif" id="motif" value="{{$doctor->motif}}">
       

        @if(isset($planning))
        <input type="hidden" name="planning_id" value="{{$planning}}">
        @endif
        <div class="control-group  {{isset($visite)? 'hide':'' }}">
            <!------------------ champs 3.1.1 ------------------>
            <label for="patient" class="control-label ">Nombre de Patients</label>
            
            <div class="controls patient">
                <a id="patient_p" class="btn btn-default btn-large radius-left"><i class="icon-plus"></i></a>
                <input type="number" step="1" class="span1 text-center form-control height35 " name="patient" id="patient"
                    value="0" readonly>
                <a id="patient_m" class="btn btn-default btn-large  radius-right"><i class="icon-minus"></i></a>

                <!------- fin error message --------->
            </div>
        </div>
         
        <div class="form-actions saveVisite">
                <input type="submit" value="Enregistrer" class="btn btn-success btn-large " >
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        if($('#visiteID').val()>0){
            $('.saveVisite').hide();
            $('.patient').hide();
        }

    $('#patient_p').bind('touchstart', select);
    $('#patient_p').bind('touchend', unselect);

    $('#patient_m').bind('touchstart', select_m);
    $('#patient_m').bind('touchend', unselect_m);

    function select(){
        status = true;
        plus();
    }

    function unselect(){
        status = false;
        plus();
    }
    
    function select_m(){
        status = true;
        moin();
    }

    function unselect_m(){
        status = false;
        moin();
    }
    
    let score = 0;
    let status = false;
    const patient_p = document.querySelector('#patient_p');
    const patient_m = document.querySelector('#patient_m');
    let interval = null;

    patient_p.addEventListener('mousedown', e => {
        status = true;
        plus();
    });

    patient_p.addEventListener('mouseup', e => {
        status = false;
        plus();
    });

    patient_m.addEventListener('mousedown', e => {
        status = true;
        moin();
    });

    patient_m.addEventListener('mouseup', e => {
        status = false;
        moin();
    });

    const plus = () => {
        if (status) {
            interval = setInterval(() => {
            $("#patient").val( parseInt($("#patient").val()) + 1);
            }, 100);    
        } else {
            if (interval) clearInterval(interval);
        }
    
    }

    const moin = () => {
        if (status) {
            interval = setInterval(() => {
                if($("#patient").val()>0){
                    $("#patient").val(parseInt($("#patient").val()) - 1);
                }
            }, 100);    
        } else {
            if (interval) clearInterval(interval);
        }
    
    }

        $("#patient_p").mousedown( function(){

            $("#patient").val( parseInt($("#patient").val()) + 1);
         

        });

        $("#patient_m").click( function(){

            if($("#patient").val()>0){

                $("#patient").val(parseInt($("#patient").val()) - 1);

            }

    
        });
  
  

        if ($("#visite_fin").val() == 1) {

            if ($("#demande").val()==0){
                $(".h_demande").addClass("widget-title-orange");
            }else{
                $(".h_demande").addClass("widget-title-green");
            }

            if ($("#h_product").val()==0){
                $(".h_product").addClass("widget-title-orange");
            }else{
                $(".h_product").addClass("widget-title-green");
            }

        }
    
    });
</script>
