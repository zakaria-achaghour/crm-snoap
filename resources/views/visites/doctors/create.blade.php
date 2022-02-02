@extends('layouts.dashboard.designe')
@section('title','Create Visite Doctor')
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('visites.index.doctor') }}" title="clients" class="tip-bottom"><i
                    class="icon-book"></i> Visites </a>
            <a href="#" title="Ajouter une visite" class="current">Ajouter une visite</a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <!-- container assemble the form -->
    <div class="container-fluid">
        <hr>
        
                       
        <form class="form-horizontal" method="post" action="{{ route('visites.store.doctor') }}" enctype="multipart/form-data">


            @csrf
            
                    
            @include('visites.doctors._form_visite')
<!--                     
                
            <div id="displayProduct"></div>
            <div id="displayCommande"></div>
            <div id="displayDuo"></div>
            <div id="displayPlv"></div>
            <div id="displayEmg"></div> -->



            
        </form>
    </div>

    <link rel="stylesheet" href="{{ asset('layout/css/multi.min.css') }}" />
    <script src="{{ asset('layout/js/multi.min.js') }}"></script>
    <!--------------------------------------- end form create ----------------------------------------->
@endsection
