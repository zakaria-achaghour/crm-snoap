@extends('layouts.dashboard.designe')
@section('title', 'Resaux')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('resaux.index') }}" title="liste des Resaux" class="tip-bottom "><i
                    class="icon-book"></i> Reseaux</a>
            <a href="{{ route('resaux.create') }}" title="Ajouter Resaux"
                class="tip-bottom current"><i
                    class="icon-bar-chart"></i> Ajouter Reseau</a>
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
                    <h5>Ajouter Reseau</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" id="form_validation" method="POST" action="{{ route('resaux.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('admin.resaux._form')
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
