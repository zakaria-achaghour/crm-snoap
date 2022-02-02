<div class="widget-box">
    <div class="widget-title rupture"> <span class="icon"> <i class="icon-ban-circle"></i> </span>
        <h5 class="rupture">{{strtoupper('Rupture')}}</h5>
    </div>
    <div class="widget-content  nopadding">
        <div class="finDisplay">
            
            <div class="control-group " >
                <label class="control-label">Rupture</label>
                <div class="controls">

                    <a id="rupture_oui" class="btn btn-default btn-large mr-3">OUI</a>
                    <a id="rupture_non" class="btn btn-danger btn-large  mr-3">NON</a>

                </div>
            </div>
                <!------------------ champs 3 ------------------>
            <div class="control-group  hide" id="rupture_pf">
                <div class="controls">

                    <a id="rupture_mc_oui" class="btn btn-success btn-large mr-3">ARTICLE MCP</a>
                    <a id="rupture_mc_non" class="btn btn-default btn-large  mr-3">AUTRE</a>

                </div>
                <label for="porduit_fini_rupture" class="control-label ">Produit</label>
                <div class="controls">
                    <select class="form-control span6" id="porduit_fini_rupture"
                        name="porduit_fini_rupture">
                        <option value=""></option>

                        @for ($i = 0; $i < count($produits); $i++)
                            <option value="{{ $produits[$i]->id }}" >
                            {{ $produits[$i]->designation }}</option>
                        @endfor
                    </select>
                    <input type="text" class="hide span6" name="autre" id="autre" value="">

                </div>

                <div class="grossisteShow hide">

                    <h3 class=" text-center ">Grossiste</h3>
                     
                    <div id="displayMultislectG"></div>
                </div>
            </div>
            

            <div class="form-actions">

                <a class="btn btn-success btn-large hide saveRupture">Enregistrer</a>
                <a class="btn btn-primary btn-large pull-right com hide">Etape suivante</a>

            </div>
        
        </div>
        <div id="displayRuptureTable"></div>
        
   
     

    </div>
</div>


<script>
    $(document).ready(function() {

        $.ajax({
            type: 'GET',
            url:"{{ route('change.multiSelectG') }}",
            success: function(data) {
                $("#displayMultislectG").hide().html(data).fadeIn();
            }
        });
        
        var show_commande = 0;

        if($('#visiteStep').val()>2){
            $(".com").hide();
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var visiteId = $("#visiteID").val();
        var url = "{{route('visites.ruptureTable.pharmacy', [":visite"])}}";
             url = url.replace(':visite', visiteId);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $("#displayRuptureTable").hide().html(data).fadeIn(10);
            }
        });

        
        $("#porduit_fini_rupture").on("change", function () {
            //console.log($(this).val());
            if ($(this).val() != "") {
                $('.grossisteShow').show(500);
                $('.saveRupture').show(250);
            } else{
                $('.grossisteShow').hide(500);

                $('.saveRupture').hide(500);

            }
        });

        $("#rupture_mc_oui").click( function(){
            $(this).addClass("btn-success");
            $("#rupture_mc_non").removeClass("btn-danger");
            $("#rupture_mc_non").addClass("btn-default");
            $("#porduit_fini_rupture").show();
            $('.saveRupture').hide(250);
            $("#autre").val('');
            $('#autre').hide(500);
            

        });

        $("#rupture_mc_non").click( function(){
            $(this).addClass("btn-danger");
            $("#rupture_mc_oui").removeClass("btn-success");
            $("#rupture_mc_oui").addClass("btn-default");
            $("#autre").show();
            $('.saveRupture').show(250);
            $('#porduit_fini_rupture').hide(500);
            $('#porduit_fini_rupture').val(0);
            $('.grossisteShow').hide(500);
            
        });

        $("#rupture_oui").click( function(){
            $(this).addClass("btn-success");
            $("#rupture_non").removeClass("btn-danger");
            $("#rupture_non").addClass("btn-default");
            $("#rupture_pf").show();
        });

        $("#rupture_non").click( function(){
            $(this).addClass("btn-danger");
            $("#rupture_oui").removeClass("btn-success");
            $("#rupture_oui").addClass("btn-default");
            $('.saveRupture').hide(500);
            $("#rupture_pf").hide();
            $('#porduit_fini_rupture').val(0);
            $("#autre").val('');
        });

        $('.saveRupture').click(function(e) {
            e.preventDefault();

            if ($("#porduit_fini_rupture").val() == "" && ($("#rupture_mc_non").attr('class').includes('danger') && $("#autre").val()=="")) {
            alert($("#autre").val());
                
            } else {

                var grossisteId = $("#grossistes").val();

                                
                if(grossisteId==null){
                    grossisteId=0;
                }
                console.log(grossisteId);


                $.ajax({
                    type: 'GET',
                    url:"{{ route('change.multiSelectG') }}",
                    success: function(data) {
                            $("#displayMultislectG").hide().html(data).fadeIn();
                    }
                });

                var product_id = $("#porduit_fini_rupture").val();
                var product = $("#autre").val();
                var autre = 0;
                if (product !=''){
                    autre = 1;
                }else{
                    $("#porduit_fini_rupture option:selected").remove();
                    $("#porduit_fini_rupture option:first").attr('selected', 'selected');

                }

                $("#rupture_mc_oui").removeClass("btn-default");
                $("#rupture_mc_oui").addClass("btn-success");
                $("#rupture_mc_non").removeClass("btn-danger");
                $("#rupture_mc_non").addClass("btn-default");
                $('#porduit_fini_rupture').val(0);
                $("#porduit_fini_rupture").show();
                $("#autre").val('');
                $('#autre').hide(500);
             
                $("#rupture_non").addClass("btn-danger");
                $("#rupture_oui").removeClass("btn-success");
                $("#rupture_oui").addClass("btn-default");
                $('.saveRupture').hide(500);
                $("#rupture_pf").hide();

                $('.saveRupture').hide(500);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('visites.product.rupture') }}",
                    data: {
                        visiteId: visiteId,
                        product_id: product_id,
                        product: product,
                        grossisteId:grossisteId,
                        autre: autre
                    },
                    success: function(data) {
                        $("#displayRuptureTable").hide().html(data).fadeIn(100);
                        
                    }
                });
            }

        });

        $('.com').click(function(e) {
            //  $('.deletebtn').click(function(e) {

            e.preventDefault();
            $(this).hide();

            $("#visiteStep").val(3);

            var url = "{{route('visites.commande.pharmacy', [":visite"])}}";
             url = url.replace(':visite', visiteId);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(r) {
                    $("#displayCommande").hide().html(r).fadeIn(100);

                }
            });

        });

    
        if ($("#visiteStep").val() >= 3) {
            var url = "{{route('visites.commande.pharmacy', [":visite"])}}";
             url = url.replace(':visite', visiteId);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(r) {
                    $("#displayCommande").hide().html(r).fadeIn(10);

                }
            });

        }else{

            $(".com").show();

        }
        
        if ($("#visite_fin").val() == 1) {

                $(".finDisplay").hide();

       }
    });
</script>
