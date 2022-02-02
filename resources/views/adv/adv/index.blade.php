@extends('layouts.dashboard.designe')
@section('title', 'ADVS')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('advs.index') }}" title="Liste des ADV"
                class="current tip-bottom {{ request()->segment(1) == 'advs' ? 'current' : '' }}">
                <i class="icon-book"></i>ADV</a>
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
