
@extends('layouts.dashboard.designe')
@section('title', 'Limites')
@section('content')
 <!--breadcrumbs-->
 <div id="content-header">
    <div id="breadcrumb"> 
        <a href="{{ route('limites.index') }}" title="limites" class="tip-bottom current"><i class="icon-book"></i>
            Limites</a>
    </div>
 </div>
    
<!--End-breadcrumbs-->  
<div class="container-fluid">
        <hr>
      
        <div class="form-actions">
            <a href="{{ route('limites.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
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
                                    <th>Delegue</th>
                                    <th>Nombre Visites privé</th>
                                    <th>Nombre Visites public</th>
                                    <th>Actions</th>
        
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($limites as $limit)
                                    <tr>
                                        <td>{{ $limit->user->firstname .' '.$limit->user->lastname  }}  </td>
                                      
                                        <td>{{ $limit->visite_prive }}</td>
                                        <td>{{ $limit->visite_public }}</td>
                                        <td class="table-action">
                                            <a class="btn btn-success btn-mini green tip" href="{{ route('limites.edit', ['limite' => $limit->id]) }}"
                                                title="Modifier"><i class="icon-pencil"></i></a>
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