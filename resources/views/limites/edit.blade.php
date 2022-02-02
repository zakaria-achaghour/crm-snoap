
@extends('layouts.dashboard.designe')
@section('title', 'categories')
@section('content')

<div id="content-header">
    <div id="breadcrumb"> 
        
        <a href="{{ route('limites.index') }}" title="limites" class="tip-bottom current"><i class="icon-book"></i>
            Limites</a>
      <a title="Modifier Limite" class="tip-bottom current"><i class="icon-bar-chart"></i> Modifier Limite </a>
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
                  <h5>Modfier Limite </h5>
              </div>
               <div class="widget-content nopadding">
               

                    <form class="form-horizontal"   method="POST" action="{{ route('limites.update',['limite' => $limite->id])}}" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                       
                  
                      @include('limites._form')
                      
                 
                       
                      </div>
                        <div class="form-actions">
                            <button type="submit" id ="save" class="btn btn-success span3 offset4">{{__('Save')}}</button>
 
                        </div>
                      </form>
               </div>
                </div>
            </div>
    </div>

 @endsection
