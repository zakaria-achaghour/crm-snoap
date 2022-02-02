@extends('layouts.dashboard.designe')
@section('title','UGS')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('ugs.index') }}" title="List Des UGS" class="tip-bottom "><i
                    class="icon-book"></i> {{ __('Regions') }}</a>
            <a href="{{ route('ugs.create') }}" title="Ajouter UG"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i>Ajouter UG</a>
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
                    <h5>Ajouter UG</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" id="form_validation" method="POST" action="{{ route('ugs.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('admin.ug._form')
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
