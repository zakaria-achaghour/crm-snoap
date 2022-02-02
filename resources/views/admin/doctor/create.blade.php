@extends('layouts.dashboard.designe')
@section('title', 'Docteurs')
@section('content')

<div id="content-header">

    <div id="breadcrumb">
        <a href="{{ route('doctors.index') }}" title="Docteurs" class="tip-bottom"><i
                class="icon-book"></i> Docteurs</a>
        <a href="" title="Ajouter Docteur"
            class="tip-bottom current"><i
                class="icon-plus"></i> Ajouter Docteur</a>
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
                    <h5>Ajouter Docteurs</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" id="form_validation" method="POST" action="{{ route('doctors.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('admin.doctor._form')
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
