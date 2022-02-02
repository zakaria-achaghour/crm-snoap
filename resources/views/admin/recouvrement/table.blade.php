<table class="table table-bordered data-table">
    <thead>
        <tr>

            <th>{{ __('Name Pharmacy') }}</th>
            <th>{{ __('Cities') }}</th>
            <th>{{ __('Code Sage') }}</th>
            <th class="hidden-phone">Observation</th>
            <th>{{ __('Amount') }}</th>
            <th>{{ __('Rest') }}</th>
            <th class="hidden-phone">{{ __('Collection date') }}</th>
            <th class="hidden-phone">{{ __('status') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody>

        @for ($i = 0; $i < count($cheques); $i++)


            <tr>

                <td>{{ $cheques[$i]->nom }}</td>
                <td>{{ $cheques[$i]->ville }}</td>
                <td>{{ $cheques[$i]->sage }}</td>
                <td class="hidden-phone">{{ $cheques[$i]->observation }}</td>
                <td>{{ $cheques[$i]->montant }}</td>
                <td>{{ $cheques[$i]->montant - $cheques[$i]->paye }}</td>

                <td class="hidden-phone">{{ $cheques[$i]->date_recouvrement }}</td>
                <td class="hidden-phone table-action">
                    @if ($cheques[$i]->paye == $cheques[$i]->montant)
                        <p class="recov_vert">{{ __('Paid') }}</p>
                    @else
                        <p class="text-danger">{{ __('Unpaid') }}</p>
                    @endif
                </td>

                <td class="table-action">
                    <!------ button edit ------>
                    <a href="{{ route('recouvrement.edit', [$cheques[$i]->id]) }}" title="Traitement"
                        class="btn btn-success btn-mini green tip"><i class="icon-pencil"></i></a>
                </td>
            </tr>
        @endfor
    </tbody>
</table>
