@extends('layouts.dashboard.designe')
@section('title', 'Exercices')
@section('content')



    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb" >
             <a href="{{ route('exercices.index') }}" title="Exercices" class="tip-bottom {{ (request()->segment(1) == 'exercices') ? 'current' : ''  }}">
                <i class="icon-book"></i> Exercices</a>
        </div>
    </div>
   
  
 <!--End-breadcrumbs-->
 <div class="container-fluid ">
    <hr>
    <div class="form-actions">
        <a href="{{ route('exercices.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
            Ajouter Exercice </a>
    </div>
    <div class="row-fluid ">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table ">
                    <thead>
                        <tr>
                            <th>Annee</th>
                            <th>Statut</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exercices as $exercice)
                            <tr>
                               
                          
                                <td>{{ $exercice->year }}</td>
                                <td>{{ ($exercice->statut == 1 )?'active':'désactive' }}</td>
                                
                               
                                <td class="table-action">
                                    <a class="btn btn-success btn-mini green tip" href="{{ route('exercices.edit', ['exercice' => $exercice->id]) }}"
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