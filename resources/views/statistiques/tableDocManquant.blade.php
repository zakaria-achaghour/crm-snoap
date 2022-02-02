<table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>{{ __('Name Pharmacy') }}</th>
                        <th>{{ __('Cities') }}</th>
                        <th>{{ __('Documents') }}</th>
                        @can('admin.manage',Auth::user()) <th>{{ __('Actions') }}</th>@endcan
                    </tr>
                </thead>
                <tbody>

                    @for ($i = 0; $i < count($clients); $i++)
                        <tr>

                            <td>{{ $clients[$i]->nom }}</td>
                            <td>{{ $clients[$i]->ville }}</td>
                            <td class="table-action  d-inline-block">
                                @if ($clients[$i]->fichier != '')

                                    @if ($clients[$i]->fichier_cin != true)
                                        <span class="text-info">CIN ,</span>

                                    @endif


                                    @if ($clients[$i]->fichier_autorisation != true)
                                        <span class="text-info"> Autorisation ,</span>
                                    @endif



                                    @if ($clients[$i]->fichier_if_ice != '1')
                                        <span class="text-info"> IF , ICE</span>
                                    @endif

                                @else
                                    <span class="badge badge-primary">Aucun document</span>
                                @endif
                            </td>
                            @can('admin.manage',Auth::user())
                            <td class="table-action">
                                @if ($clients[$i]->fichier != '')
                                    <a class="btn btn-info btn-mini tip" title="Télécharger"
                                        href="{{ asset('/storage/' . $clients[$i]->fichier) }}"
                                        download="{{ $clients[$i]->nom }} Documents"><i
                                            class="icon-download-alt"></i></a>
                                @endif
                                <a href="{{ route('clients.edit', [$clients[$i]->id]) }}"
                                    class="tip btn btn-success btn-mini  " title="Traitement"><i
                                        class="icon-pencil"></i></a>

                            </td>
                            @endcan


                        </tr>
                    @endfor

                </tbody>
            </table>