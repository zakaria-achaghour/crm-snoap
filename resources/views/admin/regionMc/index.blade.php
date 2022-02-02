@extends('layouts.dashboard.designe')
@section('title', __('Regions'))
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('regionmcs.index') }}" title="{{ __('List Of Regions') }}"
                class="current tip-bottom {{ request()->segment(2) == 'regionmcs' ? 'current' : '' }}">
                <i class="icon-book"></i> {{ __('Regions') }}</a>
        </div>
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('regionmcs.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
                {{ __('Add Region') }}</a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>{{ __('List Of Regions') }}</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Année</th>

                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($regions as $region)
                                <tr>
                                    <td class="table-action">{{ $region->designation }}</td>
                                    <td class="table-action">{{ $region->exercice->year }}</td>

                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('regionmcs.edit', ['regionmc' => $region->id]) }}" title="Modifier"><i
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
