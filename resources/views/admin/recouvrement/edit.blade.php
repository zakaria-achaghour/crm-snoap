@extends('layouts.dashboard.designe')
@section('title', __('Recovery'))
@section('content')
    <!--------------------------------------- form create ----------------------------------------->
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('recouvrement.index') }}" title="{{ __('Recouvrement') }}" class="tip-bottom "><i
                    class="icon-book"></i> {{ __('Recovery') }}</a>
            <a href="" title="{{ __('Edit a Check') }}" class="tip-bottom current"><i class="icon-bar-chart "></i>
                {{ __('Edit a Check') }}</a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <!-- container assemble the form -->
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>{{ __('Edit a Check')}}</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST"
                        action="{{ route('recouvrement.update', ['recouvrement' => $cheque->id]) }}">
                        @csrf
                        @method('PUT')
                        @include('admin.recouvrement._form')
                        <div class="form-actions">
                            <button type="submit" id="save" class="btn btn-success span2  offset3">{{ __('Update') }}</button>
                            <a href="{{ route('recouvrement.index') }}"
                                class="btn btn-warning span2  ">{{ __('Back') }}</a>


                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection
