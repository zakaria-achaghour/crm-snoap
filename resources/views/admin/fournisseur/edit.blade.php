@extends('layouts.dashboard.designe')
@section('title', 'Fournisseurs')
@section('content')


    <!--breadcrumbs-->
    <div id="content-header">
     
        <div id="breadcrumb"> 
            <a href="{{ route('fournisseurs.index') }}" title="{{ __('List Of Fournisseurs') }}" class="tip-bottom ">
                <i class="icon-book"></i> Fournisseurs</a>
          <a href="" title="edit Fournisseur" class="tip-bottom current"><i class="icon-bar-chart"></i> {{ __('Edit Fournisseurs') }}</a>
       </div> </div>
  <!--End-breadcrumbs-->
  
    <div class="container-fluid">
        <hr>
             <!-- ============================================================== -->
            <!-- Start Form Create User -->
            <!-- ============================================================== -->
            <div class="row-fluid">
              <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                  <h5>{{ __('Edit Fournisseur') }}</h5>
              </div>
             <div class="widget-content nopadding">
                      <form  class="form-horizontal" method="POST" action="{{ route('fournisseurs.update',['fournisseur'=>$fournisseur->id]) }}" >
                        @csrf
                        @method('PUT')
                        @include('admin.fournisseur._form')
                        <div class="form-actions">
                            <button type="submit" id ="save" class="btn btn-success span2  offset3">{{__('Update')}}</button>
                            <a href="{{ route('fournisseurs.index') }}" class="btn btn-warning span2  ">{{__('Back')}}</a>
                        </div>
                      </form>
             </div>
                </div>
            </div>
    </div>

            
 @endsection
