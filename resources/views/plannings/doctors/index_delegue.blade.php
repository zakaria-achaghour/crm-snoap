@extends('layouts.dashboard.designe')
@section('title', 'plannings doctor')

@section('content')
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> 
        <a href="{{ route('plannings.doctors') }}" title="Plannings Doctors" class="tip-bottom current">
            <i class="icon-book"></i>
            Planning médecin
        </a>
    </div>
</div>
<!--End-breadcrumbs-->
<div class="container-fluid">
    <hr>
    <div class="form-actions">
        <a href="{{ route('plannings.create.doctors') }}" class="btn btn-success btn-large"><i class="icon icon-plus"></i>
            Nouveau planning 
        </a>
    </div>
    <input type="hidden" id="user" value="{{ Auth::id()}}">

    @include('plannings.doctors.recherche_date')




    <!-- Modal -->

    @endsection