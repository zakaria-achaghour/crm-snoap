
@extends('layouts.dashboard.designe')

@section('content')

<div id="content-header">
    <div id="breadcrumb"> 
        <a href="{{ route('grossistes.index') }}" title="Grossistes" class="tip-bottom "><i class="icon-book"></i> Grossistes</a>
      <a href="{{ route('grossistes.create') }}" title="Ajouter Grossiste" class="tip-bottom current"><i class="icon-bar-chart"></i> Ajouter Grossiste</a>
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
                  <h5>Ajouter Grossiste</h5>
              </div>
               <div class="widget-content nopadding">
                    <form class="form-horizontal" id="form_validation"  method="POST" action="{{ route('grossistes.store') }}" enctype="multipart/form-data">
                      @csrf
                       
                        @include('admin.grossiste._form')
                        <div class="form-actions">
                            <button type="submit" id ="save" class="btn btn-success span3 offset4">{{__('Save')}}</button>
 
                        </div>
                      </form>
               </div>
                </div>
            </div>
    </div>

 @endsection
