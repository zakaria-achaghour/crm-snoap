@extends('layouts.dashboard.designe')
@section('title', 'Limites')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">

            <a href="{{ route('limites.index') }}" title="limites" class="tip-bottom current"><i class="icon-book"></i>
                Limites</a>
            <a href="{{ route('limites.create') }}" title="Ajouter limite " class="tip-bottom current"><i
                    class="icon-bar-chart"></i> Ajouter Limite </a>
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
                    <h5>Ajouter Limite </h5>
                </div>
                <div class="widget-content nopadding">


                    <form class="form-horizontal" method="POST" action="{{ route('limites.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('limites._form')

                        <div class="form-actions">
                            <button type="submit" id="save"
                                class="btn btn-success span3 offset4">{{ __('Save') }}</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
