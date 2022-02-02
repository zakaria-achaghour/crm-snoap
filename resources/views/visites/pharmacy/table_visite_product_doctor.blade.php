@if(count($products)>0)
    <div class="container-fluid">
        <hr>

        <!------------------------------- fin message de formation ------------------------------->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th class='delete_fin'>Supprimer</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                               
                     
                            @foreach ($products as $product)
                            <tr>
                                <td class="table-action">{{ $product->designation }}</td>
                                <td class="table-action">{{ $product->qte?$product->qte:0 }}</td>
                                <td class="table-action delete_fin ">
                                    <input type="hidden" class="product_designation_doctor" value="{{ $product->designation }}">
                                    <input type="hidden" class="product_id_doctor" value="{{ $product->product_id }}">
                                    <input type="hidden" class="visite_product_id_doctor" value="{{ $product->id }}">
                                    <a class="btn btn-danger tip deletebtn_doctor"><i class="icon-trash"></i></a>

                                </td>
                            </tr>

                            @endforeach
                                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      
    </div>
@else
    <input type="hidden" id="count_product_doctor" value="0">
@endif
    <script>
        
        $(document).ready(function() {
        $('.deletebtn_doctor').click(function(e) {
            
            e.preventDefault();
            var delete_id = $(this).closest("td").find('.visite_product_id_doctor').val();
            var product_id = $(this).closest("td").find('.product_id_doctor').val();
            var product_designation = $(this).closest("td").find('.product_designation_doctor').val();
        //    alert(delete_id +'------'+ product_designation);
            swal.fire({
                    title: "Êtes-vous sûr?",
                    icon: 'question',
                    text: "Une fois supprimées, vous ne pourrez plus récupérer ces données! ",
                    showCancelButton: !0,
                    confirmButtonText: "Oui, supprimer",
                    cancelButtonText: "Non, annuler"
                })
                .then((willDelete) => {
                    if (willDelete.value === true) {
                        $("#porduit_fini_doctor").append("<option value='" + product_id + "'>" + product_designation + "</option>");
                    
                        var url = "{{route('visites.productDoctorDestroy.pharmacy', ":id")}}";
                         url = url.replace(':id', delete_id);
                        $.ajax({
                            type: "GET",
                            //url:  '/visites/pharmacy/product/doctor/'+delete_id,
                            url: url,
                            success: function(response) {
                                

                                swal.fire("Fait!", response.status, "success")
                                    .then((result) => {
                                        $("#displayProductDoctorTable").hide().html(response).fadeIn(100);

                                    });
                            }
                        });
                    }
                });
        });

        if ($("#count_product_doctor").val()==0){
            $(".mep").hide();
            show_product=0;
        }

        if ($("#visite_fin").val() == 1) {

            $(".delete_fin").hide();
            if ($("#count_product_doctor").val()==0){
                $(".doctor").addClass("widget-title-orange");
            }else{
                $(".doctor").addClass("widget-title-green");
            }
            if ($('#nbOrdonanceDoc').val()==0){
                $(".ordonance").addClass("widget-title-orange");
            }else{
                $(".ordonance").addClass("widget-title-green");
            }

        }
    });
    </script>

