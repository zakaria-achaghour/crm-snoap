@extends('layouts.dashboard.designe')
@section('title','Classes')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('classes.index') }}" title="List des Classes"
                class="current tip-bottom {{ request()->segment(2) == 'classes' ? 'current' : '' }}">
                <i class="icon-book"></i>Classes</a>
        </div>
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('classes.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
               Ajouter Classe</a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>List des Classes</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                 <th>Type</th>
                                
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($classes as $classe)
                                <tr>
                                    <td class="table-action">{{ $classe->designation }}</td>
                                     <td class="table-action">{{ $classe->type }}</td> 
                                  
                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('classes.edit', ['class' => $classe->id]) }}" title="Modifier"><i
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
