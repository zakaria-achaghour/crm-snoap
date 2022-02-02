<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th  style="background: yellow">Produit</th>
            <th  style="background: yellow">Quantité Médecin</th>
            <th  style="background: yellow">Quantité Pharmacie</th>
            <th  style="background: yellow">Quantité Total</th>
        </tr>
        
    </thead>
    <tbody>

        @foreach ($visites as $key=> $visite)
            
            <tr>
                <td class="table-action">{{ $visite->designation }}</td>
                <td class="table-action">{{ ($visite->qteMed=='')?0:$visite->qteMed}}</td>
                <td class="table-action">{{ ($visite->qtePharma=='')?0:$visite->qtePharma }}</td>
                <td class="table-action">{{ $visite->qteMed + $visite->qtePharma }}</td>
            </tr>
            
        @endforeach
        
    </tbody>
    <tfoot>
        <tr>
            
            <th  colspan="3">Total</th>
                <td class="table-action">{{ $total }}</td>
        </tr>
    </tfoot>

</table>
 