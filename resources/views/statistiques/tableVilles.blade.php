 <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>{{ __('Name Pharmacy') }}</th>
                      
                        <th class="hidden-phone">{{ __('Authorization') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Pharmacist') }}</th>
                        <th class="hidden-phone">{{ __('Documents') }}</th>
                        <th class="hidden-phone">{{ __('Code sage') }}</th>
                        @can('admin.manage',Auth::user()) <th>{{ __('Actions') }}</th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $client->nom }}</td>
                           
                            <td class="hidden-phone">{{ $client->autorisation }}</td>
                            <td>{{ $client->adresse }}</td>
                            <td>{{ $client->pharmacien }}</td>
                            <td class="table-action hidden-phone">
                                @if ($client->fichier != '')
                                    <a class="badge badge-success" href="{{ asset('storage/' . $client->fichier) }}"
                                        download="{{ $client->nom }} Documents">{{__("Download")}}</a>
                                @else
                                    <span class="badge badge-info">{{ __("No document")}}</span>
                                @endif
                            </td>
                            <td class="hidden-phone">{{ $client->sage }}</td>
                            @can('admin.manage',Auth::user())
                                
                            <td class="table-action">
                                <!------ button edit ------>
                                <a href="{{ route('clients.edit', [$client->id]) }}"
                                    class="tip btn btn-success btn-mini green " title="Traitement"><i
                                        class="icon-pencil"></i></a>
                                <!------ button remove ------>
                                <!--<a href="javascript:void(0);" class="btn btn-outline-danger deleteUser btn-block"
                                    data-toggle="modal" data-target="#userConfirm"><i class="fas fa-trash-alt"></i></a>-->
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
            