<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>{{ __('Loc With Missing Information')}}</h5>
            {{-- <a href="{{ route('exporter_view',['infoManque','0']) }}"target="_blank" class="btn btn-success btn-mini add-action"><i class="icon icon-download-alt"></i> Exporter</a> --}}
            
        </div>
        <div class="widget-content nopadding">
            @include('statistiques.tableInfoManquant')
        </div>
    </div>
</div>
<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>