<div class="widget-box">
    <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
        <h5> Les Produits Concerné</h5>
    </div>
    <div class="widget-content ">

        <div class="productsSelect">

        <div class="control-group">
            <label for="product" class="control-label ">Produit</label>
            <div class="controls">
                <select class="form-control span6" id="product" name="product">
                    <option value=""></option>
                    @for ($i = 0; $i < count($products); $i++)
                        <option value="{{ $products[$i]->id }}">{{ $products[$i]->designation }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="control-group pf_qte">
            <!------------------ champs 3.1.1 ------------------>
            <label for="qte" class="control-label">Qte</label>
            <div class="controls">
                <a id="spm_p" class="btn btn-default btn-large radius-left"><i class="icon-plus"></i></a>
                <input type="number" step="1" class="span1 text-center form-control height34 " name="qte" id="qte"
                    value="0" disabled>
                <a id="spm_m" class="btn btn-default btn-large  radius-right"><i class="icon-minus"></i></a>

                <!------- fin error message --------->
            </div>
        <!------------------ fin champs 3.1 ------------------>
    </div>

    <div class="form-actions">

        <a class="btn btn-success btn-large hide saveProduct">Enregistrer</a>
        <a class="btn btn-primary btn-large pull-right fin  hide">Fin</a>

    </div>
    </div>

    <div id="displayProductTable"></div>



    </div>
</div>
<script>
    $(document).ready(function() {
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var adv = $('#adv').val();


        $.ajax({
            type: 'GET',
            url: '/advs/table/products/' + adv,
            success: function(data) {
                $("#displayProductTable").hide().html(data).fadeIn(10);
            }
        });
      
        
    $('.saveProduct').click(function(e) {
            if ($("#product").val() == ""  && $("input[name=qte]").val()<1) {
            } else {

                e.preventDefault();
                var productID = $("#product").val();
                $("#product option:selected").remove();
                $("#product option:first").attr('selected', 'selected');
                var qteProduct = $("input[name=qte]").val();
                $("input[name=qte]").val(0);
                $('.saveProduct').hide(500);
                $('.fin').show();
            
                $.ajax({
                    type: 'POST',
                    url: "{{ route('advs.affecterProductsAdv') }}",
                    data: {
                        adv: adv,
                        productID: productID,
                        qteProduct: qteProduct
                    },
                    success: function(data) {
                        $("#displayProductTable").hide().html(data).fadeIn(100);
                        
                    }
                });
            }

        });

        $('.fin').click(function(e) {
            e.preventDefault();
            swal.fire({
                title: "Confirmation!!",
                icon: 'question',
                text: "Êtes-vous sûr de vouloir créer cette Dépense? ",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui",
                cancelButtonText: "Non"
            })
            .then((willDelete) => {
                if (willDelete.value === true) {
                   
                    $.ajax({
                        type: "get",
                        url: '/advs/fin/' + adv,
                        success: function(response) {
                            swal.fire("Dépense créée avec succès!", response.status, "success")
                                .then((result) => {
                                    window.location.href ='/adv/cree';
                                });
                        }
                    });
                }
            });
        });

     $("#spm_p").click( function(){

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
        });
        
        
    </script>
    