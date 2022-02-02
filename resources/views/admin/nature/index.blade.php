@extends('layouts.dashboard.designe')
@section('title', 'Natures')
@section('content')



    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('natures.index') }}" title=" {{ __('List Of Natures') }}"
                class="tip-bottom {{ request()->segment(1) == 'Natures' ? 'current' : '' }}">
                <i class="icon-book"></i>Natures</a>
        </div>
    </div>


    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('natures.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
                Ajouter Nature </a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Natures</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Code Sage</th>
                                <th>{{ __('designation') }}</th>
                                <th>status</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($natures as $nature)
                                <tr>
                                    <td>{{ $nature->code_sage }}</td>
                                    <td>{{ $nature->designation }}</td>
                                    <td class="table-action">
                                        @if ($nature->statut == 0)
                                            <p class="text-success">Activé</p>
                                        @else
                                            <p class="text-danger">Désactivé</p>
                                        @endif
                                    </td>
                                   


                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('natures.edit', ['nature' => $nature->id]) }}"
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
