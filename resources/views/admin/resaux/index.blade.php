@extends('layouts.dashboard.designe')
@section('title','Resaux')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('resaux.index') }}" title="liste des resaux"
                class="current tip-bottom current">
                <i class="icon-book"></i> resaux</a>
        </div>
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('resaux.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
               Ajouter reseau</a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>List des reseaux</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Produits</th>
                                <th>Plvs</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($networks as $resaux)
                                <tr>
                                    <td class="table-action">{{ $resaux->designation }}</td>
                                    <td class="table-action"> 
                                         {{ implode(', ',$resaux->products()->get()->pluck('designation')->toArray(),) }}
                                       
                                        </td>
                                        <td class="table-action"> 
                                            {{ implode(', ',$resaux->plvs()->get()->pluck('designation')->toArray(),) }}
                                          
                                           </td>
                                   
                                    <td>{{ $resaux->category->designation }}</td>
                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('resaux.edit', ['resaux' => $resaux->id]) }}" title="Modifier"><i
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
