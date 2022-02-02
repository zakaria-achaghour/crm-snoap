@extends('layouts.dashboard.designe')
@section('title','DCI')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('dcis.index') }}" title="List des dcis"
                class="current tip-bottom {{ request()->segment(2) == 'dcis' ? 'current' : '' }}">
                <i class="icon-book"></i>dciS</a>
        </div>
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('dcis.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
               Ajouter dci</a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>List des dciS</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Classe</th>
                                <th>Type</th>

                                
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dcis as $dci)
                                <tr>
                                    <td class="table-action">{{ $dci->designation }}</td>
                                    <td class="table-action">{{ $dci->classe->designation }}</td>
                                    <td class="table-action">{{ $dci->classe->type }}</td>


                                 
                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('dcis.edit', ['dci' => $dci->id]) }}" title="Modifier"><i
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
