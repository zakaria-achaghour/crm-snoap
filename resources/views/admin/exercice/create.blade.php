@extends('layouts.dashboard.designe')
@section('title', 'Exercices')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">

            <a href="{{ route('exercices.index') }}" title="Exercices" class="tip-bottom ">
                <i class="icon-book"></i> Exercices</a>
            <a href="{{ route('exercices.create') }}" title="Ajouter Exercice" class="tip-bottom current"><i
                    class="icon-bar-chart"></i> Ajouter Exercice</a>
        </div>
    </div>


    <div class="container-fluid">
        <hr>
        <!-- ============================================================== -->
        <!-- Start Form Create User -->
        <!-- ============================================================== -->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Ajouter Exercice</h5>
                </div>
                <div class="widget-content nopadding">


                    <form class="form-horizontal" method="POST" action="{{ route('exercices.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="control-group">
                            <label class="control-label" for="year">year</label>
                            <div class="controls">
                                <select class="form-control span8 @error('year') is-invalid @enderror" id="year"
                                    name="year">

                                    @for ($i = $year; $i < $year + 5; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <!------- error message --------->
                                @if ($errors->get('year'))
                                    @foreach ($errors->get('year') as $msg)
                                        <ul class="list-unstyled text-danger">
                                            <li> <br>
                                                <h6>{{ $msg }}</h6>
                                            </li>
                                        </ul>
                                    @endforeach
                                @endif
                                <!------- fin error message --------->
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" id="save"
                                class="btn btn-success span3 offset4">{{ __('Save') }}</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
