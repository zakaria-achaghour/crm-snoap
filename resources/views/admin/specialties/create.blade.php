@extends('layouts.dashboard.designe')
@section('title', 'Spécialité')
@section('content')

<div id="content-header">

    <div id="breadcrumb">
        <a href="{{ route('specialties.index') }}" title="Spécialités" class="tip-bottom"><i
                class="icon-book"></i> Spécialités</a>
        <a href="" title="Ajouter Spécialité"
            class="tip-bottom current"><i
                class="icon-plus"></i> Ajouter Spécialité</a>
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
                    <h5>Ajouter Spécialité</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" id="form_validation" method="POST" action="{{ route('specialties.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @include('admin.specialties._form')
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
