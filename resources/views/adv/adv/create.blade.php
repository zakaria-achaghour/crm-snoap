@extends('layouts.dashboard.designe')
@section('title','ADVS')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('advs.index') }}" title="Liste Des ADV" class="tip-bottom "><i
                    class="icon-book"></i> ADV</a>
            <a href="{{ route('advs.create') }}" title="Ajouter ADV"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i>Ajouter ADV</a>
        </div>
    </div>


    <div class="container-fluid">
        <hr>
        <!-- ============================================================== -->
        <!-- Start Form Create User -->
        <!-- ============================================================== -->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Creation ADV</h5>
                </div>
                <div class="widget-content ">
                    <form class="form-horizontal" id="form_validation" method="POST" action="{{ route('advs.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('adv.adv._form')

                     
                        
                        <div class="form-actions">
                            <button class="btn btn-success btn-large">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // $('.saveAdv').click(function(e) {
           
        //     e.preventDefault();
        //     var productID = $("#porduit_fini").val();
            
        //     $.ajax({
        //         type: 'POST',
        //         url: "{{ route('visites.product.doctor') }}",
        //         data: {
        //             visiteId: visiteId,
        //             productID: productID,
        //             qteProduct: qteProduct,
        //             misenplace: misenplace
        //         },
        //         success: function(data) {
        //             $("#displayProductTable").hide().html(data).fadeIn(100);
                    
        //         }
        //     });
        

        // });
    </script>


@endsection



