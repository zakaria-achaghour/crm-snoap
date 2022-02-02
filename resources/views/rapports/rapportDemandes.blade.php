<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>RESULTAT ({{ count($visites) }})</h5>
        </div>
        <div class="widget-content responsive-table nopadding">
            @include('rapports.tableDemandes')
        </div>
    </div>
</div>
<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>