@extends('layouts.dashboard.designe')
@section('title', __('Clients'))
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('clients.index') }}" title="clients" class="tip-bottom"><i
                    class="icon-book"></i> Clients</a>
            <a href="{{ route('clients.edit', [$client->id]) }}" title="Demande change control" class="current">
                Modifier un client</a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <!-- container assemble the form -->
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span8">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                        <h5>{{ __('Edit client') }}</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="#" enctype="multipart/form-data">

                            <!-- code for disable form for lecture-->
                            @if (Auth::user()->role=='Lecture')
                                <fieldset disabled>                                
                            @else
                                <fieldset >
                            @endif

                            <!----------------- tag de laravel pour autoriser la modification --->
                            @csrf
                            @method('PUT')
                            <!----------------- tag de laravel pour autoriser la modification --->
                            @include('plannings.pharmacy.form')
                                @cannot('client.lecture', Auth::user())
                                    <div class="form-actions">
                                        <input type="submit" id="save" value="{{ __('Edit') }}" class="btn btn-success">
                                    </div>
                                @endcannot
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------------------- end form create ----------------------------------------->
@endsection
