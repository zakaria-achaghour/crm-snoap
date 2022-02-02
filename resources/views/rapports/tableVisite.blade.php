<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th rowspan=2 style="background: yellow">Nom du médecin</th>
            <th rowspan=2 style="background: yellow">Adresse</th>
            <th rowspan=2 style="background: yellow">Région</th>
            <th rowspan=2 style="background: yellow">Ug</th>
            <th rowspan=2 style="background: yellow">Num Ug</th>
            <th rowspan=2 style="background: yellow">Spécialité</th>
            <th rowspan=2 style="background: yellow">Statut</th>
            <th rowspan=2 style="background: yellow">Nom délégué</th>
            <th rowspan=2 style="background: yellow">Date de visite</th>
            <th rowspan=2 style="background: yellow">NP</th>
            <th rowspan=2 style="background: yellow">NPI</th>
            @for ($i = 0; $i < count($produits); $i++)
                <th colspan=4 style="background: yellow" >{{ $produits[$i]->designation }}</th>

            @endfor
        </tr>
        <tr>
                @for ($i = 0; $i < count($produits); $i++)
                    <th style="background: yellow" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th style="background: yellow" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ENQ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </th>
                    <th style="background: yellow" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EMG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </th>
                    <th style="background: yellow" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </th>

                @endfor
        </tr>
        
    </thead>
    <tbody>

        @foreach ($visites as $key=> $visite)
            
            <tr>
                <td class="table-action">{{ $visite->name }}</td>
                <td class="table-action">{{ $visite->adresse }}</td>
                <td class="table-action">{{ $visite->region }}</td>
                <td class="table-action">{{ $visite->ug }}</td>
                <td class="table-action">{{ $visite->ug_mc }}</td>
                <td class="table-action">{{ $visite->specialite }}</td>
                <td class="table-action">{{ $visite->statut_mc }}</td>
                <td class="table-action">{{ $visite->delegue }}</td>
                <td class="table-action">{{ \Carbon\Carbon::parse( $visite->date )->format('d/m/Y') }}</td>
                <td class="table-action">{{ $visite->patient_t }}</td>
                <td class="table-action">{{ $visite->patient }}</td>
                
                @for ($i = 0; $i < count($produits); $i++)
                    <td class="table-action">{{ $visite->{$produits[$i]->designation} }}</td>
                    <td class="table-action">{{ $visite->{$produits[$i]->designation.'_en'} }}</td>
                    <td class="table-action">{{ ($visite->{$produits[$i]->designation}!='')?(($visite->{$produits[$i]->designation.'_emg'}!='')?$visite->{$produits[$i]->designation.'_emg'}:0):'' }}</td>
                    <td class="table-action"></td>
                @endfor

                
                

            </tr>
        @endforeach

    </tbody>
</table>
 