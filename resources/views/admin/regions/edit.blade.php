@extends('layouts.dashboard.designe')
@section('title', __('Regions'))
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">

        <div id="breadcrumb">
            <a href="{{ route('regions.index') }}" title="{{ __('List Of Regions') }}" class="tip-bottom"><i
                    class="icon-book"></i> {{ __('Regions') }}</a>
            <a href="" title="{{ __('Edit Region') }}"
                class="tip-bottom {{ request()->segment(2) == 'regions' ? 'current' : '' }}"><i
                    class="icon-bar-chart"></i> {{ __('Edit Region') }}</a>
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
                    <h5>{{ __('Edit Region') }}</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST"
                        action="{{ route('regions.update', ['region' => $region->id]) }}">
                        @csrf
                        @method('PUT')

                        @include('admin.regions._form')
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success span2  offset3">{{ __('Update') }}</button>
                            <a href="{{ route('regions.index') }}" class="btn btn-warning span2  ">{{ __('Back') }}</a>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
