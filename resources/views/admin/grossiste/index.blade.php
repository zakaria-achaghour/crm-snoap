
@extends('layouts.dashboard.designe')

@section('content')



    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb" >
        <a href="{{ route('grossistes.index') }}" title="Grossistes" class="tip-bottom current "><i class="icon-book"></i> Grossistes</a>
        </div>
    </div>
   
  
 <!--End-breadcrumbs-->
 <div class="container-fluid ">
    <hr>
    <div class="form-actions">
        <a href="{{ route('grossistes.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
            Ajouter Grossiste</a>
    </div>
    <div class="row-fluid ">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>Liste Des Grossistes</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table ">
                    <thead>
                        <tr>
                            <th>Désignation</th>
                            <th>Ville</th>

                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grossistes as $grossiste)
                            <tr>
                                <td class="table-action">{{ $grossiste->designation }}</td>
                                <td class="table-action">{{ $grossiste->ville->nom }}</td>


                                <td class="table-action">
                                    <a class="btn btn-success btn-mini green tip" href="{{ route('grossistes.edit', ['grossiste' => $grossiste->id]) }}"
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
