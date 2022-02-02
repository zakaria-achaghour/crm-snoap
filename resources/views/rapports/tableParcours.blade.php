<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th  style="background: yellow">Délégué</th>
            <th  style="background: yellow">Type</th>
            <th  style="background: yellow">Nom</th>
            <th  style="background: yellow">Ville</th>
            <th  style="background: yellow">Adresse</th>
            <th  style="background: yellow">Date</th>

        </tr>
        
    </thead>
    
    <tbody>

    @foreach ($visites as $key=> $visite)
            
            <tr>
                <td class="table-action">{{ $visite->firstname .' '. $visite->lastname}}</td>
                <td class="table-action">{{ $visite->type }}</td>
                <td class="table-action">{{ $visite->name }}</td>
                <td class="table-action">{{ $visite->nom }}</td>
                <td class="table-action">{{ $visite->adresse }}</td>
                <td class="table-action">{{ \Carbon\Carbon::parse( $visite->Date )->format('d/m/Y')  }}</td>

            </tr>
        @endforeach

        @foreach ($visites_pharmas as $key=> $visite)
            
            <tr>
                <td class="table-action">{{ $visite->firstname .' '. $visite->lastname}}</td>
                <td class="table-action">{{ $visite->type }}</td>
                <td class="table-action">{{ $visite->name }}</td>
                <td class="table-action">{{ $visite->nom }}</td>
                <td class="table-action">{{ $visite->adresse }}</td>
                <td class="table-action">{{ \Carbon\Carbon::parse( $visite->Date )->format('d/m/Y')  }}</td>

            </tr>
        @endforeach

    </tbody>
</table>