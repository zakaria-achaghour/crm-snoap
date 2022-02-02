<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Planning: {{ count($plannings)}} visites</h5>

        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Pharmacie</th>
                        <th>Adresse</th>
                        <th>De</th>
                        <th>A</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="hover_black">
                    @foreach ($plannings as $planning)
                    <tr class="@if ($planning->is == 1 && $planning->bloque == 0)
                            background_vert
                        @elseif ($planning->is == 1 && $planning->bloque == 1)
                            background_orange
                        @endif">
                        <td>{{$planning->nom}}</td>
                        <td>{{$planning->adresse}}</td>
                       <td>{{\Carbon\Carbon::parse( $planning->date_debut )->format('d/m/Y')}}</td>
                        <td>{{\Carbon\Carbon::parse( $planning->datee_fin )->format('d/m/Y')}}</td>


                        <td class="table-action">
                            @if($planning->user_id==Auth::id())
                                <a href="{{ route('visites.create.pharmacy', ['client' => $planning->client_id, 'planning'=>$planning->id]) }}" title="Visite"
                                class="btn btn-primary tip"><i class="icon-search"></i></a>
                            @endif
                            {{-- <form method="POST" action="{{ route('plannings.destroy', ['planning' => $planning->id]) }}">
                                @csrf
                                @method("delete") --}}
                                <input type="hidden" id="planing_id" value="{{ $planning->id }}">
                                <button class="btn btn-danger tip deletebtn"><i class="icon-trash"></i></button>
                            {{-- </form> --}}
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
                        var url = "{{route('plannings.destroy.pharmacies', [":id"])}}";
                                 url = url.replace(':id', delete_id);
                        $.ajax({
                            type: "GET",
                            url:  url,
                            success: function(response) {
                                swal.fire("Done!", response.status, "success")
                                    .then((result) => {
                                       var url = "{{route('plannings.index.pharmacies', [":id"])}}";
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
