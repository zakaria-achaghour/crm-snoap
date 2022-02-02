<div class="row-fluid ">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Liste des Dépenses</h5>
        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered data-table ">
                <thead>
                    <tr class="text-center">
                        <th>Demandeur</th>
                        <th>Médecine</th>
                        <th>Spécialité</th>
                        <th>Nature</th>
                        <th>Status</th>


                        <th>Actions</th>

                       
                    </tr>
                </thead>

               
                <tbody>
                    @foreach ( $advs as $adv )
                    <tr >
                        <td class="table-action">{{ $adv->autre_user? $adv->autre_user: ( $adv->user->firstname .' '.$adv->user->lastname) }}</td>
                        <td class="table-action">{{ $adv->autre_doctor ? $adv->autre_doctor: $adv->doctor->name  }}</td>
                        <td class="table-action">{{ $adv->autre_specialty ? $adv->autre_specialty :$adv->doctor->specialty->designation  }}</td>

                        <td class="table-action">{{ $adv->nature->designation  }}</td>


                        <td class="table-action">
                            @if ($adv->step == 0 )
                            <p class="text-warning">En Cours Création</p>
                             @endif
                            @if ($adv->step == 1 )
                                 <p class="text-info">Créé</p>
                             @endif
                             @if ($adv->step == 2 )
                             <p class="text-info">Accepté</p>
                            @endif
                            @if ($adv->step == 4 )
                            <p class="text-success">Validé</p>
                           @endif
                            @if ($adv->step == 3 )
                            <p class="text-danger">Refusé</p>
                           @endif
                           @if ($adv->step == 5 )
                            <p class="text-danger">Rejeté</p>
                           @endif
                           @if ($adv->step == 6 )
                            <p class="text-info">Commandé</p>
                           @endif
                           @if ($adv->step == 7 )
                            <p class="text-success">Livré</p>
                           @endif
                        </td>

                        

                        
                        <td class="table-action">
                            @if($adv->step >=1)
                                <a href="{{ route('advs.show', ['adv' => $adv->id])}}" title="Détail dépense"
                                    class="btn btn-info tip"><i class="icon-eye-open"></i></a>
                            @endif
                          
                            @if($adv->step ==0)
                                <a href="{{ route('advs.edit', ['adv' => $adv->id])}}" title="Modifier"
                                    class="btn btn-warning tip"><i class="icon-edit"></i></a>
                            @endif

                            @if($adv->step == 7)
                                <a href="{{ route('advs.print', ['adv' => $adv->id])}}" target="_blank"title="Imprimer"
                                    class="btn btn-info tip"><i class="icon-print"></i></a>
                             @endif


                          
                        </td>

                    </tr>
                    @endforeach
                
                </tbody>

               
            </table>
        </div>
    </div>
</div>