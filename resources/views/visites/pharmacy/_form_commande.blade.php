<div class="widget-box">
    <div class="widget-title commande"> <span class="icon"> <i class="icon-credit-card"></i> </span>
        <h5 class="commande">COMMANDE</h5>
    </div>
    <div class="widget-content nopadding">

        <div class="control-group">
            <label class="control-label">Commande</label>
            <div class="controls">
                <label style="display: inline;margin-right: 15px;">
                    <input type="hidden" id="commande" value="{{($commande) ? 1:0}}">

                    <a id="commande_oui" class="btn btn-default btn-large mr-3">OUI</a>
                    <a id="commande_non" class="btn btn-danger btn-large  mr-3">NON</a>

            </div>
        </div>

        <!------------------ fin champs 4 ------------------>

        <div id="deatil_commande" class=" hide ">
            <!------------------ champs 4.1 ------------------>
            <div class="control-group">
                <label class="control-label">Pack</label>
                <div class="controls">
                    <input type="hidden" id="pack" value="{{($commande) ? $commande->pack:0}}">

                    <a id="pack_oui" class="btn btn-default btn-large mr-3">OUI</a>
                    <a id="pack_non" class="btn btn-danger btn-large  mr-3">NON</a>
                </div>
            </div>
            <!------------------ champs 4.1 ------------------>
            <div class="control-group">
                <label for="command_type" class="control-label ">Type COMMANDE</label>
                <div class="controls">

                    <input type="hidden" id="commande_ug" value="{{($commande) ? $commande->ug:1}}">
                    <input type="hidden" id="commande_remise" value="{{($commande) ? $commande->remise:0}}">

                    <a id="cmd_ug" class="btn btn-large btn-success mr-3">Ug</a>
                    <a id="cmd_remise" class="btn btn-default btn-large  mr-3">Remise</a>
                </div>
            </div>
            <div class="control-group">
                <label for="montant_cmd" class="control-label">Mode de paiement</label>
                <div class="controls"> 
                    <div id="mode" class="mode-paiement"></div>

                </div>
            </div>
        </div>

        <!------------------ fin champs 4.1.1 ------------------>
        <!------------------ fin champs 4.1 ------------------>
        <div class="form-actions">
            <a class="btn btn-success btn-large saveCommande hide ">Enregistrer</a>
            <a class="btn btn-primary btn-large pull-right duo">Etape suivante</a>

        </div>
    </div>
</div>
<script src="{{ asset('layout/js/matrix.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var show_duo = 0;
        if ($("#motif").val() == "") {
            $("#mode").hide().html("Chèque 'selon le montant'").fadeIn(100);
        } else if($("#motif").val() == 'Cheque en Cours : 1') {
            $("#mode").hide().html("Chèque 'selon le montant'  (NB: " + $("#motif").val() + ")").fadeIn(100);
        }else{
            $("#mode").hide().html("Virement ('" + $("#motif").val() + "')").fadeIn(100);
        }
    
        $('.saveCommande').click(function(e) {

            e.preventDefault();
            var visiteId = $("#visiteID").val();
            var commande = $("#commande").val();
            var pack = $("#pack").val();
            var commande_ug = $("#commande_ug").val();
            var commande_remise = $("#commande_remise").val();

            $('#commande_oui').addClass("disable-click");
            $('#commande_non').addClass("disable-click");
            $('#pack_oui').addClass("disable-click");
            $('#pack_non').addClass("disable-click");
            $('#cmd_ug').addClass("disable-click");
            $('#cmd_remise').addClass("disable-click");
            $(this).hide();

            $.ajax({
                type: 'POST',
                url: "{{ route('visites.commandeStore.pharmacy') }}",
                data: {
                    visiteId: visiteId,
                    commande: commande,
                    pack: pack,
                    commande_ug: commande_ug,
                    commande_remise: commande_remise
                },
                success: function(data) {
                    $("#displayDuo").hide().html(data).fadeIn(100);
                }
            });
        });

        $('.duo').click(function(e) {
            show_duo++;
            $(this).hide(500);
            var visiteId = $("#visiteID").val();
            $("#visiteStep").val(4);
            var url = "{{route('visites.duo.pharmacy', [":id"])}}";
                url = url.replace(':id', visiteId);
            $.ajax({
                type: 'GET',
                url:url,
                success: function(data) {
                    $("#displayDuo").hide().html(data).fadeIn(100);
                }
            });
        });

        
    
        // commande 

        if( $("#commande").val() == 1) {
            $('#commande_oui').addClass("disable-click");
            $('#commande_non').addClass("disable-click");
            $('#pack_oui').addClass("disable-click");
            $('#pack_non').addClass("disable-click");
            $('#cmd_ug').addClass("disable-click");
            $('#cmd_remise').addClass("disable-click");
           

            $("#commande_oui").addClass("btn-success");
            $("#commande_non").removeClass("btn-danger");
            $("#commande_non").addClass("btn-default");
            $("#deatil_commande").show(1000);
            $(".saveCommande").show(500);
            $(".duo").hide(500);
        }else{
            $("#commande_non").addClass("btn-danger");
            $("#commande_oui").removeClass("btn-success");
            $("#commande_oui").addClass("btn-default");
            $("#deatil_commande").hide(1000);
            
            $(".saveCommande").hide(500);
            if(show_duo==0){
                $(".duo").show(500);
            }
        }

        if( $("#pack").val() == 1) {
            $("#pack_oui").addClass("btn-success");
            $("#pack_non").removeClass("btn-danger");
            $("#pack_non").addClass("btn-default");
        }else{
            $("#pack_non").addClass("btn-danger");
            $("#pack_oui").removeClass("btn-success");
            $("#pack_oui").addClass("btn-default");
        }

        if($("#commande_remise").val()==1){
            $("#cmd_ug").removeClass("btn-success");
            $("#cmd_ug").addClass("btn-default");
            
            $("#cmd_remise").addClass("btn-success");
            $("#cmd_remise").removeClass("btn-default");
                   
        }else{
            $("#cmd_ug").addClass("btn-success");
            $("#cmd_ug").removeClass("btn-default");
            
            $("#cmd_remise").removeClass("btn-success");
            $("#cmd_remise").addClass("btn-default");
        }

        if($("#commande_ug").val()==1){
            $("#cmd_remise").removeClass("btn-success");
            $("#cmd_remise").addClass("btn-default");
            
            $("#cmd_ug").addClass("btn-success");
            $("#cmd_ug").removeClass("btn-default");
            
        }else{
            $("#cmd_remise").addClass("btn-success");
            $("#cmd_remise").removeClass("btn-default");
            
            $("#cmd_ug").removeClass("btn-success");
            $("#cmd_ug").addClass("btn-default");
            
        }



        $("#commande_oui").click( function(){
            $(this).addClass("btn-success");
            $("#commande_non").removeClass("btn-danger");
            $("#commande_non").addClass("btn-default");
            $("#deatil_commande").show(1000);
            $("#commande").val(1);
            $(".saveCommande").show(500);
            $(".duo").hide(500);
        });

        $("#commande_non").click( function(){
            $(this).addClass("btn-danger");
            $("#commande_oui").removeClass("btn-success");
            $("#commande_oui").addClass("btn-default");
            $("#deatil_commande").hide(1000);
            $("#commande").val(0);
            $(".saveCommande").hide(500);
            if(show_duo==0 && $("#visiteStep").val() == 3){
                $(".duo").show(500);
            }
        });

            // pack oui/non
        $("#pack_oui").click( function(){
            $(this).addClass("btn-success");
            $("#pack_non").removeClass("btn-danger");
            $("#pack_non").addClass("btn-default");
            $("#pack").val(1);
        });

        $("#pack_non").click( function(){
            $(this).addClass("btn-danger");
            $("#pack_oui").removeClass("btn-success");
            $("#pack_oui").addClass("btn-default");
            $("#pack").val(0);
        });

        // checkbox eg/ remise
        $("#cmd_ug").click( function(){
            if($("#commande_ug").val()==1){
                $(this).removeClass("btn-success");
                $(this).addClass("btn-default");
                $("#commande_ug").val(0);
                $("#cmd_remise").addClass("btn-success");
                $("#cmd_remise").removeClass("btn-default");
                $("#commande_remise").val(1);
            }else{
                $(this).addClass("btn-success");
                $(this).removeClass("btn-default");
                $("#commande_ug").val(1);
                $("#cmd_remise").removeClass("btn-success");
                $("#cmd_remise").addClass("btn-default");
                $("#commande_remise").val(0);
            }
        
        
        });

        $("#cmd_remise").click( function(){
            if($("#commande_remise").val()==1){
                $(this).removeClass("btn-success");
                $(this).addClass("btn-default");
                $("#commande_remise").val(0);
                $("#cmd_ug").addClass("btn-success");
                $("#cmd_ug").removeClass("btn-default");
                $("#commande_ug").val(1);
            }else{
                $(this).addClass("btn-success");
                $(this).removeClass("btn-default");
                $("#commande_remise").val(1);
                $("#cmd_ug").removeClass("btn-success");
                $("#cmd_ug").addClass("btn-default");
                $("#commande_ug").val(0);
            }
        
        });
        
        if ($("#visiteStep").val() >= 4) {
            $(".saveCommande").hide();
            $(".duo").hide();

            var visiteId = $("#visiteID").val();            
            var url = "{{route('visites.duo.pharmacy', [":id"])}}";
                url = url.replace(':id', visiteId);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    $("#displayDuo").hide().html(data).fadeIn(100);
                }
            });
        }


        if ($("#visite_fin").val() == 1) {

            $('#commande_oui').addClass("disable-click");
            $('#commande_non').addClass("disable-click");
            if ($('#commande').val()==0){
                $(".commande").addClass("widget-title-orange");
            }else{
                $(".commande").addClass("widget-title-green");
            }

            }
    });
</script>
