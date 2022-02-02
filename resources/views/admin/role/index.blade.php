@extends('layouts.dashboard.designe')
@section('title', 'Roles')
@section('content')



    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('roles.index') }}" title="Devis"
                class="tip-bottom {{ request()->segment(1) == 'roles' ? 'current' : '' }}">
                <i class="icon-book"></i> Roles</a>
        </div>
    </div>


    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('roles.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
                {{ __('Add Role') }} </a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>{{ __('List Of Roles') }}</h5>
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
                            @foreach ($roles as $role)
                                <tr>

                                    <td>{{ $role->name }}</td>

                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('roles.edit', ['role' => $role->id]) }}" title="Modifier"><i
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
