
@extends('layouts.dashboard.designe')
@section('title', __('Account Setting'))

@section('content')

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{route('settings')}}" title="{{ __('Account Setting') }}" class="tip-bottom current"><i
                    class="icon-book"></i> {{ __('Account Setting') }}</a></div>
    </div>
    <!--End-breadcrumbs-->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Form Create User -->
        <!-- ============================================================== -->
        <div class="row-fluid">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>{{ __('Account Setting') }}</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST" action="{{ route('settings') }}">
                        @csrf
                        @method('PUT')

                        <div class="control-group">
                            <label class="control-label" for="locale">{{ __('Language') }}</label>
                            <div class="controls">
                                <select class="span6 offset2" name="locale" id="locale">
                                    @foreach (App\Models\User::LOCALES as $locale => $label)
                                        <option value="{{ $locale }}"
                                            {{ $user->locale === $locale ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br/>
                        <div class="form-actions">
                            <button type="submit" id ="save" class="btn btn-warning span3 offset4">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
