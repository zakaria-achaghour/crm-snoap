
@extends('layouts.dashboard.designe')
@section('title', 'Utilisateurs')
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">
      <div id="breadcrumb"> 
          <a href="{{ route('users.index') }}" title="{{ __('List Of Users') }}" class="tip-bottom "><i class="icon-book"></i> {{ __('Users') }}</a>
        <a href="{{ route('users.create') }}" title="{{ __('Add User') }}" class="tip-bottom current"><i class="icon-bar-chart"></i> {{ __('Add User') }}</a>
      </div>  </div>
  <!--End-breadcrumbs-->
  
    <div class="container-fluid">
        <hr>
             <!-- ============================================================== -->
            <!-- Start Form Create User -->
            <!-- ============================================================== -->
            <div class="row-fluid">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                      <h5>{{__('Add User')}}</h5>
                  </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" id="form_validation"  method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                      @csrf
                       
                        @include('admin.users._form')
                        <div class="form-actions">
                            <button type="submit" id ="save" class="btn btn-success span3 offset4">{{__('Save')}}</button>
 
                        </div>
                      </form>
                </div>
                </div>
            </div>
    </div>

            
 @endsection
