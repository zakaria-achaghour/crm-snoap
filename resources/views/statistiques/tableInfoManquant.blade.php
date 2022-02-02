<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th>{{ __('Name Pharmacy') }}</th>
            <th>{{ __('Cities') }}</th>
            <th>{{ __('Missing information') }}</th>
            @can('admin.manage',Auth::user()) <th>{{ __('Actions') }}</th>@endcan
        </tr>
    </thead>
    <tbody>

        @for ($i = 0; $i < count($clients); $i++)
            <tr>
                <td class="table-action">{{ $clients[$i]->nom }}</td>
                <td class="table-action">{{ $clients[$i]->ville }}</td>
                <td class="table-action  d-inline-block">
                    @if ($clients[$i]->patente == '')
                        <span class="text-info"> {{ __('Patent') }} .</span>
                    @endif
                    @if ($clients[$i]->ice == '')
                        <span class="text-info"> {{ __('ICE') }}  .</span>
                    @endif
                    @if ($clients[$i]->i_f == '')
                        <span class="text-info"> {{ __('IF') }} .</span>
                    @endif
                    @if ($clients[$i]->autorisation == '')
                        <span class="text-info"> {{ __('Authorization') }} .</span>
                    @endif
                    @if ($clients[$i]->rc == '')
                        <span class="text-info"> {{ __('RC') }} .</span>
                    @endif
                    @if ($clients[$i]->adresse == '')
                        <span class="text-info"> {{ __('Address') }} .</span>
                    @endif

                    @if ($clients[$i]->pharmacien == '')
                        <span class="text-info"> {{ __('Pharmacist') }} .</span>
                    @endif

                    @if ($clients[$i]->contact == '')
                        <span class="text-info"> {{ __('Contact') }} .</span>
                    @endif

                    @if ($clients[$i]->cin == '')
                        <span class="text-info"> {{ __('CIN') }} .</span>
                    @endif

                    @if ($clients[$i]->sage == '')
                        <span class="text-info"> {{ __('Code Sage') }} </span>
                    @endif
                </td>
                @can('admin.manage',Auth::user())
                <td class="table-action">
                    <a href="{{ route('clients.edit', [$clients[$i]->id]) }}"
                        class="tip btn btn-success btn-mini  " title="Traitement"><i
                            class="icon-pencil"></i></a>
                </td>
                @endcan

            </tr>
        @endfor

    </tbody>
</table>