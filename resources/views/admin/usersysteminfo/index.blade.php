@extends('layouts.dashboard.designe')
@section('title', 'Utilisateurs')
@section('content')


    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"><a href="{{ route('users.index') }}" title="Users" class="tip-bottom current ">
                <i class="icon-book"></i> Utilisateurs system info</a></div>
    </div>
    <!--End-breadcrumbs-->

    <div class="container-fluid">
        <hr>
        <div class="form-actions">
            <a href="{{ route('users.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
                {{ __('Add User') }}</a>
        </div>
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>{{ __('List Of Users') }}</h5>
                </div>
                <div class="widget-content nopadding">
                    <table id="table" class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Firstname') }}</th>
                                <th>{{ __('Lastname') }}</th>
                                <th>{{ __('Ip address') }}</th>
                                <th>{{ __('Gender') }}</th>
                                <th>{{ __('Browser') }}</th>
                                <th>{{ __('Device') }}</th>
                                {{-- <th>Regions MC</th>
                                <th>Reseaux</th>
                                <th>Ugs</th> --}}


                                <th>OS</th>
                                <th>Dernière auth</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usersinfo as $user)
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->firstname }}</td>
                                    <td>{{ $user->lastname }}</td>
                                    <td>{{ $user->ip_address }}</td>
                                    <td>{{ $user->gender=='male'?__('Male'):__('Female')  }}</td>
                                    <td>{{ $user->browser }}</td>
                                    <td>{{ $user->device }}</td>
                                    <td>{{ $user->os }}</td>
                                    <td> {{ date('Y-m-d H:i:s', strtotime($user->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
