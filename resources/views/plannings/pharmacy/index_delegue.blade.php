@extends('layouts.dashboard.designe')
@section('title', __('Visites'))
@section('content')
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> 
        <a href="{{ route('plannings.index.pharmacies') }}" title="Plannings" class="tip-bottom current">
            <i class="icon-book"></i>
            Planning
        </a>
    </div>
</div>
<!--End-breadcrumbs-->
<div class="container-fluid">
    <hr>
    <div class="form-actions">
        <a href="{{ route('plannings.create.pharmacies') }}" class="btn btn-success btn-large"><i class="icon icon-plus"></i>
            Nouveau planning
        </a>
    </div>
    <input type="hidden" id="user" value="{{ Auth::id()}}">

    @include('plannings.pharmacy.recherche_date')




    <!-- Modal -->

    @endsection