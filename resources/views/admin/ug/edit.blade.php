@extends('layouts.dashboard.designe')
@section('title', 'UGS')
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">

        <div id="breadcrumb">
            <a href="{{ route('ugs.index') }}" title="List Des UGS" class="tip-bottom"><i
                    class="icon-book"></i> {{ __('ugs') }}</a>
            <a href="" title="Modifier UG"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i>Modifier UG</a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <div class="container-fluid">
        <hr>
        <!-- ============================================================== -->
        <!-- Start Form Create User -->
        <!-- ============================================================== -->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Modifier UG</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST"
                        action="{{ route('ugs.update', ['ug' => $ug->id]) }}">
                        @csrf
                        @method('PUT')

                        @include('admin.ug._form')
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success span2  offset3">{{ __('Update') }}</button>
                            <a href="{{ route('ugs.index') }}" class="btn btn-warning span2  ">{{ __('Back') }}</a>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
