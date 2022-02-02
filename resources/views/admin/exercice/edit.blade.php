
@extends('layouts.dashboard.designe')
@section('title', 'Exercices')
@section('content')

<div id="content-header">
    <div id="breadcrumb"> 
        
            <a href="{{ route('exercices.index') }}" title="Exercices" class="tip-bottom ">
                <i class="icon-book"></i> Exercices</a>
      <a title="Modifier Exercice" class="tip-bottom current"><i class="icon-bar-chart"></i> Modifier Exercice</a>
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
                  <h5>Modfier Exercice</h5>
              </div>
               <div class="widget-content nopadding">
               

                    <form class="form-horizontal"   method="POST" action="{{ route('exercices.update',['exercice' => $exercice->id])}}" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                       
                      {{-- <div class="control-group">
                        <label class="control-label" for="year">year</label>
                        <div class="controls">
                            <select class="form-control span8 @error('year') is-invalid @enderror" id="year" name="year">
                              
                                @for ($i = $year; $i < $year+5; $i++)
                                    <option  value="{{$i}}" 
                                    {{ isset($exercice) ? ($exercice->year == $i? 'selected' : '') : '' }}>
                                    {{ $i }}</option>
                                @endfor  
                            </select>
                        </div>
                    </div> --}}
                    <div class="control-group">
                        <div class="controls ">
                            <input type="number" disabled name="year" id="year" class="span8 form-control @error('year') is-invalid @enderror"
                                value="{{ old('year', $exercice->year ?? null) }}">
                    
                            @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">{{ __('Statut') }}</label>
                        <div class="controls">
                            <label class="" for="bloquer"  >
                                <input type="radio" class=" @error('bloquer') is-invalid @enderror"
                                    id="bloquer" name="bloquer" value="1" required  {{ old('bloquer',isset($exercice) ? ($exercice->statut === "1" ? 'checked' : ''):'checked') }}>
                                    {{__('Activate')}}
                                </label>
                          <label>
                            <label class="" for="bloquer2">
                    
                                <input type="radio" class=" @error('bloquer') is-invalid @enderror"
                                    id="bloquer2" name="bloquer" value="0" required {{ old('bloquer',isset($exercice) ? ($exercice->statut === "0" ? 'checked' : ''):'') }}>
                            
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
