@extends('layouts.dashboard.designe')
@section('title', 'Resaux')
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">

        <div id="breadcrumb">
            <a href="{{ route('resaux.index') }}" title="List des resaux" class="tip-bottom"><i
                    class="icon-book"></i> reseaux</a>
            <a href="" title="Modifier resaux"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i> Modifier reseaux</a>
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
                    <h5>Modifier reseaux</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST"
                        action="{{ route('resaux.update', ['resaux' => $network->id]) }}">
                        @csrf
                        @method('PUT')
                        {{-- <input type="text" value="{{$network->id}}" />  --}}

                        @include('admin.resaux._form')
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success span2  offset3">{{ __('Update') }}</button>
                            <a href="{{ route('resaux.index') }}" class="btn btn-warning span2  ">{{ __('Back') }}</a>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
