@extends('layouts.dashboard.designe')
@section('title', __('Clients'))
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('visites.index.pharmacy') }}" title="clients" class="tip-bottom"><i
                    class="icon-book"></i> Visite</a>
            <a href="#" title="Demande change control" class="current">Ajouter une visite</a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <!-- container assemble the form -->
    <div class="container-fluid">
        <hr>
        
                       
        <form class="form-horizontal" method="post" action="{{ route('visites.store.pharmacy') }}" enctype="multipart/form-data">


            @csrf
            
                    
            @include('visites.pharmacy._form_visite')




            
        </form>
    </div>

    <link rel="stylesheet" href="{{ asset('layout/css/multi.min.css') }}" />
    <script src="{{ asset('layout/js/multi.min.js') }}"></script>
    <!--------------------------------------- end form create ----------------------------------------->
@endsection
