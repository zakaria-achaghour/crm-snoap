<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th rowspan=2 style="background: yellow">Nom Pharmacie</th>
            <th rowspan=2 style="background: yellow">Nom Pharmacien</th>
            <th rowspan=2 style="background: yellow">Adresse</th>
            <th rowspan=2 style="background: yellow">Région</th>
            <th rowspan=2 style="background: yellow">Ug</th>
            <th rowspan=2 style="background: yellow">Nom délégué</th>
            <th rowspan=2 style="background: yellow">Date de visite</th>
            <th rowspan=2 style="background: yellow">Commande</th>

            @for ($i = 0; $i < count($produits); $i++)
                <th colspan=3 style="background: yellow" >{{ $produits[$i]->designation }}</th>

            @endfor
        </tr>
        <tr>
                @for ($i = 0; $i < count($produits); $i++)
                    <th style="background: yellow" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MEP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </th>
                    <th style="background: yellow" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ENQ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th style="background: yellow" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EMG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </th>

                @endfor
        </tr>
        
    </thead>
    <tbody>

        @foreach ($visites as $key=> $visite)
            
            <tr>
                <td class="table-action">{{ $visite->nom }}</td>
                <td class="table-action">{{ $visite->pharmacien }}</td>
                <td class="table-action">{{ $visite->adresse }}</td>
                <td class="table-action">{{ $visite->region }}</td>
                <td class="table-action">{{ $visite->ugmc }}</td>
                <td class="table-action">{{ $visite->delegue }}</td>
                <td class="table-action">{{ \Carbon\Carbon::parse( $visite->date )->format('d/m/Y') }}</td>
                <td class="table-action">{{ ($visite->commande==1)?'Oui':'Non' }}</td>
                
                @for ($i = 0; $i < count($produits); $i++)
                <td class="table-action">{{ ($visite->{$produits[$i]->designation.'_miseEnPlace'}!=null)?(($visite->{$produits[$i]->designation.'_miseEnPlace'}==1)?'Oui':'Non'):'' }}</td>
                    <td class="table-action">{{ $visite->{$produits[$i]->designation} }}</td>
                    <td class="table-action">{{ ($visite->{$produits[$i]->designation.'_emg'}!='')?(($visite->{$produits[$i]->designation.'_emg'}!='')?$visite->{$produits[$i]->designation.'_emg'}:0):'' }}</td>
                  
                @endfor
            </tr>
        @endforeach

    </tbody>
</table>
 