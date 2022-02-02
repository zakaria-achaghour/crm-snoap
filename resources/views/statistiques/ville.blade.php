<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>{{ __("List of clients")}}</h5>
            {{-- <a href="{{ route('exporter_view',['ville',$id]) }}"target="_blank" class="btn btn-success btn-mini add-action"><i class="icon icon-download-alt"></i> Exporter</a> --}}

        </div>
        <div class="widget-content nopadding">
                 @include('statistiques.tableVilles')
        </div>
    </div>
</div>
    
    <script src="{{ asset('layout/js/bootstrap.js') }}"></script>
    <script src="{{ asset('layout/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('layout/js/jquery.uniform.js') }}"></script>
    <script src="{{ asset('layout/js/select21.min.js') }}"></script>
    <script src="{{ asset('layout/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('layout/js/matrix.js') }}"></script>
    <script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
    <script src="{{ asset('layout/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('layout/js/jquery.datetimepicker.min.js') }}"></script>
    
