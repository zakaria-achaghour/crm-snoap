@extends('layouts.dashboard.designe')
@section('title', 'catégories')
@section('content')



    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb" >
             <a href="{{ route('categories.index') }}" title="category" class="tip-bottom current">
                <i class="icon-book"></i> categories</a>
        </div>
    </div>
   
  
 <!--End-breadcrumbs-->
 <div class="container-fluid ">
    <hr>
    <div class="form-actions">
        <a href="{{ route('categories.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
            Ajouter Category </a>
    </div>
    <div class="row-fluid ">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table ">
                    <thead>
                        <tr>
                            <th>Designation</th>
                            <th>Statut</th>
                            <th>Annee</th>


                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                               
                          
                                <td>{{ $category->designation }}</td>
                                <td>{{ ($category->statut == 1 )?'active':'désactive' }}</td>
                                <td>{{ $category->exercice->year }}</td>
                                
                               
                                <td class="table-action">
                                    <a class="btn btn-success btn-mini green tip" href="{{ route('categories.edit', ['category' => $category->id]) }}"
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