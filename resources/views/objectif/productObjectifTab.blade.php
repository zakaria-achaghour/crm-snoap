@if(count($products)>0)
    <hr>

        <!------------------------------- fin message de formation ------------------------------->
    <div class="row-fluid">
        <div class="widget-box">
            
            <div class="widget-title"> <span class="icon"><i class="icon-tag"></i></span>
                <h5>PRODUITS</h5>
                
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>PF</th>
                            <th>Nombre de Boite</th>
                            
                            <th class='delete_fin'>Supprimer</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                            
                    
                        @foreach ($products as $product)
                        <tr>
                            <td class="table-action">{{ $product->designation }}</td>
                            <td class="table-action">{{ $product->nombre_boite}}</td>
                            <td class="table-action delete_fin ">
                                <input type="hidden" class="product_designation" value="{{ $product->designation }}">
                                <input type="hidden" class="product_id" value="{{ $product->product_id }}">
                                <input type="hidden" class="objectif_product_id" value="{{ $product->id }}">
                                <button class="btn btn-danger tip deletebtn"><i class="icon-trash"></i></button>

                            </td>
                        </tr>

                        @endforeach
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@else
    <input type="hidden" id="count_product" value="0">
@endif
    <script>
        
        $(document).ready(function() {
        $('.deletebtn').click(function(e) {
            
            e.preventDefault();
            
            var objectif_id = $("#objectif_id").val();
            var delete_id = $(this).closest("td").find('.objectif_product_id').val();
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
                        $("#products_objectif").append("<option value='" + product_id + "'>" + product_designation + "</option>");
                    
                        $.ajax({
                            type: "GET",
                            url:  '/objectifs/product/table/destroy/'+delete_id+'/'+objectif_id,
                            success: function(response) {
                                

                                swal.fire("Fait!", response.status, "success")
                                    .then((result) => {
                                        $("#dipsplayTabProduct").hide().html(response).fadeIn(100);

                                    });
                            }
                        });
                    }
                });
        });

     
    });
    </script>
    

<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>

