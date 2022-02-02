@extends('layouts.dashboard.designe')
@section('title', 'Visites')
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('visites.index.pharmacy') }}" title="clients" class="tip-bottom"><i
                    class="icon-book"></i> Visite</a>
            <a href="" title="Demande change control" class="current">
                Modifier une visite</a>
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
                    
                    @include('visites.pharmacy._form_visite')
                    <div id="displayDoctor"></div>
                    <div id="displayProduct"></div>
                    <div id="displayRupture"></div>
                    <div id="displayCommande"></div>
                    <div id="displayDuo"></div>
                    <div id="displayPlv"></div>
                    <div id="displayEmg"></div>
                </form>
            </div>

        </div>
    </div>
    <link rel="stylesheet" href="{{ asset('layout/css/multi.min.css') }}" />
    <script src="{{ asset('layout/js/multi.min.js') }}"></script>
    <script>
     
        var visiteId = $("#visiteID").val();
        var doctor_id = $("#doctorId").val();

        if($('#t_enq_ref').val()==1||$('#t_enq_rp').val()==1){
            
            var url = "{{route('visites.DisplayDoctor.pharmacy', [":visite",":doctor"])}}";
             url = url.replace(':visite', visiteId);
             url = url.replace(':doctor', doctor_id);

            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    $("#displayDoctor").hide().html(data).fadeIn(10);
                }
            });
            
        }else{
            var url = "{{route('visites.DisplayProduct.pharmacy', [":visite"])}}";
             url = url.replace(':visite', visiteId);
             
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    $("#displayProduct").hide().html(data).fadeIn(10);
                }
            });

        }
        
        
    </script>
    
@endsection