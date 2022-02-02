
@extends('layouts.dashboard.designe')
@section('title', __('Edit Profile'))
@section('content')


    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{route('profile_edit')}}" title="{{__('Edit Profile')}}" class="tip-bottom current"><i
                    class="icon-book"></i> {{__('Edit Profile')}}</a></div>
    </div>
    <!--End-breadcrumbs-->

    <div class="container-fluid">
        <hr>
        <!-- ============================================================== -->
        <!-- Start Form Create User -->
        <!-- ============================================================== -->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                  <h5>{{__('Edit Profile')}}</h5>
              </div>
            <div class="widget-content nopadding">
                <form class="form-horizontal" method="POST" action="{{ route('profile_edit') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="row">
                        <div class="span6">
                            <div class="control-group">
                                <label for="firstname" class="control-label ">{{ __('Firstname') }}</label>
                                <div class="controls ">
                                    <input type="text" class="span8 form-control @error('firstname') is-invalid @enderror"
                                        name="firstname" id="firstname" value="{{ $user->firstname }}" readonly>
                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label for="lastname" class="control-label ">{{ __('Lastname') }}</label>
                                <div class="controls ">
                                    <input type="text" class="span8 form-control @error('lastname') is-invalid @enderror"
                                        name="lastname" id="lastname" value="{{ $user->lastname }}" readonly>
                                    @error('lastname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="username" class="control-label ">{{ __('Username') }} </label>
                        <div class="controls ">
                            <input type="text" class="span8 form-control @error('username') is-invalid @enderror"
                                name="username" id="username" value="{{ $user->username }}" readonly>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="email" class="control-label ">{{ __('E-mail') }} </label>
                        <div class="controls ">
                            <input type="email" class="span8 form-control @error('email') is-invalid @enderror" name="email"
                                id="email" value="{{ $user->email }}" readonly>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                   

                    <div class="control-group">
                        <label for="new_password" class="control-label ">{{ __('New Password') }}</label>
                        <div class="controls ">
                            <input type="password" class="span8 form-control @error('new_password') is-invalid @enderror"
                                name="new_password" id="new_password">
                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="confirm_password" class="control-label ">{{ __('Confirm Password') }}</label>
                        <div class="controls ">
                            <input type="password"
                                class="span8 form-control @error('confirm_password') is-invalid @enderror"
                                name="confirm_password" id="confirm_password">
                            @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>













                    <div class="form-actions ">
                        <button type="submit" id ="save" class="btn btn-warning span3  offset4">{{ __('Update') }}</button>

                    </div>


                </form>
            </div>
            </div>
        </div>

    </div>
    </div>

@endsection
