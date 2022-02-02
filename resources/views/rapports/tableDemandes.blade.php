<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th  style="background: yellow">Date</th>
            <th  style="background: yellow">Délégué</th>
            <th  style="background: yellow">Médecin</th>
            <th  style="background: yellow">Demande</th>
            <th  style="background: yellow">Action</th>

        </tr>
        
    </thead>
    <tbody>

        @foreach ($visites as $key=> $visite)
            
            <tr>
                <td class="table-action">{{ \Carbon\Carbon::parse( $visite->Date )->format('d/m/Y')  }}</td>
                <td class="table-action">{{ $visite->firstname .' '. $visite->lastname}}</td>
                <td class="table-action">{{ $visite->name }}</td>
                <td class="table-action">{{ $visite->demande_special }}</td>
                <td class="table-action">

                    <a href="{{ route('visites.edit.doctor', ['visite_id' => $visite->id])}}" title="Afficher"
                                        class="btn btn-success tip btn-mini tip"><i class="icon-search"></i></a>

                </td>

            </tr>
        @endforeach

    </tbody>
</table>