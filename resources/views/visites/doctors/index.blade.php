@extends('layouts.dashboard.designe')
@section('title', 'visites Médecins' )
@section('content')
     <!--breadcrumbs-->
     <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('plannings.doctors') }}" title="Plannings"
                class="tip-bottom current"><i class="icon-book"></i>
                Visite Médecin</a></div>
    </div>
    <!--End-breadcrumbs-->
    <div class="container-fluid">
        <hr>

        
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

        @include('visites.doctors.recherche_date')

       
       
        <!------------------------------- fin message de formation ------------------------------->
        
    </div>


    <!-- Modal -->

@endsection
