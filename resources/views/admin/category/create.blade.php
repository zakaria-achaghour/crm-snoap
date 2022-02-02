@extends('layouts.dashboard.designe')
@section('title', 'Catégories')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">

            <a href="{{ route('categories.index') }}" title="Catégories" class="tip-bottom ">
                <i class="icon-book"></i> Catégories</a>
            <a href="{{ route('categories.create') }}" title="Ajouter Catégorie " class="tip-bottom current"><i
                    class="icon-bar-chart"></i> Ajouter Catégorie </a>
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
                    <h5>Ajouter Catégorie </h5>
                </div>
                <div class="widget-content nopadding">


                    <form class="form-horizontal" method="POST" action="{{ route('categories.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('admin.category._form')

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
