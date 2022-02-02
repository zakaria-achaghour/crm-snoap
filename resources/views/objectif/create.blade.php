@extends('layouts.dashboard.designe')
@section('title', 'Objectifs')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">

            <a href="{{ route('objectifs.index') }}" title="objectifs" class="tip-bottom ">
                <i class="icon-book"></i> Objectifs</a>
            <a href="{{ route('objectifs.create') }}" title="Ajouter Catégorie " class="tip-bottom current"><i
                    class="icon-bar-chart"></i> Ajouter Objectif</a>
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
                    <h5>Ajouter Objectif </h5>
                </div>
                <div class="widget-content nopadding">


                    <form class="form-horizontal" method="POST" action="{{ route('objectifs.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('objectif._form')

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
