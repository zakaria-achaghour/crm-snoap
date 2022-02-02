@extends('layouts.dashboard.designe')
@section('title', 'Animateurs')
@section('content')


    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"><a href="{{ route('users.animateurs') }}" title="Users" class="tip-bottom current ">
                <i class="icon-book"></i> Animateurs</a></div>
    </div>
    <!--End-breadcrumbs-->

    <div class="container-fluid">
        <hr>
     
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>List des animateurs</h5>
                </div>
                <div class="widget-content nopadding">
                    <table id="table" class="table table-bordered data-table">
                        <thead>
                            <tr>
                            
                                <th>{{ __('Firstname') }}</th>
                                <th>{{ __('Lastname') }}</th>
                                <th>{{ __('E-mail') }}</th>
                                <th>{{ __('Gender') }}</th>
                                <th>{{ __('Contact') }}</th>
                                <th>Ligne</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->firstname }}</td>
                                    <td>{{ $user->lastname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->gender=='male'?__('Male'):__('Female')  }}</td>
                                    <td>{{ $user->contact }}</td>
                               
                                    <td></td>
                                 
                                    <td>
                                        <a class="tip btn btn-success btn-mini"
                                            href="{{ route('users.editAnimateurs', ['animateur' => $user->id]) }}" title="Modifier"><i
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