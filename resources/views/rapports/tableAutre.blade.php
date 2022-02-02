<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th  style="background: yellow">Medecin</th>
            <th  style="background: yellow">Produits</th>

        </tr>
        
    </thead>
    
    <tbody>

        @foreach ($autres as $key=> $autre)
            @php
                $products = explode(',' , $autre->product); 
            @endphp
            
            <tr>
                <td class="table-action">{{ $autre->name }}</td>
                <td class="table-action">
                    @foreach ($products as $product)
                        <span class="badge ">
                            {{ $product }}
                        </span>
                    @endforeach
                </td>

            </tr>
        @endforeach

    </tbody>
</table>