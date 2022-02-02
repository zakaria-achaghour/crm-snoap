
@extends('layouts.dashboard.designe')
@section('title', 'Objectifs')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">

            <a href="{{ route('objectifs.index') }}" title="objectifs" class="tip-bottom ">
                <i class="icon-book"></i> Objectifs</a>
            <a href="{{ route('objectifs.create') }}" title="Ajouter Catégorie " class="tip-bottom current"><i
                    class="icon-bar-chart"></i> Ajouter Objectif</a>
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
                    <h5>Ajouter Objectif </h5>
                </div>
                <div class="widget-content nopadding">


                    <form class="form-horizontal" method="post"   enctype="multipart/form-data">
                        
                        @csrf
                        <input type="hidden" id="objectif_id" value="{{$objectif_id}}">
                        <div class="control-group">
                            <label class="control-label" for="products_objectif">Article</label>
                            <div class="controls">
                            <select  class="form-control span8 @error('products_objectif') is-invalid @enderror" id="products_objectif" name="products_objectif">
                                <option value=""></option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}" >{{ $product->designation}}</</option>
                                @endforeach
                            </select>
                            <!------- error message --------->
                            @error('products_objectif')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                            
                        <div class="control-group">
                            <label for="qte" class="control-label ">Qte</label>
                            <div class="controls ">
                                <input type="number" class="span8 form-control @error('qte') is-invalid @enderror" name="qte" id="qte"
                                    value="{{ old('qte', $objectif->qte ?? null) }}">
                                @error('qte')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-actions">
                            <button type="submit" id="saveObjectifProduct"
                                class="btn btn-success span3 offset4">{{ __('Save') }}</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="dipsplayTabProduct">

        </div>
    </div>
    

<script>
    
        
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var objectif_id = $("#objectif_id").val();
    
    $.ajax({
        type: 'GET',
        url: '/objectifs/product/table/'+objectif_id,
        success: function(data) {
            $("#dipsplayTabProduct").hide().html(data).fadeIn(10);
        }
    });

    $('#saveObjectifProduct').click(function(e) {
       
        if ($("#products_objectif").val() == "" &&  $("input[name=qte]").val() ==null ) {

        }else {
            e.preventDefault();
            var product_id = $("#products_objectif").val();
            $("#products_objectif option:selected").remove();
            $("#products_objectif option:first").attr('selected', 'selected');
          
            var qteProduct = $("input[name=qte]").val();

            $("input[name=qte]").val('');
            $.ajax({
                type: 'POST',
                url: "{{ route('objectifs.affecter.product') }}",
                data: {
                    objectif_id: objectif_id,
                    product_id: product_id,
                    qte: qteProduct,
                    
                },
                success: function(data) {
                    $("#dipsplayTabProduct").hide().html(data).fadeIn(100);
                    
                }
            });

        }
        

    });
    
</script>
@endsection
