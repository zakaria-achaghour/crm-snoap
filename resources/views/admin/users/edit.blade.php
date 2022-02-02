
@extends('layouts.dashboard.designe')
@section('title', 'Utilisateurs')
@section('content')


    <!--breadcrumbs-->
    <div id="content-header">
      <div id="breadcrumb"> 
         <a href="{{ route('users.index') }}" title="{{ __('List Of Users') }}" class="tip-bottom "><i class="icon-book"></i> {{ __('Users') }}</a>
       <a href=" " title="{{ __('Edit User') }}" class="tip-bottom current"><i class="icon-bar-chart "></i> {{ __('Edit User') }}</a>
     </div>
     </div>
  <!--End-breadcrumbs-->
  
    <div class="container-fluid">
        <hr>
             <!-- ============================================================== -->
            <!-- Start Form Create User -->
            <!-- ============================================================== -->
            <div class="row-fluid">
              <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                  <h5>{{__('Edit User')}}</h5>
              </div>
            <div class="widget-content nopadding">
                      <form  class="form-horizontal" method="POST" action="{{ route('users.update',['user'=>$user->id]) }}" >
                        @csrf
                        @method('PUT')
                       
                        @include('admin.users._form')
                        <div class="form-actions">
                            <button type="submit" id ="save" class="btn btn-success span2  offset3">{{__('Update')}}</button>
                            <a href="{{ route('users.index') }}" class="btn btn-warning span2  ">{{__('Back')}}</a>

 
                        </div>
                      </form>
            </div>
              </div>
                </div>
            </div>
    </div>

             <!-- ============================================================== -->
            <!-- End Form Create User -->
            <!-- ============================================================== -->



            
 @endsection
