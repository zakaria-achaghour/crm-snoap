@extends('layouts.dashboard.designe')
@section('title', 'Fournisseurs')
@section('content')



    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('fournisseurs.index') }}" title=" {{ __('List Of Fournisseurs') }}"
                class="tip-bottom {{ request()->segment(1) == 'fournisseurs' ? 'current' : '' }}">
                <i class="icon-book"></i> Fournisseurs</a>
        </div>
    </div>


    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('fournisseurs.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
                {{ __('Add Fournisseur') }} </a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>{{ __('List Of Fournisseurs') }}</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Code Sage</th>
                                <th>{{ __('designation') }}</th>
                                <th>Ville</th>
                                <th>status</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fournisseurs as $fournisseur)
                                <tr>
                                    <td>{{ $fournisseur->code_sage }}</td>
                                    <td>{{ $fournisseur->designation }}</td>
                                    <td>{{ $fournisseur->ville->nom }}</td>
                                    <td class="table-action">
                                        @if ($fournisseur->statut == 0)
                                            <p class="text-success">Activé</p>
                                        @else
                                            <p class="text-danger">Désactivé</p>
                                        @endif
                                    </td>
                                   


                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('fournisseurs.edit', ['fournisseur' => $fournisseur->id]) }}"
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
