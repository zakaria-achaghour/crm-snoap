@extends('layouts.dashboard.designe')
@section('title','DCI')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('dcis.index') }}" title="List Des dciS" class="tip-bottom "><i
                    class="icon-book"></i> DCI</a>
            <a href="{{ route('dcis.create') }}" title="Ajouter dci"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i>Ajouter dci</a>
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
                    <h5>Ajouter dci</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" id="form_validation" method="POST" action="{{ route('dcis.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('admin.dci._form')
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
