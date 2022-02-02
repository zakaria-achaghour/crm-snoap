<div class="widget-box">
    <div class="widget-title product"> <span class="icon"> <i class="icon-tasks"></i> </span>
        <h5 class="product">PRESCRIPTION</h5>
    </div>
    <div class="widget-content  nopadding">
        <div class="finDisplay">
            <div class="addpf">
                <!------------------ champs 3 ------------------>
                <div class="control-group">
                    <label for="porduit_fini" class="control-label ">Produit</label>
                    <div class="controls">
                        <select class="form-control span6" id="porduit_fini"
                            name="porduit_fini">
                            <option value=""></option>

                            @for ($i = 0; $i < count($produits); $i++)
                                <option value="{{ $produits[$i]->id }}" class="{{( $produits[$i]->created_at!=null )?'background_vert':(($produits[$i]->qte!=null )?'background_orange' :'')}}" >
                                {{ $produits[$i]->designation }} {{($produits[$i]->qte!=NULL)?'  ==> '.$produits[$i]->qte:''}}</option>
                            @endfor
                        </select>
                        <!------- error message --------->

                        <!------- fin error message --------->
                    </div>
                </div>
                <!------------------ fin champs 3 ------------------>

                <!------------------ champs 3.1 ------------------>
                <div class="control-group hide " id="pf_msp">
                    <label class="control-label">Prescription</label>
                    <div class="controls">

                        <input type="hidden" id="pfMsp" value="0">

                        <a id="mep_oui" class="btn btn-default btn-large mr-3">OUI</a>
                        <a id="mep_non" class="btn btn-danger btn-large  mr-3">NON</a>

                    </div>
                </div>

             

                <div class="control-group hide" id="pf_qte_srt">
                    <div class="controls">
                        <a id="qte10" class="btn btn-default btn-large mr-3 " >10</a>
                        <a id="qte5" class="btn btn-default btn-large  mr-3">5</a>
                        <a id="qte1" class="btn btn-default btn-large  mr-3 "> 1</a>
                        <input type="hidden"  name="qte" id="qte" value="0">
                    </div>
                </div>
                <!------------------ fin champs 3.1.1 ------------------>
                <!------------------ fin champs 3.1 ------------------>
            </div>

            <div class="form-actions">

                <a class="btn btn-success btn-large hide saveProduct">Enregistrer</a>
                <a class="btn btn-primary btn-large pull-right duo hide">Etape suivante</a>

            </div>
        
        </div>
        <div id="displayProductTable"></div>
        
   
     

    </div>
</div>


<script>
    $(document).ready(function() {

      
        var show_duo = 0;
        var count_oui = 0;
     

        if($('#visiteStep').val()>1){
            $(".duo").hide();
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var visiteId = $("#visiteID").val();
         var url = "{{route('visites.productTable.doctor', ":id")}}";
            url = url.replace(':id', visiteId);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $("#displayProductTable").hide().html(data).fadeIn(100);
            }
        });

        
        $("#porduit_fini").on("change", function () {
            //console.log($(this).val());
            if ($(this).val() != "") {
                $("#pf_msp").fadeIn(500);
                $(".saveProduct").show(500);
                
            } else{
                $("#pf_msp").fadeOut(500);
                $(".saveProduct").hide(500);

            }
        });

        $("#mep_oui").click( function(){
            if(count_oui==0){
                $(this).addClass("btn-success");
                $("#mep_non").removeClass("btn-danger");
                $("#mep_non").addClass("btn-default");
                $("#pf_qte_srt").fadeIn(1000);
                $("#pfMsp").val(1);
                $(".saveProduct").hide(250);
                count_oui++;
            }           
        });

        $("#mep_non").click( function(){
            $(this).addClass("btn-danger");
            $("#mep_oui").removeClass("btn-success");
            $("#mep_oui").addClass("btn-default");
            $("#pf_qte_srt").fadeOut(1000);
            $("input[name=qte]").val(0);
            $("#pfMsp").val(0);
            $('#qte10').removeClass("btn-warning");
            $('#qte10').addClass("btn-default");
            $('#qte5').removeClass("btn-warning");
            $('#qte5').addClass("btn-default");
            $('#qte1').removeClass("btn-warning");
            $('#qte1').addClass("btn-default");
            count_oui=0;
        });

        $('.saveProduct').click(function(e) {
            if ($("#porduit_fini").val() == "" || ($("#pfMsp").val()==1 && $("input[name=qte]").val()<1)) {
            } else {

                e.preventDefault();
                var productID = $("#porduit_fini").val();
                $("#porduit_fini option:selected").remove();
                $("#porduit_fini option:first").attr('selected', 'selected');
                var qteProduct = $("input[name=qte]").val();
                var misenplace = $("#pfMsp").val();
                count_oui = 0;
             
                $("#pf_msp").fadeOut(500);
                $("#pf_qte_srt").fadeOut(500);
                $("#qte").val(0);
                $(".saveProduct").hide(250);
                
                $("#pfMsp").val(0);
                $('#qte10').removeClass("btn-warning");
                $('#qte10').addClass("btn-default");
                $('#qte5').removeClass("btn-warning");
                $('#qte5').addClass("btn-default");
                $('#qte1').removeClass("btn-warning");
                $('#qte1').addClass("btn-default");
                if (show_duo == 0 && $("#visiteStep").val() == 1 ) {
                    $(".duo").show();
                    show_duo++;
                }
                $("#mep_oui").removeClass("btn-success");
                $("#mep_oui").addClass("btn-default");
                $("#mep_non").removeClass("btn-default");
                $("#mep_non").addClass("btn-danger");

                $.ajax({
                    type: 'POST',
                    url: "{{ route('visites.product.doctor') }}",
                    data: {
                        visiteId: visiteId,
                        productID: productID,
                        qteProduct: qteProduct,
                        misenplace: misenplace
                    },
                    success: function(data) {
                        $("#displayProductTable").hide().html(data).fadeIn(100);
                        
                    }
                });
            }

        });

        $('.duo').click(function(e) {
            //  $('.deletebtn').click(function(e) {

             e.preventDefault();
             $(this).hide();

            
             $("#visiteStep").val(2);
            

             var url = "{{route('visites.duo.doctor', ":id")}}";
             url = url.replace(':id', visiteId);
        
             $.ajax({
                type: 'GET',
                    url: url,
                success: function(data) {
                    $("#displayDuo").hide().html(data).fadeIn(100);
                }
            });
           

        });

    
        if ($("#visiteStep").val() >= 2) {
            
            $(".duo").hide();
            var from = $("#from").val();
            var url = "{{route('visites.duo.doctor', ":id")}}";
             url = url.replace(':id', visiteId);
            $.ajax({
                type: 'GET',
                    url: url,
                success: function(data) {
                    $("#displayDuo").hide().html(data).fadeIn(100);
                }
            });

        }else{

            $(".duo").show();

        }

        $("#qte10").click( function(){
            $(this).addClass("btn-warning");
            $(this).removeClass("btn-default");
            $("#qte").val(10);
            $('#qte5').removeClass("btn-warning");
            $('#qte5').addClass("btn-default");
            $('#qte1').removeClass("btn-warning");
            $('#qte1').addClass("btn-default");
            $(".saveProduct").show(500);
        
        });

        $("#qte5").click( function(){
            $(this).addClass("btn-warning");
            $(this).removeClass("btn-default");
            $("#qte").val(5);
            $('#qte10').removeClass("btn-warning");
            $('#qte10').addClass("btn-default");
            $('#qte1').removeClass("btn-warning");
            $('#qte1').addClass("btn-default");
            $(".saveProduct").show(500);

        });

        $("#qte1").click( function(){
            $(this).addClass("btn-warning");
            $(this).removeClass("btn-default");
            $("#qte").val(1);
            $('#qte10').removeClass("btn-warning");
            $('#qte10').addClass("btn-default");
             $('#qte5').removeClass("btn-warning");
            $('#qte5').addClass("btn-default");
            $(".saveProduct").show(500);
       
        });

        if ($("#visite_fin").val() == 1) {

            $(".finDisplay").hide();

       }
    });
</script>
