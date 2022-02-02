@if(count($visite_emgs)>0)
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


                        @foreach ($visite_emgs as $visite_emg)
                        <tr>
                            <td class="table-action">{{ $visite_emg->designation }}</td>
                            <td class="table-action">{{ $visite_emg->qte }}</td>
                            <td class="table-action delete_fin">
                                <input type="hidden" class="visite_emg_id" value="{{ $visite_emg->id }}">
                                <input type="hidden" class="emg_id" value="{{ $visite_emg->product_id }}">
                                <input type="hidden" class="emg_designation" value="{{ $visite_emg->designation }}">
                                <a class="btn btn-danger tip deletebtnEmg"><i class="icon-trash"></i></a>

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
    <input type="hidden" id="count_emg" value="0">
@endif

<script>
    $(document).ready(function() {
        $('.deletebtnEmg').click(function(e) {

            e.preventDefault();
            var delete_id = $(this).closest("td").find('.visite_emg_id').val();
            var emg_id = $(this).closest("td").find('.emg_id').val();
            var emg_designation = $(this).closest("td").find('.emg_designation').val();

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
                    $("#emg").append("<option value='" + emg_id + "'>" + emg_designation + "</option>");
                    
                    var url = "{{route('visites.deleteemg.doctor', [":id"])}}";
                    url = url.replace(':id', delete_id);
                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function(response) {


                            swal.fire("Fait!", response.status, "success")
                                .then((result) => {
                                    $("#displayEmgTable").hide().html(response).fadeIn(100);

                                });
                        }
                    });
                }
            });
        });

        if ($("#visite_fin").val() == 1) {

            $(".saveEmg").hide();
            $(".visites").hide();
            $(".delete_fin").hide();
            if ($("#count_emg").val()==0){
                $(".emg").addClass("widget-title-orange");
            }else{
                $(".emg").addClass("widget-title-green");
            }
        }
    });
</script>