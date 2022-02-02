@extends('layouts.dashboard.designe')
@section('title', __('Clients'))
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('clients.index') }}" title="clients"
                class="tip-bottom current"><i class="icon-book"></i>
                Clients</a></div>
    </div>
    <!--End-breadcrumbs-->
    <div class="container-fluid">
        <hr>
        @cannot('client.lecture', Auth::user())
        <div class="form-actions">
            <a href="{{ route('clients.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
                {{ __('New client') }}</a>
        </div>
        @endcannot

        <!------------------------------- ici c'est un message de formation ---------------------------->
        @if (session()->has('success'))
            <script>
                swal("{{ __('success') }}", " {{ session()->get('success') }} ", "success").then(function() {
                    location.reload();
                });
            </script>
        @endif
        <!------------------------------- fin message de formation ------------------------------->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>{{ __('List of clients') }}</h5>

            {{-- <a href="{{ route('exporter_view',['tout','0']) }}"target="_blank" class="btn btn-success btn-mini add-action"><i class="icon icon-download-alt"></i> Exporter</a>
          --}}
                </div>
                <div class="widget-content nopadding">
                   @include('userSide.clients.table')
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->

@endsection
