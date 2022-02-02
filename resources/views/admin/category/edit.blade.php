
@extends('layouts.dashboard.designe')
@section('title', 'categories')
@section('content')

<div id="content-header">
    <div id="breadcrumb"> 
        
            <a href="{{ route('categories.index') }}" title="categories" class="tip-bottom ">
                <i class="icon-book"></i> categorys</a>
      <a title="Modifier category" class="tip-bottom current"><i class="icon-bar-chart"></i> Modifier Catégorie </a>
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
                  <h5>Modfier Catégorie </h5>
              </div>
               <div class="widget-content nopadding">
               

                    <form class="form-horizontal"   method="POST" action="{{ route('categories.update',['category' => $category->id])}}" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                       
                  
                      @include('admin.category._form')
                      
                    <div class="control-group">
                        <label class="control-label">{{ __('Statut') }}</label>
                        <div class="controls">
                            <label class="" for="bloquer"  >
                                <input type="radio" class=" @error('bloquer') is-invalid @enderror"
                                    id="bloquer" name="bloquer" value="1" required  {{ old('bloquer',isset($category) ? ($category->statut === "1" ? 'checked' : ''):'checked') }}>
                                    {{__('Activate')}}
                                </label>
                          <label>
                            <label class="" for="bloquer2">
                    
                                <input type="radio" class=" @error('bloquer') is-invalid @enderror"
                                    id="bloquer2" name="bloquer" value="0" required {{ old('bloquer',isset($category) ? ($category->statut === "0" ? 'checked' : ''):'') }}>
                            
                                    {{__('Deactivate')}}</label>     
                          <label>
                            @error('bloquer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                       
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
