@extends('layouts.dashboard.designe')
@section('title', 'Visites')
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('visites.index.doctor') }}" title="clients" class="tip-bottom"><i
                    class="icon-book"></i> Visite</a>
            <a href="" title="Demande change control" class="current">
                Modifier une visite </a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <!-- container assemble the form -->
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span11">
                
                <form class="form-horizontal" method="post" action="#" enctype="multipart/form-data">
                    @csrf
                    
                    @include('visites.doctors._form_visite')
                    {{-- <div id="displayDoctor"></div> --}}
                    <div id="displayProduct"></div>
                   {{--  <div id="displayCommande"></div> --}}
                    <div id="displayDuo"></div>
                    <div id="displayPlv"></div>
                    <div id="displayEmg"></div>
                    <div id="displayDemandeSpecial"></div>

                </form>
            </div>

        </div>
    </div>
    <link rel="stylesheet" href="{{ asset('layout/css/multi.min.css') }}" />
    <script src="{{ asset('layout/js/multi.min.js') }}"></script>
    <script>
     
        var visiteId = $("#visiteID").val();
        var doctor_id = $("#doctorId").val();

            var url = "{{route('visites.DisplayProduct.doctor', ":id")}}";
            url = url.replace(':id', visiteId);
        
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    $("#displayProduct").hide().html(data).fadeIn(100);
                }
            });

        
        
        
    </script>
    
@endsection