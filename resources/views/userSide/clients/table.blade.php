<table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th class="hidden-phone">{{ __('Code Sage')}}</th>
                        <th>{{ __('Name Pharmacy') }}</th>
                        <th>{{ __('Cities') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Pharmacist') }}</th>
                        <th class="hidden-phone">{{ __('Authorization') }}</th>
                        <th class="hidden-phone">Num Ug</th>
                        <th class="hidden-phone">{{ __('Block / Unblock')}}</th>
                        <th class="hidden-phone">{{ __('Documents') }}</th>
                       
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                   
                    @for ($i = 0; $i < count($clients); $i++)
                        
                    
                        <tr>
                            <td >{{ ($clients[$i]->is == 1 )? 'Existant':'Potentiel'  }}</td>
                            <td class="hidden-phone">{{ $clients[$i]->sage }}</td>
                            <td>{{ $clients[$i]->nom }}</td>

                            <td>{{ $clients[$i]->ville }}</td>
                            <td>{{ $clients[$i]->adresse }}</td>
                            
                            <td>{{ $clients[$i]->pharmacien }}</td>
                           

                            <td class="hidden-phone">{{ $clients[$i]->autorisation }}</td>
                            <td class="hidden-phone">{{ $clients[$i]->ugmc }}</td>



                            <td class="hidden-phone">
                                @if ($clients[$i]->bloque == 1)
                                    <p class="text-danger">{{ __('Blocked') }}</p>
                                @else
                                 {{ __('Not blocked') }}

                                @endif

                            <td class="table-action hidden-phone">
                                @if ($clients[$i]->fichier != '')
                                    <a class="badge badge-success"
                                        href="{{ asset('storage/' . $clients[$i]->fichier) }}"
                                        download="{{ $clients[$i]->nom }} Documents">Telecharger</a>
                                @else
                                    <span class="badge badge-info">Aucun document</span>
                                @endif
                            </td>
                           
                            <td class="table-action">
                                <!------ button edit ------>
                                <a href="{{ route('clients.edit', [$clients[$i]->id]) }}" title="Traitement"
                                    class="btn btn-success btn-mini green tip"><i class="icon-pencil"></i></a>
                                </td>
                        </tr>
                        @endfor
                </tbody>
            </table>