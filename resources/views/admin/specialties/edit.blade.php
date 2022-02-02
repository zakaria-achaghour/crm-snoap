@extends('layouts.dashboard.designe')
@section('title', 'Spécialité')
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">

        <div id="breadcrumb">
            <a href="{{ route('specialties.index') }}" title="Spécialités" class="tip-bottom"><i
                    class="icon-book"></i> Spécialités</a>
            <a href="" title="Modifier Spécialité"
                class="tip-bottom current"><i
                    class="icon-pencil"></i> Modifier Spécialité</a>
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
                    <h5>Modifier Spécialité</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST"
                        action="{{ route('specialties.update', ['specialty' => $specialty->id]) }}">
                        @csrf
                        @method('PUT')

                        @include('admin.specialties._form')
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success span2  offset3">{{ __('Update') }}</button>
                            <a href="{{ route('specialties.index') }}" class="btn btn-warning span2  ">{{ __('Back') }}</a>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
