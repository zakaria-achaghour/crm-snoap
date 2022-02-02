<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>{{ __("List of clients")}}</h5>
            {{-- <a href="{{ route('exporter_view',['tout','0']) }}"target="_blank" class="btn btn-success btn-mini add-action"><i class="icon icon-download-alt"></i> Exporter</a> --}}

        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                       
                        <th>{{ __('Name Pharmacy') }}</th>
                        <th>{{ __('Cities') }}</th>

                        <th class="hidden-phone">{{ __('Authorization') }}</th>
                        <th class="hidden-phone">{{ __('Address') }}</th>
                        <th class="hidden-phone">{{ __('Pharmacist') }}</th>
                        <th>{{ __('Code Sage')}}</th>
                        <th >{{ __('Block / Unblock')}}</th>



                        <th class="hidden-phone">{{ __('Documents') }}</th>
                       
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                   
                    @for ($i = 0; $i < count($clients); $i++)
                        
                    
                        <tr>
                            
                            <td>{{ $clients[$i]->nom }}</td>
                           
                            <td>{{ $clients[$i]->ville }}</td>

                            <td class="hidden-phone">{{ $clients[$i]->autorisation }}</td>
                            <td class="hidden-phone">{{ $clients[$i]->adresse }}</td>
                            <td class="hidden-phone">{{ $clients[$i]->pharmacien }}</td>
                            <td>{{ $clients[$i]->sage }}</td>

                            
                            <td>
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
        </div>
    </div>
</div>
<script src="{{ asset('layout/js/matrix.tables.js')}}"></script>