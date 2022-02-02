@extends('layouts.dashboard.designe')
@section('title', 'Utilisateurs')
@section('content')


    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"><a href="{{ route('users.index') }}" title="Users" class="tip-bottom current ">
                <i class="icon-book"></i> Utilisateurs</a></div>
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
                                <th>{{ __('E-mail') }}</th>
                                <th>{{ __('Gender') }}</th>
                                <th>{{ __('Contact') }}</th>
                                <th>{{ __('Role') }}</th>
                                {{-- <th>Regions MC</th>
                                <th>Reseaux</th>
                                <th>Ugs</th> --}}


                                <th>Status</th>
                                <th>Dernière auth</th>
                                <th>auth</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->firstname }}</td>
                                    <td>{{ $user->lastname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->gender=='male'?__('Male'):__('Female')  }}</td>
                                    <td>{{ $user->contact }}</td>
                                    <td>
                                        {{ implode(', ',$user->roles()->get()->pluck('name')->toArray(),) }}
                                    </td>
                                    {{-- <td>
                       
                                        {{ implode(', ',$user->nugs()->get()->pluck('regionmc')->toArray(),) }}
                                    </td>
                                    <td>
                       
                                        {{ implode(', ',$user->nugs()->get()->pluck('network')->toArray(),) }}
                                    </td>
                                    <td>
                       
                                        {{ implode(', ',$user->nugs()->get()->pluck('ug')->toArray(),) }}
                                    </td> --}}

                                 
                                    <td>
                                        @if ($user->isOnline())
                                            <div class="circle log"></div>
                                        @else
                                            <div class="circle out"></div>
                                        @endif
                                    </td>

                                    <td> {{ date('d-m-Y H:i:s', strtotime($user->lastlogin)) }}</td>
                                    <td> {{ date('Y-m-d', strtotime($user->lastlogin)) }}</td>

                                    <td>
                                        <a class="tip btn btn-success btn-mini"
                                            href="{{ route('users.edit', ['user' => $user->id]) }}" title="Modifier"><i
                                                class="icon-pencil"></i></a>
                                        <!--<a href="javascript:void(0);" class="tip deleteUser" data-toggle="modal" data-target="#userConfirm"title="Supprimer"><i class="icon-remove"></i></a> -->


                                        <button class="tip btn btn-danger btn-mini"
                                            onclick="deleteConfirmation({{ $user->id }})" title="Supprimer"><i
                                                class="icon-remove"></i></button>
                                        <button class="tip btn btn-warning  btn-mini"
                                            onclick="resetPassword({{ $user->id }})"
                                            title="Réinitialiser le mot de passe"><i class=" icon-retweet"></i></button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <!--------------------scripte for delete confirm messsage in 'shownotes' view  -->
    <script>
        function deleteConfirmation(id) {
            swal.fire({
                title: "Bloqué?",
                icon: "warning",
                text: "voulez-vous vraiment être bloqué !",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, Bloqué!",
                cancelButtonText: "Non !"
            }).then(function(e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'GET',
                        url: 'users/' + id + '/delete',
                        data: {
                            _token: CSRF_TOKEN
                        },
                        // dataType: 'JSON',
                        success: function(results) {
                            if (results.success === true) {
                                swal.fire("Done!", results.message, "success");
                                // refresh page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            })
        }



        function resetPassword(id) {
            swal.fire({
                title: "Réinitialiser?",
                icon: "warning",
                text: "voulez-vous vraiment être Réinitialiser le mot de passe  !",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui,Réinitialiser !",
                cancelButtonText: "Non !"
            }).then(function(e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'GET',
                        url: 'users/' + id + '/reset',
                        data: {
                            _token: CSRF_TOKEN
                        },
                        // dataType: 'JSON',
                        success: function(results) {
                            if (results.success === true) {
                                swal.fire("Done!", results.message, "success");
                                // refresh page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal.fire("Error!", results.message, "error");

                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            })
        }

    </script>
    <!--------------------scripte for delete confirm messsage in 'shownotes' view  -->


@endsection
