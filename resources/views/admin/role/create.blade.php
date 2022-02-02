
@extends('layouts.dashboard.designe')
@section('title', 'Roles')
@section('content')

<div id="content-header">
    <div id="breadcrumb"> 
        <a href="{{ route('roles.index') }}" title="{{ __('List Of Roles') }}" class="tip-bottom ">
            <i class="icon-book"></i> Roles</a>
      <a href="{{ route('roles.create') }}" title="{{ __('Add Role') }}" class="tip-bottom current"><i class="icon-bar-chart"></i> {{ __('Add Role') }}</a>
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
                  <h5>{{__('Add Role')}}</h5>
              </div>
               <div class="widget-content nopadding">
                    <form class="form-horizontal"   method="POST" action="{{ route('roles.store') }}" enctype="multipart/form-data">
                      @csrf
                       
                        @include('admin.role._form')
                        <div class="form-actions">
                            <button type="submit" id ="save" class="btn btn-success span3 offset4">{{__('Save')}}</button>
 
                        </div>
                      </form>
               </div>
                </div>
            </div>
    </div>

 @endsection
