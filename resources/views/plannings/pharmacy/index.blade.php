@extends('layouts.dashboard.designe')
@section('title', __('Visites'))
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('plannings.index.pharmacies') }}" title="Plannings"
                class="tip-bottom current"><i class="icon-book"></i>
                Plannings</a></div>
    </div>
    <!--End-breadcrumbs-->
    <div class="container-fluid">
        <hr>
        <div class="form-actions">
            <a href="{{ route('plannings.create.pharmacies') }}" class="btn btn-success btn-large"><i class="icon icon-plus"></i>
                Nouveau planning</a>
        </div>

        
        <input type="hidden" id="user" value="{{ Auth::id() }}">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>Délégué</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="form-actions">
                    <select name='delegue' id="delegue" class='span4'>
                        <option value="{{ Auth::user()->id }}" >{{ Auth::user()->firstname }}  {{ Auth::user()->lastname }} </option>
                        @foreach ($delegues as $delegue)
                            <option value="{{ $delegue->id }}" >{{ $delegue->firstname }}  {{ $delegue->lastname }} </option>
                        @endforeach
                    </select>
               
                @error('delegue')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
        </div>

        @include('plannings.pharmacy.recherche_date')

       
       
        <!------------------------------- fin message de formation ------------------------------->
        
    </div>


    <!-- Modal -->

@endsection
