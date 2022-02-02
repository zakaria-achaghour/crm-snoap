<div class="widget-box">
    <div class="widget-title product"> <span class="icon"> <i class="icon-tasks"></i> </span>
        <h5 class="product">MISE EN PLACE</h5>
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
                                <option value="{{ $produits[$i]->id }}" class="{{($produits[$i]->qte!=NULL)?'background_vert':''}}">
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
                    <label class="control-label">Mise en place</label>
                    <div class="controls">

                        <input type="hidden" id="pfMsp" value="0">

                        <a id="mep_oui" class="btn btn-default btn-large mr-3">OUI</a>
                        <a id="mep_non" class="btn btn-danger btn-large  mr-3">NON</a>

                    </div>
                </div>

                <div class="control-group hide " id="pf_qte_srt">
                    <!------------------ champs 3.1.1 ------------------>
                    <label for="qte" class="control-label">Sorties par mois</label>
                    <div class="controls">
                        <a id="spm_p" class="btn btn-default btn-large radius-left"><i class="icon-plus"></i></a>
                        <input type="number" step="1" class="span1 text-center form-control height34 " name="qte" id="qte"
                            value="0" disabled>
                        <a id="spm_m" class="btn btn-default btn-large  radius-right"><i class="icon-minus"></i></a>

                        <!------- fin error message --------->
                    </div>

                    @cannot('delegue', Auth::user())
                        
                    <h3 class=" text-center ">Autre médecins</h3>
                 
                        <div id="displayMultislect">

                        </div>
                    @endcannot
                <!------------------ fin champs 3.1.1 ------------------>
                <!------------------ fin champs 3.1 ------------------>
            </div>

            <div class="form-actions">

                <a class="btn btn-success btn-large hide saveProduct">Enregistrer</a>
                <a class="btn btn-primary btn-large pull-right rupture hide">Etape suivante</a>

            </div>
        
        </div>
    
   
     

    </div>
    <div id="displayProductTable"></div>
        
</div>


<script>
    $(document).ready(function() {

      
      
        $.ajax({
            type: 'GET',
            url:"{{ route('change.multiSelect') }}",
            success: function(data) {
                $("#displayMultislect").hide().html(data).fadeIn();
            }
        });
        var show_rupture = 0;
        var ref = $("#t_enq_ref").val();
        var rp = $("#t_enq_rp").val();
        if(ref==0 && rp==0){
            $(".rupture").show();
        }

        if($('#visiteStep').val()>1){
            $(".rupture").hide();
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var visiteId = $("#visiteID").val();
        var url = "{{route('visites.productTable.pharmacy', [":visite"])}}";
             url = url.replace(':visite', visiteId);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $("#displayProductTable").hide().html(data).fadeIn(10);
            }
        });

        
        $("#porduit_fini").on("change", function () {
            //console.log($(this).val());
            if ($(this).val() != "") {
                $("#pf_msp").fadeIn(500);
                $('.saveProduct').show(250);
                $("#mep_oui").removeClass("btn-default");
                $("#mep_non").addClass("btn-danger");
                $("#mep_oui").removeClass("btn-success");
                $("#mep_oui").addClass("btn-default");
                $("#pf_qte_srt").fadeOut(1000);
                $("input[name=qte]").val(0);
                $("#pfMsp").val(0);
            } else{
                $("#pf_msp").fadeOut(500);
                $('.saveProduct').hide(500);

            }
        });

        $("#mep_oui").click( function(){
            $(this).addClass("btn-success");
            $("#mep_non").removeClass("btn-danger");
            $("#mep_non").addClass("btn-default");
            $("#pf_qte_srt").fadeIn(1000);
            $("#pfMsp").val(1);
            $('.saveProduct').hide(500);
        });

        $("#mep_non").click( function(){
            $(this).addClass("btn-danger");
            $("#mep_oui").removeClass("btn-success");
            $("#mep_oui").addClass("btn-default");
            $("#pf_qte_srt").fadeOut(1000);
            $("input[name=qte]").val(0);
            $("#pfMsp").val(0);
            $('.saveProduct').show(500);
            $(".selected-wrapper").empty();

            $.ajax({
                type: 'GET',
                url:"{{ route('change.multiSelect') }}",
                success: function(data) {
                        $("#displayMultislect").hide().html(data).fadeIn();
                }
            });

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
                var medecinsID = $("#medecin_write").val();

                
                if(medecinsID==null){
                    medecinsID=0;
                }


                $.ajax({
                    type: 'GET',
                    url:"{{ route('change.multiSelect') }}",
                    success: function(data) {
                            $("#displayMultislect").hide().html(data).fadeIn();
                    }
                });

                $("#pf_msp").fadeOut(500);
                $("#pf_qte_srt").fadeOut(500);
                $("input[name=qte]").val(0);
                $("#pfMsp").val(0);

                if (show_rupture == 0 && $("#visiteStep").val() == 1 ) {
                    $(".rupture").show();
                    show_rupture++;
                }
                $("#mep_oui").removeClass("btn-success");
                $("#mep_non").addClass("btn-danger");
                $('.saveProduct').hide(500);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('visites.product.pharmacy') }}",
                    data: {
                        visiteId: visiteId,
                        productID: productID,
                        medecinsID: medecinsID,
                        qteProduct: qteProduct,
                        misenplace: misenplace
                    },
                    success: function(data) {
                        $("#displayProductTable").hide().html(data).fadeIn(100);
                        
                    }
                });
            }

        });

        $('.rupture').click(function(e) {
            //  $('.deletebtn').click(function(e) {

            e.preventDefault();
            $(this).hide();

            $("#visiteStep").val(2);

            var url = "{{route('visites.rupture.pharmacy', [":visite"])}}";
             url = url.replace(':visite', visiteId);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(r) {
                    $("#displayRupture").hide().html(r).fadeIn(100);

                }
            });

        });

    
        if ($("#visiteStep").val() >= 2) {
            var url = "{{route('visites.rupture.pharmacy', [":visite"])}}";
             url = url.replace(':visite', visiteId);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(r) {
                    $("#displayRupture").hide().html(r).fadeIn(10);

                }
            });

        }else{

            $(".rupture").show();

        }

    
    $('#spm_p').bind('touchstart', select);
    $('#spm_p').bind('touchend', unselect);

    $('#spm_m').bind('touchstart', select_m);
    $('#spm_m').bind('touchend', unselect_m);

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
    const spm_p = document.querySelector('#spm_p');
    const spm_m = document.querySelector('#spm_m');
    let interval = null;

    spm_p.addEventListener('mousedown', e => {
        status = true;
        plus();
    });

    spm_p.addEventListener('mouseup', e => {
        status = false;
        plus();
    });

    spm_m.addEventListener('mousedown', e => {
        status = true;
        moin();
    });

    spm_m.addEventListener('mouseup', e => {
        status = false;
        moin();
    });

    const plus = () => {
        if (status) {
            interval = setInterval(() => {
            $("#qte").val( parseInt($("#qte").val()) + 1);
            }, 100);    
        } else {
            if (interval) clearInterval(interval);
        }
    
    }

    const moin = () => {
        if (status) {
            interval = setInterval(() => {
                if($("#qte").val()>0){
                    $("#qte").val(parseInt($("#qte").val()) - 1);
                }
            }, 100);    
        } else {
            if (interval) clearInterval(interval);
        }
    
    }

        $("#spm_p").mousedown( function(){

            $("#qte").val( parseInt($("#qte").val()) + 1);
            if($("#qte").val()>0){
                $('.saveProduct').show(500);
            }else{
                $('.saveProduct').hide(250);
            }

        });

        $("#spm_m").click( function(){

            if($("#qte").val()>0){

                $("#qte").val(parseInt($("#qte").val()) - 1);

            }

            if($("#qte").val()>0){
                $('.saveProduct').show(500);
            }else{
                $('.saveProduct').hide(250);
            }
    
        });
        if ($("#visite_fin").val() == 1) {

                $(".finDisplay").hide();

       }
    });
</script>
