<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-ban-circle"></i></span>
            <h5>RESULTAT ({{ count($autres) }})</h5>
        </div>
        <div class="widget-content responsive-table nopadding">
            @include('rapports.tableAutre')
        </div>
    </div>
</div>
<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>