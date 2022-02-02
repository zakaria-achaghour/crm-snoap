@extends('layouts.dashboard.designe')
@section('title','ADVS')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('advs.cree') }}" title="Liste des ADV Créé"
                class="current tip-bottom {{ request()->segment(2) == 'cree' ? 'current' : '' }}">
                <i class="icon-book"></i>ADV Créer</a>
        </div> 
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">

            <a href="{{ route('advs.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
              Ajouter Dépense</a>

        </div>

        @include('adv.table')

    </div>
@endsection