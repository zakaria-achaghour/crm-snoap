<div class="row-fluid">
    <div class="span6">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>RESULTAT ({{ count($visite_doctors) }})</h5>
             
            </div>
            <div class="widget-content responsive-table nopadding">
                @include('rapports.tableDuoDoctor')
            </div>
        </div>

    </div>
    <div class="span6">

        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>RESULTAT ({{ count($visites) }})</h5>
             
            </div>
            <div class="widget-content responsive-table nopadding">
                @include('rapports.tableDuoPharmacy')
            </div>
        </div>
    </div>

</div>
<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>