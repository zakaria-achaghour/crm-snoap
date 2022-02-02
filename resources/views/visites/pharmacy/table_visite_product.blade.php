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
                                <th>PF</th>
                                <th>Mise en place</th>
                                <th>Quantité</th>
                                <th class='delete_fin'>Supprimer</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                               
                     
                            @foreach ($products as $product)
                            <tr>
                                <td class="table-action">{{ $product->designation }}</td>

                                <td class="table-action">{{ ($product->miseEnPlace == 1)? 'Oui':'Non' }}</td>
                                <td class="table-action">{{ $product->qte?$product->qte:0 }}</td>
                                <td class="table-action delete_fin ">
                                    <input type="hidden" class="product_designation" value="{{ $product->designation }}">
                                    <input type="hidden" class="product_id" value="{{ $product->product_id }}">
                                    <input type="hidden" class="visite_product_id" value="{{ $product->id }}">
                                    <a class="btn btn-danger tip deletebtn"><i class="icon-trash"></i></a>

                                </td>
                            </tr>

                            @endforeach
                                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        @if(count($product_doctors)>0)
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title "> <span class="icon"><i class="icon-user-md"></i></span>
                    <h5>Autre médecins </h5>                    
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Médecin</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            
                    
                            @foreach ($product_doctors as $product_doctor)

                                @php
                                    $medecins = explode(',' , $product_doctor->medecins); 
                                @endphp
                                
                                <tr>
                                    <td class="table-action">{{ $product_doctor->designation }}</td>
                                    
                                    <td class="table-action">
                                        @foreach ($medecins as $medecin)
                                            <span class="badge ">
                                            {{ $medecin }}
                                            </span>
                                        @endforeach
                                        
                                    </td>
                                </tr>

                            @endforeach
                                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endif

    </div>
@else
    <input type="hidden" id="count_product" value="0">
@endif
    <script>
        
        $(document).ready(function() {
        $('.deletebtn').click(function(e) {
            
            e.preventDefault();
            var delete_id = $(this).closest("td").find('.visite_product_id').val();
            var product_id = $(this).closest("td").find('.product_id').val();
            var product_designation = $(this).closest("td").find('.product_designation').val();
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
                        $("#porduit_fini").append("<option value='" + product_id + "'>" + product_designation + "</option>");
                    
                        var url = "{{route('visites.productDestroy.pharmacy', ":id")}}";
                         url = url.replace(':id', delete_id);
                        $.ajax({
                            type: "GET",
                            url:  url,
                            success: function(response) {
                                

                                swal.fire("Fait!", response.status, "success")
                                    .then((result) => {
                                        $("#displayProductTable").hide().html(response).fadeIn(100);

                                    });
                            }
                        });
                    }
                });
        });

        if ($("#visite_fin").val() == 1) {

            $(".delete_fin").hide();
            if ($("#count_product").val()==0){
                $(".product").addClass("widget-title-orange");
            }else{
                $(".product").addClass("widget-title-green");
            }

        }
    });
    </script>

