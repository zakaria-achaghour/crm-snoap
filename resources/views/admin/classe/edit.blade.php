@extends('layouts.dashboard.designe')
@section('title', 'Classes')
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">

        <div id="breadcrumb">
            <a href="{{ route('classes.index') }}" title="List Des classes" class="tip-bottom"><i
                    class="icon-book"></i> {{ __('classes') }}</a>
            <a href="" title="Modifier classe"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i>Modifier classe</a>
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
                    <h5>Modifier classe</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST"
                        action="{{ route('classes.update', ['class' => $classe->id]) }}">
                        @csrf
                        @method('PUT')

                        @include('admin.classe._form')
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success span2  offset3">{{ __('Update') }}</button>
                            <a href="{{ route('classes.index') }}" class="btn btn-warning span2  ">{{ __('Back') }}</a>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
