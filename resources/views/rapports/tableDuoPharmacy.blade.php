<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th  style="background: yellow">Pharmacy</th>
            <th  style="background: yellow">Date</th>
            <th  style="background: yellow">Responsable</th>
            <th  style="background: yellow">Délégué</th>
        </tr>
        
    </thead>
    <tbody>

        @foreach ($visites as $key=> $visite)
        
            <tr>
                <td class="table-action">{{ $visite->pharmacy }}</td>
                <td class="table-action">{{ $visite->created_at }}</td>
                <td class="table-action">{{ $visite->responsable }}</td>
                <td class="table-action">{{ $visite->delegue }}</td>
            </tr>
            
        @endforeach
        
    </tbody>

</table>
 