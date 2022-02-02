<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th>{{ __('Name Pharmacy') }}</th>
            <th>{{ __('Type') }}</th>
            <th>{{ __('Cities') }}</th>
            <th>{{ __('Address') }}</th>

            <th >{{ __('Authorization') }}</th>
            <th>{{ __('Patent') }}</th>
            <th>ICE</th>
            <th>IF</th>
            <th>RC</th>

            <th>{{ __('Pharmacist') }}</th>
            <th>Contact</th>
            <th>CIN</th>
            <th>{{ __('Block / Unblock')}}</th>
            <th>Motif</th>
            <th>{{ __('Code Sage')}}</th>
        </tr>
    </thead>
    <tbody>
       
        @for ($i = 0; $i < count($clients); $i++)
            <tr>
                <td>{{ $clients[$i]->nom }}</td>
                <td>@if ($clients[$i]->type == 1 )
                    {{ __('Pharmacy') }}
                    @else
                    {{ __('Wholesaler') }}
                     @endif
                </td>
                <td>{{ $clients[$i]->ville }}</td>
                <td>{{ $clients[$i]->adresse }}</td>

                <td>{{ $clients[$i]->autorisation }}</td>
                <td>{{ $clients[$i]->patente }}</td>
                <td>{{ $clients[$i]->ice }}</td>
                <td>{{ $clients[$i]->i_f }}</td>
                <td>{{ $clients[$i]->rc }}</td>

                <td>{{ $clients[$i]->pharmacien }}</td>
                <td>{{ $clients[$i]->contact }}</td>
                <td>{{ $clients[$i]->cin }}</td>
                <td>
                    @if ($clients[$i]->bloque == 1)
                        <p class="text-danger">{{ __('Blocked') }}</p>
                    @else
                     {{ __('Not blocked') }}

                    @endif
                </td>
                <td>{{ $clients[$i]->motif }}</td>
                <td>{{ $clients[$i]->sage }}</td>
            

               
           
            </tr>
            @endfor
    </tbody>
</table>