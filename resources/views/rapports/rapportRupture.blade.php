<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-ban-circle"></i></span>
            <h5>RESULTAT ({{ count($products) }})</h5>
            <a href="{{ route('exporter.rupture',['de'=>$de, 'a'=>$a, 'ugs'=>$ugs, 'produits'=>$produits]) }}"target="_blank" class="btn btn-success btn-mini add-action"><i class="icon icon-download-alt"></i> Exporter</a>
        </div>
        <div class="widget-content responsive-table nopadding">
            @include('rapports.tableRupture')
        </div>
    </div>
</div>
<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>