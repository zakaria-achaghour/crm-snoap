@extends('layouts.dashboard.designe')
@section('title', __('Recovery'))
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('recouvrement.index') }}" title="Recouvrement" class="tip-bottom"><i
                    class="icon-book"></i> {{ __('Recovery')}}</a>
            <a href="{{ route('recouvrement.create') }}" title="Recouvrement"
                class="current">{{ __('Add a Check') }}</a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <!-- container assemble the form -->
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                  <h5>{{ __('Add a Check') }}</h5>
              </div>
            <div class="widget-content nopadding">
                <form class="form-horizontal"  method="POST" action="{{ route('recouvrement.store') }}" enctype="multipart/form-data">
                  @csrf
                        @include('admin.recouvrement._form')
                        <div class="form-actions">
                            <button type="submit" id="save" class="btn btn-success span3 offset4">{{__('Save')}}</button>
 
                        </div>
                </form>

            </div>
                </div>
            </div>
       
    </div>

@endsection 