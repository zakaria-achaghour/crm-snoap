
@extends('layouts.dashboard.designe')

@section('content')


    <!--breadcrumbs-->
    <div id="content-header">
     
        <div id="breadcrumb"> 
            <a href="{{ route('villes.index') }}" title="{{ __('List Of Cities') }}" class="tip-bottom"><i class="icon-book"></i> {{ __('Cities') }}</a>
          <a href="" title="{{ __('Edit City') }}" class="tip-bottom {{ (request()->segment(2) == 'villes') ? 'current' : ''}}"><i class="icon-bar-chart"></i> {{ __('Edit City') }}</a>
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
                  <h5>{{__('Edit City')}}</h5>
              </div>
             <div class="widget-content nopadding">
                      <form  class="form-horizontal" method="POST" action="{{ route('villes.update',['ville'=>$ville->id]) }}" >
                        @csrf
                        @method('PUT')
                        @include('admin.villes._form')
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success span2  offset3">{{__('Update')}}</button>
                            <a href="{{ route('villes.index') }}" class="btn btn-warning span2  ">{{__('Back')}}</a>

 
                        </div>
                      </form>
             </div>
                </div>
            </div>
    </div>

            
 @endsection
