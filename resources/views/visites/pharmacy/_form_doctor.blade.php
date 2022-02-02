<div class="widget-box">

    <div class="widget-title ordonance"> <span class="icon"> <i class="icon-user-md"></i> </span>
        <h5 class="ordonance">{{ strtoupper($doctor->name) }}</h5>

    </div>
    <div class="widget-content  nopadding">

       
            <div class="control-group  ">
                <!------------------ champs 3.1.1 ------------------>
                <label for="nb_ordanance" class="control-label">Nb Ordonnance / mois</label>
                
                <div class="controls showOrdonanceCalc">
                    <a id="ord_p" class="btn btn-default btn-large radius-left"><i
                    class="icon-plus"></i></a>
                    <input type="number" step="1" class="span1 text-center form-control height34 "
                    name="nb_ordanance" id="nb_ordanance" value="0" disabled>
                    <a id="ord_m" class="btn btn-default btn-large  radius-right"><i
                    class="icon-minus"></i></a>
                    
                    <!------- fin error message --------->
                </div>

                <div class="controls showOrdonanceText hide">
                    <input type="text" disabled name="ordonanceValue"/>
                </div>
              
            </div>
        
      

            <div class="form-actions">

                <a class="btn btn-success btn-large hide saveNombreOrdonance">Enregistrer</a>
            </div>

        </div>
       
    </div>
</div>



<div class="widget-box hide prodcutShowUp">

    <div class="widget-title doctor"> <span class="icon"> <i class="icon-inbox"></i> </span>
        <h5 class="doctor">{{strtoupper('Sortie medecin')}}</h5>

    </div>
    <div class="widget-content  nopadding">
        
        <div class="finDisplay">
            <div class="addpf">

                <div class="control-group">
                    <label for="porduit_fini_doctor" class="control-label ">Produit (sortie médecin)</label>
                    <div class="controls">
                        <select class="form-control span6" id="porduit_fini_doctor" name="porduit_fini_doctor">
                            <option value=""></option>

                            @for ($i = 0; $i < count($produits); $i++)
                                <option value="{{ $produits[$i]->id }}"
                                    class="{{ $produits[$i]->qte != null ? 'background_vert' : '' }}">
                                    {{ $produits[$i]->designation }}
                                    {{ $produits[$i]->qte != null ? '  ==> ' . $produits[$i]->qte : '' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
           
                <div class="control-group hide " id="pf_prescription">
                    <label class="control-label">Sortie</label>
                    <div class="controls">
                        
                        <input type="hidden" id="pfMsp" value="0">
                        
                        <a id="prescription_oui" class="btn btn-default btn-large mr-3">OUI</a>
                        <a id="prescription_non" class="btn btn-danger btn-large  mr-3">NON</a>
                        
                    </div>
                </div>
                
                <div class="control-group hide " id="pf_qte_prescrite">
                    <!------------------ champs 3.1.1 ------------------>
                    <label for="qte_prescription" class="control-label">Sorties par mois</label>
                    <div class="controls">
                        <a id="prescription_p" class="btn btn-default btn-large radius-left"><i
                        class="icon-plus"></i></a>
                        <input type="number" step="1" class="span1 text-center form-control height34 "
                        name="qte_prescription" id="qte_prescription" value="0" disabled>
                        <a id="prescription_m" class="btn btn-default btn-large  radius-right"><i
                        class="icon-minus"></i></a>
                        
                        <!------- fin error message --------->
                    </div>
                  
                </div>
                <!------------------ fin champs 3.1.1 ------------------>
                <!------------------ fin champs 3.1 ------------------>
            </div>

            <div class="form-actions">

                <a class="btn btn-success btn-large hide saveProductDoctor">Enregistrer</a>
                <a class="btn btn-primary btn-large pull-right mep hide">Etape suivante</a>

            </div>

        </div>
        <div id="displayProductDoctorTable"></div>




    </div>
</div>
<script>
    // ordonance 
    $('#ord_p').bind('touchstart', select);
    $('#ord_p').bind('touchend', unselect);

    $('#ord_m').bind('touchstart', select_m);
    $('#ord_m').bind('touchend', unselect_m);

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
    const ord_p = document.querySelector('#ord_p');
    const ord_m = document.querySelector('#ord_m');
    let interval = null;

    ord_p.addEventListener('mousedown', e => {
        status = true;
        plus();
    });

    ord_p.addEventListener('mouseup', e => {
        status = false;
        plus();
    });

    ord_m.addEventListener('mousedown', e => {
        status = true;
        moin();
    });

    ord_m.addEventListener('mouseup', e => {
        status = false;
        moin();
    });

    const plus = () => {
        if (status) {
            interval = setInterval(() => {
            $("#nb_ordanance").val( parseInt($("#nb_ordanance").val()) + 1);
            }, 100);    
        } else {
            if (interval) clearInterval(interval);
        }
    
    }

    const moin = () => {
        if (status) {
            interval = setInterval(() => {
                if($("#nb_ordanance").val()>0){
                    $("#nb_ordanance").val(parseInt($("#nb_ordanance").val()) - 1);
                }
            }, 100);    
        } else {
            if (interval) clearInterval(interval);
        }
    
    }

        $("#ord_p").mousedown( function(){

            $("#nb_ordanance").val( parseInt($("#nb_ordanance").val()) + 1);
            if($("#nb_ordanance").val()>0){
                $('.saveNombreOrdonance').show(500);
            }else{
                $('.saveNombreOrdonance').hide(250);
            }

        });

        $("#ord_m").click( function(){

            if($("#nb_ordanance").val()>0){

                $("#nb_ordanance").val(parseInt($("#nb_ordanance").val()) - 1);

            }

            if($("#nb_ordanance").val()>0){
                $('.saveProduct').show(500);
            }else{
                $('.saveProduct').hide(250);
            }
    
        });
    

        var nbOrdonanceDoc = $('#nbOrdonanceDoc').val();
       // console.log(nbOrdonanceDoc);
        if(nbOrdonanceDoc!='null'){
            $('.prodcutShowUp').show(500);
                $('.showOrdonanceCalc').hide();
                $('.showOrdonanceText').show(500);
                $("input[name=ordonanceValue]").val(nbOrdonanceDoc);

                $('.saveNombreOrdonance').hide();
        }else{
            $('.prodcutShowUp').hide(500);
                $('.showOrdonanceCalc').show();
                $('.showOrdonanceText').hide(500);
                $("input[name=ordonanceValue]").val(0);

                $('.saveNombreOrdonance').show();
        }

    $('.saveNombreOrdonance').click(function(e) {
           
                e.preventDefault();
              
                var nbOrdonance = $("input[name=nb_ordanance]").val();
                var visiteId = $("#visiteID").val();
                var doctorId = $("#doctorId").val();
                $('.prodcutShowUp').show(500);
                $('.showOrdonanceCalc').hide();
                $('.showOrdonanceText').show(500);
                $("input[name=ordonanceValue]").val(nbOrdonance);

                $('.saveNombreOrdonance').hide();

                //alert(nbOrdonance)showOrdonanceCalc
                $.ajax({
                    type: 'POST',
                    url: "{{ route('visites.doctor.pharmacy.ordonance') }}",
                    data: {
                        visiteId: visiteId,
                        doctorId: doctorId,
                        nbOrdonance: nbOrdonance
                    },
                    success: function(data) {
                       // $("#displayProductDoctorTable").hide().html(data).fadeIn(100);
                    }
                });
            

        });
</script>

<script>
    $(document).ready(function() {

        var show_product = 0;
        var ref = $("#t_enq_ref").val();
        var rp = $("#t_enq_rp").val();

        if ($('#visiteStep').val() > 1) {
            $(".mep").hide();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // changeds
        var visiteId = $("#visiteID").val();
        var url = "{{route('visites.productDoctorTable.pharmacy', [":id"])}}";
                url = url.replace(':id', visiteId);
             
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $("#displayProductDoctorTable").hide().html(data).fadeIn(10);
            }
        });


        $("#porduit_fini_doctor").on("change", function() {
            //console.log($(this).val());
            if ($(this).val() != "" ) {
                $("#pf_prescription").fadeIn(500);
                $('.saveProductDoctor').show(250);
            } else {
                $("#pf_prescription").fadeOut(500);
                $('.saveProductDoctor').hide(250);

            }
        });

        $("#prescription_oui").click(function() {
            $(this).addClass("btn-success");
            $("#prescription_non").removeClass("btn-danger");
            $("#prescription_non").addClass("btn-default");
            $("#pf_qte_prescrite").fadeIn(1000);
            $("#pfMsp").val(1);
            $('.saveProductDoctor').hide(250);

        });

        $("#prescription_non").click(function() {
            $(this).addClass("btn-danger");
            $("#prescription_oui").removeClass("btn-success");
            $("#prescription_oui").addClass("btn-default");
            $("#pf_qte_prescrite").fadeOut(1000);
            $("input[name=qte_prescription]").val(0);
            $("#pfMsp").val(0);
            $('.saveProductDoctor').show(250);
        });

        $('.saveProductDoctor').click(function(e) {
            if ($("#porduit_fini_doctor").val() == "" ||
                ($("#pfMsp").val() == 1 && $("input[name=qte_prescription]").val() < 1)) {

            } else {
                e.preventDefault();
                var productID = $("#porduit_fini_doctor").val();
                $("#porduit_fini_doctor option:selected").remove();
                $("#porduit_fini_doctor option:first").attr('selected', 'selected');
                
                var qteProduct = $("input[name=qte_prescription]").val();
                var misenplace = $("#pfMsp").val();

                $("#pf_prescription").fadeOut(500);
                $("#pf_qte_prescrite").fadeOut(500);
                $("input[name=qte_prescription]").val(0);
                $("#pfMsp").val(0);
                $('.saveProductDoctor').hide(250);

                if (show_product == 0 && $("#visiteStep").val() == 0) {
                    $(".mep").show();
                    show_product++;
                }
                $("#prescription_oui").removeClass("btn-success");
                $("#prescription_non").addClass("btn-danger");


                $.ajax({
                    type: 'POST',
                    url: "{{ route('visites.doctor.pharmacy') }}",
                    data: {
                        visiteId: visiteId,
                        productID: productID,
                        qteProduct: qteProduct,
                        misenplace: misenplace
                    },
                    success: function(data) {
                        $("#displayProductDoctorTable").hide().html(data).fadeIn(100);
                    }
                });
            }

        });

        $('.mep').click(function(e) {
            //  $('.deletebtn').click(function(e) {

            e.preventDefault();
            $(this).hide();

            $("#visiteStep").val(1);
            var url = "{{route('visites.DisplayProduct.pharmacy', [":id"])}}";
                url = url.replace(':id', visiteId);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(r) {
                    $("#displayProduct").hide().html(r).fadeIn(100);

                }
            });

        });


        if ($("#visiteStep").val() >= 1) {
            var url = "{{route('visites.DisplayProduct.pharmacy', [":id"])}}";
                url = url.replace(':id', visiteId);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(r) {
                    $("#displayProduct").hide().html(r).fadeIn(10);

                }
            });

        }

    $('#prescription_p').bind('touchstart', select);
    $('#prescription_p').bind('touchend', unselect);

    $('#prescription_m').bind('touchstart', select_m);
    $('#prescription_m').bind('touchend', unselect_m);

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
    const prescription_p = document.querySelector('#prescription_p');
    const prescription_m = document.querySelector('#prescription_m');
    let interval = null;

    prescription_p.addEventListener('mousedown', e => {
        status = true;
        plus();
    });

    prescription_p.addEventListener('mouseup', e => {
        status = false;
        plus();
    });

    prescription_m.addEventListener('mousedown', e => {
        status = true;
        moin();
    });

    prescription_m.addEventListener('mouseup', e => {
        status = false;
        moin();
    });

    const plus = () => {
        if (status) {
            interval = setInterval(() => {
            $("#qte_prescription").val( parseInt($("#qte_prescription").val()) + 1);
            }, 100);    
        } else {
            if (interval) clearInterval(interval);
        }
    
    }

    const moin = () => {
        if (status) {
            interval = setInterval(() => {
                if($("#qte_prescription").val()>0){
                    $("#qte_prescription").val(parseInt($("#qte_prescription").val()) - 1);
                }
            }, 100);    
        } else {
            if (interval) clearInterval(interval);
        }
    
    }

        $("#prescription_p").mousedown( function(){

            $("#qte_prescription").val( parseInt($("#qte_prescription").val()) + 1);
            if($("#qte_prescription").val()>0){
                $('.saveProductDoctor').show(500);
            }else{
                $('.saveProductDoctor').hide(250);
            }

        });

        $("#prescription_m").click( function(){

            if($("#qte_prescription").val()>0){

                $("#qte_prescription").val(parseInt($("#qte_prescription").val()) - 1);

            }

            if($("#qte_prescription").val()>0){
                $('.saveProductDoctor').show(500);
            }else{
                $('.saveProductDoctor').hide(250);
            }
    
        });

        if ($("#visite_fin").val() == 1) {

            $(".finDisplay").hide();

        }
    });
</script>
