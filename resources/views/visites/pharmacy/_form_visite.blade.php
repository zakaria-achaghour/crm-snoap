
<div class="widget-box">
    <div class="widget-title {{isset($visite)?'widget-title-green':''}}"> <span class="icon"> <i class="icon-beaker"></i> </span>
        <h5 class="{{isset($visite)?'widget-title-green':''}}">{{ strtoupper($client->nom) }}</h5>
    </div>
    <div class="widget-content nopadding">
<!------------------ champs 1 ------------------>
        <input type="hidden" name="visiteStep" id="visiteStep" value="{{isset($visite)?$visite->step:''}}">
        <input type="hidden" name="visiteID" id="visiteID" value="{{isset($visite)?$visite->id:''  }}">
        <input type="hidden" name="visite_fin" id="visite_fin" value="{{isset($visite)?$visite->fin:0  }}">
        
        <input type="hidden" name="clientId" id="client_id" value="{{$client->id}}">
        <input type="hidden" name="motif" id="motif" value="{{$client->motif}}">
      
        @if(isset($planning))
            <input type="hidden" name="planning_id" value="{{$planning}}">
        @endif

        <input type="hidden" id="doctorId" value="{{isset($doctor_id)?$doctor_id:'0'}}">
        <input type="hidden" id="nbOrdonanceDoc" value="{{isset($nbOrdonanceDoc)?$nbOrdonanceDoc:'null'}}">


        <!------------------ champs 2 ------------------>
        <div class="control-group  {{isset($visite)?'hide':''}}" id="type_visite">
            <label for="visite_type" class="control-label ">Type de visite </label>
            <div class="controls ">

                <input type="hidden" name="type_vd" id="t_vd" value="{{isset($visite)?$visite->type_VD:0}}" >
                <input type="hidden" name="type_enq_ref" id="t_enq_ref" value="{{isset($visite)?$visite->type_enq_ref:0}}" >
                <input type="hidden" name="type_enq_rp" id="t_enq_rp" value="{{isset($visite)?$visite->type_enq_rp:0}}" >
                <input type="text" class="span8 form-control " value="" name="typeVisite" id="typeVisite" disabled>

            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <a id="vd" class="btn btn-default btn-large mr-3 {{isset($visite)?'disable-click':''}}" >VD</a>
                <a id="enq_ref" class="btn btn-default btn-large  mr-3 {{isset($visite)?'disable-click':''}}">Enquette FREQ</a>
               @cannot('delegue', Auth::user())
               <a id="enq_rp" class="btn btn-default btn-large  mr-3 {{isset($visite)?'disable-click':''}}"> Enquette RP</a>
               @endcannot 
            </div>
        </div>

        <div class="control-group selectmMedecin hide ">
            <label for="medecin" class="control-label ">Médecin</label>
            <div class="controls">
                <select class="form-control " id="medecin"
                    name="medecin">
                    <option value=""></option>

                    @for ($i = 0; $i < count($medecins); $i++)
                        <option value="{{ $medecins[$i]->id }}"  >{{ $medecins[$i]->name . ' | ' . $medecins[$i]->designation . ' | ' . $medecins[$i]->adresse  }}</option>
                    @endfor
                </select>
                <!------- error message --------->

                <!------- fin error message --------->
            </div>
        </div>
        <!------------------ fin champs 2 ------------------>
        <div class="form-actions saveVisite hide" >
            <input type="submit" value="Enregistrer" class="btn btn-success btn-large " >
        </div>

    </div>
</div>

<script>
      $(document).ready(function() {
    var vd=$("#t_vd").val();
    var ref=$("#t_enq_ref").val();
    var rp=$("#t_enq_rp").val();

   
    if ( vd== 1){
        $("#vd").addClass("btn-warning");
        $("#vd").removeClass("btn-default");
    }
    if ( ref== 1){
        $("#enq_ref").addClass("btn-warning");
        $('.selectmMedecin').show();
       
        $("#enq_ref").removeClass("btn-default");
    }
    if ( rp== 1){
        $("#enq_rp").addClass("btn-warning");
        $("#enq_rp").removeClass("btn-default");
        $('.selectmMedecin').show();
       

    }

    $("#vd").click( function(){
        text='';
        if ( vd== 0){
            text = text + '. Vente directe ';
            vd++;
            $("#t_vd").val(1);
            $(this).addClass("btn-warning");
            $(this).removeClass("btn-default");
            
        }else{
            vd--;
            $("#t_vd").val(0);
            $(this).addClass("btn-default");
            $(this).removeClass("btn-warning");
        }
        if ( ref== 1){
            text = text + '. Enquette FREQ ';
        $('.selectmMedecin').show();
          
        }
        if ( rp== 1){
            text = text + '. Enquette RP';
        $('.selectmMedecin').show();
           
        }
        

        $("#typeVisite").val(text);
        
        if(vd==1 && ref==0 && rp==0){
            
            $(".saveVisite").show();
            $('#medecin').val('');
            
        }else{
            if($('#medecin').val()==""){
                
                $(".saveVisite").hide();
            }
        }
              
    });

    $("#enq_ref").click( function(){
       
        text='';
        if ( vd== 1){
            text = text + '. Vente directe ';
        }
        if ( ref== 0){
            text = text + '. Enquette FREQ ';
            ref++;
            $("#t_enq_ref").val(1);
            $(this).addClass("btn-warning");
            $(this).removeClass("btn-default");
            $('.selectmMedecin').show();

        }else{
            ref--;
            $("#t_enq_ref").val(0);
            $(this).addClass("btn-default");
            $(this).removeClass("btn-warning");
            $('.selectmMedecin').hide();

        }
        if ( rp== 1){
            text = text + '. Enquette RP';
         $('.selectmMedecin').show();

           
        }

        $("#typeVisite").val(text);
        
        if(vd==1 && ref==0 && rp==0){
            
            $(".saveVisite").show();
            $('#medecin').val('');
            
        }else{
            if($('#medecin').val()==""){
                
                $(".saveVisite").hide();
            }
        }
        
    });

    $("#enq_rp").click( function(){


        text='';
        if ( vd== 1){
            text = text + '. Vente directe ';
        }
        if ( ref== 1){
            text = text + '. Enquette FREQ ';
         $('.selectmMedecin').show();
           
        }
        if ( rp== 0){
            text = text + '. Enquette RP';
            $("#t_enq_rp").val(1);
            rp++;
            $(this).addClass("btn-warning");
            $(this).removeClass("btn-default");
            $('.selectmMedecin').show();

        }else{
            $("#t_enq_rp").val(0);
            rp--;
            $(this).addClass("btn-default");
            $(this).removeClass("btn-warning");
            if(ref== 0){
                $('.selectmMedecin').hide();
            }

        }

        $("#typeVisite").val(text);
        
        if(vd==1 && ref==0 && rp==0){
            
            $(".saveVisite").show();
            $('#medecin').val('');

        }else{
            if($('#medecin').val()==""){
                
                $(".saveVisite").hide();
            }
        }
    });

    if($('#doctorId').val()!=0){
        $('.selectmMedecin').hide();
    }

    $('#medecin').change( function(){
        
        if($('#medecin').val()!=''){

            $(".saveVisite").show();
        }else{
            
            $(".saveVisite").hide();
        }
    });
   
});
    
</script>
