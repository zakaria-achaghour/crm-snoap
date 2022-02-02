@extends('layouts.dashboard.designe')
@section('title', 'Natures')
@section('content')

<div id="content-header">
    <div id="breadcrumb"> 
        <a href="{{ route('natures.index') }}" title="list Of Natures" class="tip-bottom ">
            <i class="icon-book"></i> Natures</a>
      <a href="{{ route('natures.create') }}" title="Ajouter Nature" class="tip-bottom current"><i class="icon-plus"></i> Ajouter Nature</a>
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
                  <h5>Ajouter Nature</h5>
              </div>
               <div class="widget-content nopadding">
                    <form class="form-horizontal"   method="POST" action="{{ route('natures.store') }}" enctype="multipart/form-data">
                      @csrf
                       
                        @include('admin.nature._form')
                        <div class="form-actions">
                            <button type="submit" id ="save" class="btn btn-success span3 offset4">{{__('Save')}}</button>
 
                        </div>
                      </form>
               </div>
                </div>
            </div>
    </div>

 @endsection
