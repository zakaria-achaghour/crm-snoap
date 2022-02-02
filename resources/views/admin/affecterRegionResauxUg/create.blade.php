@extends('layouts.dashboard.designe')
@section('title', 'Affecter')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">
   
                    <a href="{{ route('affecter.index') }}" 
                    class="current tip-bottom ">
                    <i class="icon-book"></i> Affecter</a>
            <a href="{{ route('affecter.create') }}" 
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i> Affecter</a>
        </div>
    </div>


    <div class="container-fluid">
        <hr>
        <!-- ============================================================== -->
        <!-- Start Form Create User -->
        <!-- ============================================================== -->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Affecter</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" id="form_validation" method="POST" action="{{ route('affecter.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('admin.affecterRegionResauxUg._form')
                        <div class="form-actions">
                            <button type="submit" id="save"
                                class="btn btn-success span3 offset4">{{ __('Save') }}</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
