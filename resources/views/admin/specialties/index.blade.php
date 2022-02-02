@extends('layouts.dashboard.designe')
@section('title', 'Spécialité')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('specialties.index') }}" title="Spécialités"
                class="current tip-bottom {{ request()->segment(2) == 'specialties' ? 'current' : '' }}">
                <i class="icon-book"></i> Spécialités</a>
        </div>
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('specialties.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
                Ajouter Spécialité</a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>list des Spécialités </h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($specialties as $specialty)
                                <tr>
                                    <td class="table-action">{{ $specialty->designation }}</td>
                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('specialties.edit', ['specialty' => $specialty->id]) }}" title="Modifier"><i
                                                class="icon-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                      
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
