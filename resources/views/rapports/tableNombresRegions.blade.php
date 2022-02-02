<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th  rowspan="2"  style="background: yellow">Region</th>
            <th  colspan=4 style="background: yellow">Visites Médecine</th>
            <th   rowspan="2" style="background: yellow">Visites Pharmacie</th>
           

        </tr>
        <tr>
           
            <th style="background: yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th style="background: yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th style="background: yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th style="background: yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            


    </tr>
    </thead>
    
    <tbody>

        @foreach ($visites as $key=> $visite)
            
            <tr>
                <td class="table-action">{{ $visite->designation }}</td>
                <td class="table-action">{{ ($visite->ps=='')?0:$visite->ps}}</td>
                <td class="table-action">{{ ($visite->pg=='')?0:$visite->pg}}</td>
                <td class="table-action">{{ ($visite->hs=='')?0:$visite->hs}}</td>
                <td class="table-action">{{ ($visite->hg=='')?0:$visite->hg}}</td>
                <td class="table-action">{{ ($visite->visitePharma=='')?0:$visite->visitePharma}}</td>
              

            </tr>
        @endforeach
    </tbody>
    <tfoot>
    
        <tr>    
            <th >Total</th>
                <td colspan=4 class="table-action">{{ $visiteMed }}</td>
                <td class="table-action">{{ $visitePharma }}</td>
        </tr>
    </tfoot>

    
</table>
 