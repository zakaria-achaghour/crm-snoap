@extends('layouts.dashboard.designe')
@section('title', 'plv')
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">

        <div id="breadcrumb">
            <a href="{{ route('plvs.index') }}" title="List Des plvs" class="tip-bottom"><i
                    class="icon-book"></i> {{ __('plvs') }}</a>
            <a href="" title="Modifier plv"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i>Modifier plv</a>
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
                    <h5>Modifier plv</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST"
                        action="{{ route('plvs.update', ['plv' => $plv->id]) }}">
                        @csrf
                        @method('PUT')

                        @include('admin.plv._form')
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success span2  offset3">{{ __('Update') }}</button>
                            <a href="{{ route('plvs.index') }}" class="btn btn-warning span2  ">{{ __('Back') }}</a>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
