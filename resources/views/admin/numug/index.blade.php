@extends('layouts.dashboard.designe')
@section('title','NUMUGS')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('numugs.index') }}" title="List des UGS"
                class="current tip-bottom {{ request()->segment(2) == 'numugs' ? 'current' : '' }}">
                <i class="icon-book"></i>UGS</a>
        </div>
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('numugs.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
               Ajouter num ug </a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>List des nums ugs</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Num</th>

                                 <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($numugs as $numug)
                                <tr>
                                    <td class="table-action">{{ $numug->id }}</td>
                                    
                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('numugs.edit', ['numug' => $numug->id]) }}" title="Modifier"><i
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
