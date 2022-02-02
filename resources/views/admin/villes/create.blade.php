
@extends('layouts.dashboard.designe')

@section('content')

<div id="content-header">
    <div id="breadcrumb"> 
        <a href="{{ route('villes.index') }}" title="{{ __('List Of Cities') }}" class="tip-bottom "><i class="icon-book"></i> {{ __('Cities') }}</a>
      <a href="{{ route('villes.create') }}" title="{{ __('Add City') }}" class="tip-bottom {{ (request()->segment(2) == 'villes') ? 'current' : ''}}"><i class="icon-bar-chart"></i> {{ __('Add City') }}</a>
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
                  <h5>{{__('Add City')}}</h5>
              </div>
               <div class="widget-content nopadding">
                    <form class="form-horizontal" id="form_validation"  method="POST" action="{{ route('villes.store') }}" enctype="multipart/form-data">
                      @csrf
                       
                        @include('admin.villes._form')
                        <div class="form-actions">
                            <button type="submit" id ="save" class="btn btn-success span3 offset4">{{__('Save')}}</button>
 
                        </div>
                      </form>
               </div>
                </div>
            </div>
    </div>

 @endsection
