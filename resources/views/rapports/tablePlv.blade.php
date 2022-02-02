<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th  style="background: yellow">Produit</th>
            <th  style="background: yellow">PLV</th>
        </tr>
        
    </thead>
    <tbody>

        @foreach ($visites as $key=> $visite)
            
            <tr>
                <td class="table-action">{{ $visite->designation }}</td>
                <td class="table-action">{{ ($visite->qte=='')?0:$visite->qte}}</td>
            </tr>
        @endforeach

    </tbody>
</table>
 