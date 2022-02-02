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
                                <th>Article MCP</th>
                                <th>Grossistes</th>
                                <th class='delete_fin'>Supprimer</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                               
                     
                            @foreach ($products as $product)
                            <tr>
                                <td class="table-action">{{ ($product->autre==1)? $product->product : $product->designation }}</td>
                                <td class="table-action">{{ ($product->autre==1)? 'Non' : 'Oui' }}</td>
                                @php
                                $grossistes = explode(',' , $product->grossistes); 
                                 @endphp
                                <td>
                                    @if($product->autre==1)
                                        <span class="badge badge-warning">Aucune information</span>
                                    @else
                                            @foreach ($grossistes as $grossiste)
                                            
                                            <span class="{{ $grossiste==null ? 'badge badge-warning':'badge ' }} ">
                                            {{ $grossiste!=null ? $grossiste:'Aucune information' }}
                                            </span>
                                            @endforeach
                                    @endif
                                   
                                </td>
                                <td class="table-action delete_fin ">
                                    <input type="hidden" class="rupture_product_designation" value="{{ $product->designation }}">
                                    <input type="hidden" class="rupture_autre" value="{{ $product->autre }}">
                                     <input type="hidden" class="rupture_product_id" value="{{ $product->product_id }}">
                                     <input type="hidden" class="rupture_id" value="{{ $product->id }}">
                                    <a class="btn btn-danger tip deletebtn_rupture"><i class="icon-trash"></i></a> 

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
    <input type="hidden" id="count_rupture" value="0">
@endif
    <script>
        
        $(document).ready(function() {
        $('.deletebtn_rupture').click(function(e) {
           
            e.preventDefault();
            var delete_id = $(this).closest("td").find('.rupture_id').val();
            var product_id = $(this).closest("td").find('.rupture_product_id').val();
            var product_designation = $(this).closest("td").find('.rupture_product_designation').val();
            var autre = $(this).closest("td").find('.rupture_autre').val();

        //alert(delete_id +'------'+ product_designation);
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
                        if(autre==0){
                            $("#porduit_fini_rupture").append("<option value='" + product_id + "'>" + product_designation + "</option>");
                        }
                        var url = "{{route('visites.ruptureDestroy.pharmacy', ":id")}}";
                         url = url.replace(':id', delete_id);
                        $.ajax({
                            type: "GET",
                            url:  url,
                            success: function(response) {
                                swal.fire("Fait!", response.status, "success")
                                    .then((result) => {
                                        $("#displayRuptureTable").hide().html(response).fadeIn(100);

                                    });
                            }
                        });
                    }
                });
        });

       

        if ($("#visite_fin").val() == 1) {

            $(".delete_fin").hide();
            if ($("#count_rupture").val()==0){
                $(".rupture").addClass("widget-title-orange");
            }else{
                $(".rupture").addClass("widget-title-green");
            }

        }
    });
    </script>

