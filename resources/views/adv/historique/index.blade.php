@extends('layouts.dashboard.designe')
@section('title','ADVS')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('advs.historique') }}" title="Liste des ADV"
                class="current tip-bottom {{ request()->segment(1) == 'advs' ? 'current' : '' }}">
                <i class="icon-book"></i>ADV Historique</a>
        </div> 
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>


        @include('adv.table')

    </div>
@endsection