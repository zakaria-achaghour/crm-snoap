<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>RESULTAT ({{ count($visites) }})</h5>
            <a href="{{ route('rapport.visite.nombres.exporter',['de'=>$de, 'a'=>$a, 'delegues'=>$delegues]) }}"target="_blank" class="btn btn-success btn-mini add-action"><i class="icon icon-download-alt"></i> Exporter</a>
            
        </div>
        <div class="widget-content responsive-table nopadding">
            @include('rapports.tableNombres')
        </div>
    </div>
</div>
<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>