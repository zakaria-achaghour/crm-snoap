@extends('layouts.dashboard.designe')
@section('title', __('Visites'))
@section('content')
   <!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> 
        <a href="{{ route('plannings.index.pharmacies') }}" title="Plannings" class="tip-bottom current">
            <i class="icon-book"></i>
            VISITE
        </a>
    </div>
</div>
<!--End-breadcrumbs-->
<div class="container-fluid">
    <hr>
    <input type="hidden" id="user" value="{{ Auth::id()}}">

    @include('visites.pharmacy.recherche_date')

</div>

@endsection
