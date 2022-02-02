<table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>{{ __('Name Pharmacy') }}</th>
                        <th>{{ __('Cities') }}</th>
                        <th class="hidden-phone">{{ __('Address') }}</th>
                        <th class="hidden-phone">{{ __('Pharmacist') }}</th>
                      

                        <th>{{ __('Blocking pattern') }}</th>
                        {{-- <th>{{ __('Actions') }}</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->nom }}</td>
                            <td>{{ $client->ville }}</td>
                            <td class="hidden-phone">{{ $client->adresse }}</td>
                            <td class="hidden-phone">{{ $client->pharmacien }}</td>
                           

                            <td>{{ $client->motif }}</td>
                            {{-- <td class="table-action">
                                <!------ button edit ------>
                                <a href="{{ route('clients.edit', [$client->id]) }}"
                                    class="tip btn btn-success btn-mini green " title="Traitement"><i class="icon-pencil"></i></a>
                                <!------ button remove ------>
                                <!--<a href="javascript:void(0);" class="btn btn-outline-danger deleteUser btn-block"
                                    data-toggle="modal" data-target="#userConfirm"><i class="fas fa-trash-alt"></i></a>-->
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>