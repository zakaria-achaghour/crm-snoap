@extends('layouts.dashboard.designe')
@section('title','UGS')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('ugs.index') }}" title="List des UGS"
                class="current tip-bottom {{ request()->segment(2) == 'ugs' ? 'current' : '' }}">
                <i class="icon-book"></i>UGS</a>
        </div>
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('ugs.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
               Ajouter UG</a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>List des UGS</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Region</th>

                                <th>status</th>
                                 <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ugs as $ug)
                                <tr>
                                    <td class="table-action">{{ $ug->designation }}</td>
                                    <td class="table-action">{{ $ug->regionmc }}</td>

                                    <td class="table-action">
                                        @if ($ug->statut ==1)
                                            <p class="text-success">Activé</p>
                                        @else
                                            <p class="text-danger">Désactivé</p>
                                        @endif
                                    </td>
                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('ugs.edit', ['ug' => $ug->id]) }}" title="Modifier"><i
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
