@extends('layouts.dashboard.designe')
@section('title', 'num ugs')
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">

        <div id="breadcrumb">
            <a href="{{ route('numugs.index') }}" title="List Des num ugs" class="tip-bottom"><i
                    class="icon-book"></i> num ugs</a>
            <a href="" title="Modifier num ugs"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i>Modifier num ugs</a>
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
                    <h5>Modifier num ugs</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST"
                        action="{{ route('numugs.update', ['numug' => $num]) }}">
                        @csrf
                        @method('PUT')

                        @include('admin.numug._form')
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success span2  offset3">{{ __('Update') }}</button>
                            <a href="{{ route('numugs.index') }}" class="btn btn-warning span2  ">{{ __('Back') }}</a>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
