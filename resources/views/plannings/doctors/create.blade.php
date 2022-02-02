@extends('layouts.dashboard.designe')
@section('title', __('Clients'))
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('plannings.doctors') }}" title="clients" class="tip-bottom"><i
                    class="icon-book"></i>Plannings médecin</a>
            <a href="{{ route('plannings.create.doctors') }}" title="Ajouter planning"
                class="current">Ajouter planning médecin</a>
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
                        <h5>Nouveau planning médecin</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="#"
                            enctype="multipart/form-data">

                            <!----------------- tag de laravel pour autoriser la modification --->
                            @csrf
                            <!----------------- tag de laravel pour autoriser la modification --->

                            @include('plannings.doctors.form')
                            <div class="control-group" id="pharmacie">
                                <label class="control-label">UG</label>
                                <div class="controls">
                            
                                    <select class="form-control @error('ug') is-invalid @enderror" id="ug" name="ug">
                                        <option value=""></option>
                                        @for ($i = 0; $i < count($ugs); $i++)
                                            <!-- { (old("pharmacie") == $pharmacie[$i]->id  ? "selected":"") }  Define the selected option with the old input -->
                                            <option value="{{ $ugs[$i]->id }}">
                                                {{ $ugs[$i]->designation }} </option>
                                        @endfor
                                    </select>
                                    {{-- <div id='displayUgs'>
                                        @include('helpers.select',['name'=>'ug','data'=>$ugs] )
                                    
                                    </div> --}}
                            
                                    @error('ug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                            </div>

                            <!-------------------- fin champs 19 -------------------------->
                         <hr>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id='displayDoctors'>
        
    </div>
    <!--------------------------------------- end form create ----------------------------------------->
    <script>
         $("#selected_delegue").change(function() {
        
        $("#delegue").val($(this).val());
        // id = $("#delegue").val();
        // var url = "{{route('change.select', [":id"])}}";
        //         url = url.replace(':id', id);
                

        //         $.ajax({
        //             url: url,
        //             cache: false,
        //             success: function(r) {
        //                 $("#displayUgs").hide().html(r).fadeIn(0);
        //             }
        //         });
        
    });
        $("#ug").change(function() {
            
            var de = $("#de").val();
            var a = $("#a").val();
            var delegue = $("#delegue").val();
            if(de<a){
                var id = $("#ug").val();
            
                var url = "{{route('plannings.doctor', [":id",":de",":a"])}}";
                url = url.replace(':id', id);
                url = url.replace(':de', de);
                url = url.replace(':a', a);

                $.ajax({
                    url: url,
                    cache: false,
                    success: function(r) {
                        $("#displayDoctors").hide().html(r).fadeIn(100);
                    }
                });
            }else{
                var url = "{{route('planningError')}}";
                $.ajax({
                    url: url,
                    cache: false,
                    success: function(r) {
                        $("#displayDoctors").hide().html(r).fadeIn(100);
                    }
                });
            }
            
        });

    </script>
@endsection

