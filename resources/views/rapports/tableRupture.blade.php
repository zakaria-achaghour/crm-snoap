<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th  style="background: yellow">Produit</th>
            <th  style="background: yellow">MCP</th>
            <th  style="background: yellow">Ug</th>
            <th  style="background: yellow">Date</th>
            <th  style="background: yellow">action</th>

        </tr>
        
    </thead>
    
    <tbody>

        @foreach ($products as $key=> $product)
            
            <tr>
                <td class="table-action">{{ ($product->autre==0)? $product->designation : $product->product }}</td>
                <td class="table-action">{{ ($product->autre==0)? 'Oui' : 'Non' }}</td>
                <td class="table-action">{{ $product->ug }}</td>
                <td class="table-action">{{ date('d/m/Y', strtotime($product->date))  }}</td>
                <td class="table-action">
                    <a href="{{ route('visites.edit.pharmacy', ['visite_id' => $product->visite_id])}}" title="Afficher"
                        class="btn btn-success tip btn-mini tip"><i class="icon-search"></i></a>
                </td>

            </tr>
        @endforeach

    </tbody>
</table>