@extends('layouts.dashboard.designe')
@section('title', 'visites Médecins' )
@section('content')
   <!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> 
        <a href="{{ route('plannings.doctors') }}" title="Plannings" class="tip-bottom current">
            <i class="icon-book"></i>
            VISITE Médecin
        </a>
    </div>
</div>
<!--End-breadcrumbs-->
<div class="container-fluid">
    <hr>
    <input type="hidden" id="user" value="{{ Auth::id()}}">

    @include('visites.doctors.recherche_date')

</div>

@endsection
