
@extends('layouts.dashboard.designe')

@section('content')



    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb" >
             <a href="{{ route('villes.index') }}" title="{{ __('List Of Cities') }}" class="current tip-bottom {{ (request()->segment(2) == 'villes') ? 'current' : ''  }}">
                <i class="icon-book"></i> {{ __('Cities') }}</a>
        </div>
    </div>
   
  
 <!--End-breadcrumbs-->
 <div class="container-fluid ">
    <hr>
    <div class="form-actions">
        <a href="{{ route('villes.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
            {{ __('Add City') }}</a>
    </div>
    <div class="row-fluid ">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>{{ __('List Of Cities') }}</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table ">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($villes as $ville)
                            <tr>
                                <td class="table-action">{{ $ville->nom }}</td>

                                <td class="table-action">
                                    <a class="btn btn-success btn-mini green tip" href="{{ route('villes.edit', ['ville' => $ville->id]) }}"
                                        title="Modifier"><i class="icon-pencil"></i></a>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Name') }}</th>

                            <th>Actions</th>

                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>


@endsection
