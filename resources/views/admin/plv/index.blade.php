@extends('layouts.dashboard.designe')
@section('title','plv')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('plvs.index') }}" title="List des plvs"
                class="current tip-bottom {{ request()->segment(2) == 'plvs' ? 'current' : '' }}">
                <i class="icon-book"></i>plvs</a>
        </div>
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('plvs.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
               Ajouter plv</a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>List des plvS</h5>
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
                            @foreach ($plvs as $plv)
                                <tr>
                                    <td class="table-action">{{ $plv->designation }}</td>
                                 
                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('plvs.edit', ['plv' => $plv->id]) }}" title="Modifier"><i
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
