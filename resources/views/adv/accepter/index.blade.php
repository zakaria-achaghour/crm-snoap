@extends('layouts.dashboard.designe')
@section('title','ADVS')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('advs.accepte') }}" title="Liste des ADV Accepté"
                class="current tip-bottom {{ request()->segment(2) == 'accepte' ? 'current' : '' }}">
                <i class="icon-book"></i>ADV Accepté</a>
        </div> 
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">

            {{-- <a href="{{ route('advs.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
              Ajouter Dépense</a> --}}

        </div>

        @include('adv.table')

    </div>
@endsection