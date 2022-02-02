<table class="table table-bordered data-table">
    <thead>
        <tr>

            <th>{{ __('Name Pharmacy') }}</th>
            <th>{{ __('Cities') }}</th>
            <th>{{ __('Code Sage') }}</th>
            <th class="hidden-phone">{{ __('Number of Checks') }}</th>
           
            <th>{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody>

    

        @foreach ($clients as $client)
            <tr>

                <td>{{ $client->nom }}</td>
                <td>{{ $client->ville }}</td>
                <td>{{ $client->sage }}</td>
                <td>{{ $client->nombreCheque ? $client->nombreCheque : 0 }}</td>
                </td>

                <td class="table-action">
                    <!------ button edit ------>
                    <a href="{{ route('clients.chequesencours.edit', [$client->id]) }}" title="Traitement"
                        class="btn btn-success btn-mini green tip"><i class="icon-pencil"></i></a>
                </td>
            </tr>
            @endforeach
    </tbody>
</table>
