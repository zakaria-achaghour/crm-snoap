<div class="row-fluid">
    <hr>
        @php
            $total = $statistique[0]+$statistique[1]+$statistique[2]+$statistique[3];
        @endphp
        <div class="text-center">
            <ul class="stat-boxes2 text-center">
    
                <li>
                    <div class="left peity_bar_neutral"><span>
                    <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
                    </span>{{ ($total==0)?'0':number_format( ($statistique[0]*100/($total)) , 2, '.', '') }}%</div>
                    <div class="right "> <strong>{{ $statistique[0] }}</strong> PS </div> 
                </li> 
                <li>
                    <div class="left peity_bar_neutral"><span>
                    <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
                    </span>{{ ($total==0)?'0':number_format( ($statistique[1]*100/($total)) , 2, '.', '')}}%</div>
                    <div class="right "> <strong>{{ $statistique[1] }}</strong> PG </div> 
                </li>  
                <li>
                    <div class="left peity_bar_neutral"><span>
                    <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
                    </span>{{ ($total==0)?'0':number_format( ($statistique[2]*100/($total)) , 2, '.', '')}}%</div>
                    <div class="right "> <strong>{{ $statistique[2] }}</strong> HS </div> 
                </li>  
                <li>
                    <div class="left peity_bar_neutral"><span>
                    <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
                    </span>{{ ($total==0)?'0':number_format( ($statistique[3]*100/($total)) , 2, '.', '')}}%</div>
                    <div class="right "> <strong>{{ $statistique[3] }}</strong> HG </div> 
                </li>   
                
                <li>
                    <div class="left peity_bar_neutral"><span>
                    <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
                    </span>100%</div>
                    <div class="right "> <strong>{{ $total }}</strong> Total </div> 
                </li>   
                
            </ul>
        </div>
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>Planning: {{ count($plannings)}} visites médecin</h5>
    
            </div>
            <div class="widget-content nopadding">
            
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Spécialité</th>
                            <th>Sécteur</th>
                            <th>Adresse</th>
                            <th>De</th>
                            <th>A</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="hover_black">
                        @foreach ($plannings as $planning)
                        <tr>
                            <td>{{$planning->name}}</td>
                            <td>{{$planning->designation}}</td>
                            <td>{{$planning->statut_mc}}</td>
                            <td>{{$planning->adresse}}</td>
                            <td>{{\Carbon\Carbon::parse( $planning->date_debut )->format('d/m/Y')}}</td>
                            <td>{{\Carbon\Carbon::parse( $planning->datee_fin )->format('d/m/Y')}}</td>
    
                            <td class="table-action">
                                @if($planning->user_id==Auth::id())
                                    <a href="{{ route('visites.create.doctor', ['doctor' => $planning->doctor_id, 'planning'=>$planning->id]) }}" title="Visite Doctor"
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
                            
                            var url = "{{route('plannings.destroy.doctors', [":id"])}}";
                                 url = url.replace(':id', delete_id);
                            $.ajax({
                                type: "GET",
                                url:  url,
                                // data: data,
                                success: function(response) {
                                    swal.fire("Fait!",'', "success" )
                                        .then((result) => {
                                            window.location.href ='doctors';
                                        });
                                }
                            });
                        }
                    });
            });
        });
    </script>