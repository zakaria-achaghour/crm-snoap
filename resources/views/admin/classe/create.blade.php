@extends('layouts.dashboard.designe')
@section('title','Classes')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('classes.index') }}" title="List Des classes" class="tip-bottom "><i
                    class="icon-book"></i> Classes</a>
            <a href="{{ route('classes.create') }}" title="Ajouter classe"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i>Ajouter classe</a>
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
                    <h5>Ajouter classe</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" id="form_validation" method="POST" action="{{ route('classes.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('admin.classe._form')
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
