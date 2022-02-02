@extends('layouts.dashboard.designe')
@section('title', __('Clients'))
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('plannings.index.pharmacies') }}" title="clients" class="tip-bottom"><i
                    class="icon-book"></i>Plannings pharmacie</a>
            <a href="{{ route('plannings.create.pharmacies') }}" title="Ajouter planning"
                class="current">Ajouter planning pharmacie</a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <!-- container assemble the form -->
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                        <h5>Nouveau planning pharmacie</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="#"
                            enctype="multipart/form-data">

                            <!----------------- tag de laravel pour autoriser la modification --->
                            @csrf
                            <!----------------- tag de laravel pour autoriser la modification --->

                            @include('plannings.pharmacy.form')

                            <!-------------------- fin champs 19 -------------------------->
                         <hr>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id='displayClient'>
        
    </div>
    <!--------------------------------------- end form create ----------------------------------------->
    <script>
        
        $("#ug").change(function() {
            
            var de = $("#de").val();
            var a = $("#a").val();
            var delegue = $("#delegue").val();
            if(de<a){
                var id = $("#ug").val();
                var url = "{{route('plannings.pharmacies', [":id",":de",":a"])}}";
                url = url.replace(':id', id);
                url = url.replace(':de', de);
                url = url.replace(':a', a);
                $.ajax({
                    url: url,
                    cache: false,
                    success: function(r) {
                        $("#displayClient").hide().html(r).fadeIn(100);
                    }
                });
            }else{
                var url = "{{route('planningError')}}";
                $.ajax({
                    url: url,
                    cache: false,
                    success: function(r) {
                        $("#displayClient").hide().html(r).fadeIn(100);
                    }
                });
            }
            
        });

    </script>
@endsection

