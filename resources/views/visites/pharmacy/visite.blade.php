<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>VISITE: {{ count($visites)}} visites</h5>

        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Pharmacie</th>
                        <th>Adresse</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="hover_black">
                    @foreach ($visites as $visite)
                    <tr class="@if ($visite->is == 1 && $visite->bloque == 0)
                            background_vert
                        @elseif ($visite->is == 1 && $visite->bloque == 1)
                            background_orange
                        @endif">
                        <td>{{$visite->nom}}</td>
                        <td>{{$visite->adresse}}</td>
                        <td>@can('delegue')
                                
                                {{\Carbon\Carbon::parse( $visite->created_at )->format('d/m/Y')}}
                            @else
                                {{\Carbon\Carbon::parse( $visite->created_at )->format('d/m/Y')}}
                            @endcan
                        </td>


                        <td class="table-action">
                            <!------ button edit ------>
                            @if ($visite->user_id == Auth::id())
                                    @if (!$visite->fin)
                                   
                                        <a href="{{ route('visites.edit.pharmacy', ['visite_id' => $visite->id])}}" title="Modifier"
                                            class="btn btn-warning tip"><i class="icon-edit"></i></a>
                                    @endif
                            @endif
                            
                             @if ($visite->fin)
                                    <a href="{{ route('visites.edit.pharmacy', ['visite_id' => $visite->id])}}" title="Afficher"
                                        class="btn btn-primary tip"><i class="icon-eye-open"></i></a>
                             @endif
                          
                          
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>

 <!--------------------scripte for delete confirm messsage in 'shownotes' view  -->
 <script>
    $(document).ready(function() {
        $('.deletebtn').click(function(e) {
            
            e.preventDefault();
            var delete_id = $(this).closest("td").find('#planing_id').val();
            console.log(delete_id+' this');
            
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
                        var data = {
                            "_token": $('input[name=_token]').val(),
                            "id": delete_id,
                        };
                        var url = "{{route('plannings.destroy.pharmacies', ":id")}}";
                         url = url.replace(':id', delete_id);
                        $.ajax({
                            type: "GET",
                            url:  url,
                            data: data,
                            success: function(response) {
                                swal.fire("Done!", response.status, "success")
                                    .then((result) => {
                                        var url = "{{route('plannings.index.pharmacies')}}";

                                        window.location.href =url;
                                    });
                            }
                        });
                    }
                });
        });
    });

</script>
<!--------------------scripte for delete confirm messsage in 'shownotes' view  -->
