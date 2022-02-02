@extends('layouts.dashboard.designe')
@section('title', 'Edit Nombre Cheques ')
@section('content')
    <!--------------------------------------- form create ----------------------------------------->
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            {{-- <a href="{{ route('recouvrement.index') }}" title="{{ __('Recouvrement') }}" class="tip-bottom "><i
                    class="icon-book"></i> {{ __('Recovery') }}</a>
            <a href="" title="{{ __('Edit a Check') }}" class="tip-bottom current"><i class="icon-bar-chart "></i>
                {{ __('Edit a Check') }}</a> --}}
        </div>
    </div>
    <!--End-breadcrumbs-->

    <!-- container assemble the form -->
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    {{-- <h5>{{ __('Edit a Check')}}</h5> --}}
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST"
                        action="{{ route('clients.chequesencours.update', ['client' => $client->id]) }}">
                        @csrf
                        @method('PUT')


                        <div class="control-group">
                            <label class="control-label">{{ __('Name Pharmacy') }}</label>
                            <div class="controls">
                                <input type="text" class="form-control span11 @error('nom') is-invalid @enderror" name="nom"
                                id="fname" placeholder="Nom complet" value="{{ $client->nom }}" disabled>
                                <!------- error message --------->
                                @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                                <!------- fin error message --------->
                            </div>
                        </div>

                        
                        <div class="control-group">
                            <label class="control-label">{{  __('Cities')  }}</label>
                            <div class="controls">
                                <input type="text" class="form-control span11 @error('ville') is-invalid @enderror" name="ville"
                                id="ville" value="{{ $client->ville->nom}}" disabled>
                                <!------- error message --------->
                                @error('ville')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                                <!------- fin error message --------->
                            </div>
                        </div>


                                                
                        <div class="control-group">
                            <label for="nombreCheque" class="control-label ">{{ __('Checks In Progress') }}</label>
                            <div class="controls">
                                <input type="number" step="any" class="form-control span11 @error('nombreCheque') is-invalid @enderror" name="nombreCheque"
                                    id="nombreCheque"  value="{{ old('nombreCheque', $client->nombreCheque ?? 0) }}">
                                <!------- error message --------->
                                @error('nombreCheque')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <!------- fin error message --------->
                            </div>
                        </div>
                        {{-- @include('admin.recouvrement._form') --}}
                        <div class="form-actions">
                            <button type="submit" id="save" class="btn btn-success span2  offset3">{{ __('Update') }}</button>
                            <a href="{{ route('clients.chequesencours') }}"
                                class="btn btn-warning span2  ">{{ __('Back') }}</a>


                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection
