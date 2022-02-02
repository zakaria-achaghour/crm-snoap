@extends('layouts.dashboard.designe')
@section('title', 'DCI')
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">

        <div id="breadcrumb">
            <a href="{{ route('dcis.index') }}" title="List Des dcis" class="tip-bottom"><i
                    class="icon-book"></i> {{ __('dcis') }}</a>
            <a href="" title="Modifier dci"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i>Modifier dci</a>
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
                    <h5>Modifier dci</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST"
                        action="{{ route('dcis.update', ['dci' => $dci->id]) }}">
                        @csrf
                        @method('PUT')

                        @include('admin.dci._form')
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success span2  offset3">{{ __('Update') }}</button>
                            <a href="{{ route('dcis.index') }}" class="btn btn-warning span2  ">{{ __('Back') }}</a>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
