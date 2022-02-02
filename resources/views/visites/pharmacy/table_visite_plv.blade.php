
@if(count($client_plvs)>0)
    <div class="container-fluid">
        <hr>

        <!------------------------------- fin message de formation ------------------------------->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>PLV</th>
                                <th>Date</th>
                                <th  class='delete_fin'>Supprimer</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                               
                     
                            @foreach ($client_plvs as $client_plv)
                            <tr>
                                <td class="table-action">{{ $client_plv->designation }}</td>
                                <td class="table-action">{{ \Carbon\Carbon::parse($client_plv->created_at)->format('d/m/Y')  }}</td>
                                <td class="table-action delete_fin">
                                    <input type="hidden" class="client_plv_id" value="{{ $client_plv->id }}">
                                    <input type="hidden" class="plv_id" value="{{ $client_plv->plv_id }}">
                                    <input type="hidden" class="plv_designation" value="{{ $client_plv->designation }}">
                                    <a class="btn btn-danger tip deletebtnPlv"><i class="icon-trash"></i></a>

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
    <input type="hidden" id="count_plv" value="0">
@endif
    <script>
        $(document).ready(function() {
        $('.deletebtnPlv').click(function(e) {
            
            e.preventDefault();
            var delete_id = $(this).closest("td").find('.client_plv_id').val();
            var plv_id = $(this).closest("td").find('.plv_id').val();
            var plv_designation = $(this).closest("td").find('.plv_designation').val();
            
            swal.fire({
                    title: "Êtes-vous sûr?",
                    icon: 'question',
                    text: "Une fois supprimées, vous ne pourrez plus récupérer ces données! ",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Oui, supprimer",
                    cancelButtonText: "Non, annuler"
                })
                .then((willDelete) => {
                    if (willDelete.value === true) {
                        $("#plv").append("<option value='" + plv_id + "'>" + plv_designation + "</option>");
                        var url = "{{route('visites.deleteplv.pharmacy', ":id")}}";
                         url = url.replace(':id', delete_id);
                        $.ajax({
                            type: "GET",
                            url:  url,
                            success: function(response) {
                                

                                swal.fire("Fait!", response.status, "success")
                                    .then((result) => {
                                        $("#displayPlvTable").hide().html(response).fadeIn(100);

                                    });
                            }
                        });
                    }
                });
        });

        if ($("#visite_fin").val() == 1) {

            $(".savePlv").hide();
            $(".delete_fin").hide();
            
            if ($("#count_plv").val()==0){
                $(".plv").addClass("widget-title-orange");
            }else{
                $(".plv").addClass("widget-title-green");
            }

        }

        
    });
    </script>

