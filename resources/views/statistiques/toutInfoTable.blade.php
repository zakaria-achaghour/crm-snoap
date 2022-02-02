<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th>{{ __('Name Pharmacy') }}</th>
            <th>{{ __('Cities') }}</th>
            <th >{{ __('Authorization') }}</th>
            <th>{{ __('Patent') }}</th>
            <th class="hidden-phone">ICE</th>
            <th class="hidden-phone">IF</th>
            <th class="hidden-phone">RC</th>
            <th class="hidden-phone">{{ __('Pharmacist') }}</th>
            <th class="hidden-phone">NUM UG</th>
            <th class="hidden-phone">Contact</th>
        </tr>
    </thead>
    <tbody>
       
        @for ($i = 0; $i < count($clients); $i++)
            <tr>
                <td>{{ $clients[$i]->nom }}</td>
                <td>{{ $clients[$i]->ville }}</td>
                <td>{{ $clients[$i]->autorisation }}</td>
                <td>{{ $clients[$i]->patente }}</td>
                <td class="hidden-phone">{{ $clients[$i]->ice }}</td>
                <td class="hidden-phone">{{ $clients[$i]->i_f }}</td>
                <td class="hidden-phone">{{ $clients[$i]->rc }}</td>
                <td class="hidden-phone">{{ $clients[$i]->pharmacien }}</td>
                <td class="hidden-phone">{{ $clients[$i]->ugmc }}</td>
                <td class="hidden-phone">{{ $clients[$i]->contact }}</td>
            </tr>
        @endfor
    </tbody>
</table>