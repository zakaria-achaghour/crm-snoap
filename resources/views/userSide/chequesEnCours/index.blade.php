@extends('layouts.dashboard.designe')
@section('title', __('Checks In Progress'))
@section('content')



    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('clients.chequesencours') }}" title="chequesencours"
                class="tip-bottom {{ request()->segment(1) == 'chequesencours' ? 'current' : '' }}">
                <i class="icon-book"></i> {{ __('Checks In Progress') }}</a>
        </div>
    </div>
    <!--End-breadcrumbs-->
    <div class="container-fluid">
        <hr>
        <div class="form-actions">
            {{-- <a href="{{ route('recouvrement.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
                {{ __('Add a Check') }}</a> --}}
        </div>
    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>{{ __('List of clients') }}</h5>

        {{-- <a href="{{ route('exporter_view',['recouvrement','0']) }}"target="_blank" class="btn btn-success btn-mini add-action"><i class="icon icon-download-alt"></i> Exporter</a>
        --}}
            </div>
            <div class="widget-content nopadding">
               @include('userSide.chequesEnCours.table')
            </div>
        </div>
    </div>
</div>

@endsection