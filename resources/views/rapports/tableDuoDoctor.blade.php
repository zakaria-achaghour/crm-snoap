<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th  style="background: yellow">Dr</th>
            <th  style="background: yellow">Date</th>
            <th  style="background: yellow">Responsable</th>
            <th  style="background: yellow">Délégué</th>
        </tr>
        
    </thead>
    <tbody>

        @foreach ($visite_doctors as $key=> $visite_doctor)
        
            <tr>
                <td class="table-action">{{ $visite_doctor->doctor }}</td>
                <td class="table-action">{{ $visite_doctor->created_at }}</td>
                <td class="table-action">{{ $visite_doctor->responsable }}</td>
                <td class="table-action">{{ $visite_doctor->delegue }}</td>
            </tr>
            
        @endforeach
        
    </tbody>

</table>
 