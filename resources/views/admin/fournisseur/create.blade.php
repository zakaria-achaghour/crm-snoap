
@extends('layouts.dashboard.designe')
@section('title', 'Fournisseurs')
@section('content')

<div id="content-header">
    <div id="breadcrumb"> 
        <a href="{{ route('fournisseurs.index') }}" title="list Of fournisseurs" class="tip-bottom ">
            <i class="icon-book"></i> Fournisseurs</a>
      <a href="{{ route('fournisseurs.create') }}" title="{{ __('Add Fournisseur') }}" class="tip-bottom current"><i class="icon-bar-chart"></i> {{ __('Add Fournisseur') }}</a>
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
                  <h5>{{__('Add Fournisseur')}}</h5>
              </div>
               <div class="widget-content nopadding">
                    <form class="form-horizontal"   method="POST" action="{{ route('fournisseurs.store') }}" enctype="multipart/form-data">
                      @csrf
                       
                        @include('admin.fournisseur._form')
                        <div class="form-actions">
                            <button type="submit" id ="save" class="btn btn-success span3 offset4">{{__('Save')}}</button>
 
                        </div>
                      </form>
               </div>
                </div>
            </div>
    </div>

 @endsection
