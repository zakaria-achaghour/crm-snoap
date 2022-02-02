<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th rowspan="2"  style="background: yellow">Délégue</th>
            <th colspan=5 style="background: yellow">Visites Médecine</th>
            <th rowspan="2"  style="background: yellow">Visites Pharmacie</th>
            <th  rowspan="2" style="background: yellow">Commande</th>

        </tr>
        <tr>
           
                <th style="background: yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="background: yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="background: yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="background: yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="background: yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                


        </tr>
        
    </thead>
    <tbody>

        @foreach ($visites as $key=> $visite)
            
            <tr>
                <td class="table-action">{{ $visite->firstname.' '. $visite->lastname}}</td>
                <td class="table-action">{{ ($visite->ps=='')?0:$visite->ps}}</td>
                <td class="table-action">{{ ($visite->pg=='')?0:$visite->pg}}</td>
                <td class="table-action">{{ ($visite->hs=='')?0:$visite->hs}}</td>
                <td class="table-action">{{ ($visite->hg=='')?0:$visite->hg}}</td>
                <td class="table-action">{{ (($visite->ps=='')?0:$visite->ps) + (($visite->pg=='')?0:$visite->pg) + (($visite->hs=='')?0:$visite->hs) + (($visite->hg=='')?0:$visite->hg)  }}</td>


                <td class="table-action">{{ ($visite->nbPharma=='')?0:$visite->nbPharma}}</td>
                <td class="table-action">{{ ($visite->commande=='')?'0':$visite->commande }}</td>

            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>    
            <th >Total</th>
                <td colspan=5 class="table-action">{{ $nbMed }}</td>
                <td class="table-action">{{ $nbPharma }}</td>
                <td class="table-action">{{ $commande }}</td>
        </tr>
    </tfoot>

</table>
 