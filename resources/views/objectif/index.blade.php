

@extends('layouts.dashboard.designe')
@section('title', 'Objectifs')
@section('content')
 <!--breadcrumbs-->
 <div id="content-header">
    <div id="breadcrumb"> <a href="{{ route('objectifs.index') }}" title="objectifs"
            class="tip-bottom current"><i class="icon-book"></i>
            Objectifs</a>
    </div>
 </div>
    
<!--End-breadcrumbs-->  
<div class="container-fluid">
        <hr>
      
        <div class="form-actions">
            <a href="{{ route('objectifs.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
                Ajouter</a>
        </div>
        <div class="row-fluid ">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table ">
                            <thead>
                                <tr>
                                    <th>Responsable</th>
                                    <th>De</th>
                                    <th>A</th>
                                    <th>Montant</th>
                                    <th>UG</th>
                                    <th>Nombre Médecine</th>
                                    <th>Actions</th>
        
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($objectifs as $objectif)
                                    <tr>
                                        <td>{{ $objectif->lastname  }}   {{ $objectif->firstname  }}</td>
                                        <td>{{ $objectif->de }}</td>
                                        <td>{{ $objectif->a }}</td>
                                        <td>{{ $objectif->montant }}</td>
                                        <td>{{ $objectif->ug }}</td>
                                        <td>{{ $objectif->nombre_medecine }}</td>
                                        <td class="table-action">
                                            <a class="btn btn-success btn-mini green tip" href="{{ route('objectifs.edit', ['objectif' => $objectif->id]) }}"
                                                title="Modifier"><i class="icon-pencil"></i></a>
                                            <a class="btn btn-info btn-mini tip" href="{{ route('objectifs.product', ['objectif_id' => $objectif->id]) }}"
                                                title="Article"><i class="icon-tag"></i></a>
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
