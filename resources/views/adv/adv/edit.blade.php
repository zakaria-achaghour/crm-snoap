@extends('layouts.dashboard.designe')
@section('title', 'ADV')
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('advs.index') }}" title="Liste Des ADV" class="tip-bottom "><i
                class="icon-book"></i> ADV</a>
        <a href="{{ route('advs.create') }}" title="Ajouter ADV"
            class="tip-bottom current"><i
                class="icon-bar-chart"></i>Ajouter ADV</a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <div class="container-fluid">
        <hr>
        <!-- ============================================================== -->
        <!-- Start Form Create User -->
        <!-- ============================================================== -->
        <div class="row-fluid">
           
                
                <form class="form-horizontal" method="post" action="#" enctype="multipart/form-data">
                    @csrf

                    @include('adv.adv._form_show')

                    <input type="hidden" id="adv" value="{{ $adv->id }}">
                    <input type="hidden" id="step" value="{{ $adv->step }}">
                    <div id="displayFormProduct"></div>
                </form>
              
        </div>
    </div>
    <script>
    $(document).ready(function() {
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var adv = $('#adv').val();

        $.ajax({
            type: 'GET',
            url: '/advs/products/forms/'+adv ,
            success: function(data) {
                $("#displayFormProduct").hide().html(data).fadeIn(10);
            }
        });

    
        
 
    });

     if($('.step').val()>=1){
        $('.productsSelect').hide();
     }
        
    </script>
    

@endsection