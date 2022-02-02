@extends('layouts.dashboard.designe')
@section('title', __('Clients'))
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('clients.index') }}" title="clients" class="tip-bottom"><i
                    class="icon-book"></i> Clients</a>
            <a href="{{ route('clients.create') }}" title="Demande change control"
                class="current">{{ __('Add client') }}</a>
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
                        <h5>{{ __('New client') }}</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{ route('clients.store') }}"
                            enctype="multipart/form-data">

                            <!----------------- tag de laravel pour autoriser la modification --->
                            @csrf
                            <!----------------- tag de laravel pour autoriser la modification --->

                            <!------------------ champs 1 ------------------>
                            <div class="control-group">
                                <label class="control-label">{{ __('Name Pharmacy') }}</label>
                                <div class="controls">
                                    <input type="text" class="form-control span11 @if ($errors->get('nom')) is-invalid @endif" name="nom"
                                        id="fname" placeholder="Nom complet" value="{{ old('nom') }}">
                                    <!------- error message --------->
                                    @if ($errors->get('nom'))
                                        @foreach ($errors->get('nom') as $msg)
                                            <ul class="list-unstyled text-danger">
                                                <li> {{ $msg }} </li>
                                            </ul>
                                        @endforeach
                                    @endif
                                    <!------- fin error message --------->
                                </div>
                            </div>
                            <!------------------ fin champs 1 ------------------>
                            <!--------------------- champs 2 --------------------->
                            <div class="control-group">
                                <label class="control-label">{{ __('Cities') }}</label>
                                <div class="controls">
                                    <select name='ville' class='span11' value="{{ old('ville') }}">
                                        @foreach ($villes as $ville)
                                            <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Num Ug</label>
                                <div class="controls">
                                    <input type="number" class="form-control span11 @error('numug') is-invalid @enderror"
                                        name="numug" id="numug" value="{{ old('numug') }}">
                                    <!------- error message --------->
                                    @error('numug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <!------- fin error message --------->
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="adresse" class="control-label ">{{ __('Address') }}</label>
                                <div class="controls">
                                    <textarea type="text" class="form-control span11 @if ($errors->get('adresse')) is-invalid @endif"
                                        name="adresse" id="adresse" placeholder="Adresse">{{ old('adresse') }}</textarea>
                                    <!------- error message --------->
                                    @if ($errors->get('adresse'))
                                        @foreach ($errors->get('adresse') as $msg)
                                            <ul class="list-unstyled text-danger">
                                                <li> {{ $msg }} </li>
                                            </ul>
                                        @endforeach
                                    @endif
                                    <!------- fin error message --------->
                                </div>
                            </div>
                            <!------------------ fin champs 2 ------------------>
                            <!------------------ champs 3 ------------------>
                            <div class="control-group">
                                <label class="control-label">Intitulé</label>
                                <div class="controls">
                                    <input type="text" class="form-control span11 @error('intitulé') is-invalid @enderror"
                                        name="intitulé" id="intitulé" value="{{ old('intitulé') }}">
                                    <!------- error message --------->
                                    @error('intitulé')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <!------- fin error message --------->
                                </div>
                            </div>
                            <!------------------ fin champs 3 ------------------>

                            <!--------------------- champs 4 --------------------->
                            <div class="control-group">
                                <label class="control-label">{{ __('Type') }}</label>
                                <div class="controls">
                                    <label>
                                        <input type="radio" name="type" value="1"
                                            {{ old('type') == '1' ? 'checked' : '' }} checked />
                                        {{ __('Pharmacy') }}
                                    </label>
                                    <label>
                                        <input type="radio" name="type" value="0"
                                            {{ old('type') == '0' ? 'checked' : '' }} />
                                        {{ __('Wholesaler') }}
                                    </label>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">IS</label>
                                <div class="controls">
                                    <label>
                                        <input type="radio" name="is" value="1" {{ old('is') == '1' ? 'checked' : '' }}
                                            checked />
                                        Existant
                                    </label>
                                    <label>
                                        <input type="radio" name="is" value="0"
                                            {{ old('is') == '0' ? 'checked' : '' }} />
                                        Potentiel
                                    </label>
                                </div>
                            </div>
                            <!------------------ fin champs 4 ------------------>
                            <div id="dataClient">


                                <!-------------------- champs 5 -------------------------->
                                <div class="control-group">
                                    <label class="control-label">{{ __('Status') }}</label>
                                    <div class="controls">
                                        <label>
                                            <input type="radio" value="1" name="statut"
                                                {{ old('statut') == '1' ? 'checked' : '' }} checked>
                                            {{ __('Activate') }}</label>

                                        <label>
                                            <input type="radio" value="0" name="statut"
                                                {{ old('statut') == '0' ? 'checked' : '' }}>
                                            {{ __('Deactivate') }}</label>
                                    </div>
                                </div>
                                <!-------------------- fin champs 5 -------------------------->


                                <!-------------------- champs 6 -------------------------->
                                <div class="control-group">
                                    <label class="control-label">{{ __('Blacklist') }}</label>
                                    <div class="controls">
                                        <label>
                                            <input type="radio" value="1" name="bloquer"
                                                {{ old('bloquer') == '1' ? 'checked' : '' }}>
                                            {{ __('Block') }}</label>

                                        <label>
                                            <input type="radio" value="0" name="bloquer"
                                                {{ old('bloquer') == '0' ? 'checked' : '' }} @if (old('bloquer') == '1') @else checked @endif>
                                            {{ __('Unblock') }}</label>

                                    </div>
                                </div>
                                <!-------------------- fin champs 6 -------------------------->

                                <!-------------------- champs 7 -------------------------->
                                <div class="control-group @if (old('bloquer') == '1') @else hide @endif" id="motif">
                                    <label for="motif" class="control-label"
                                        id="lblmotif">{{ __('Blocking pattern') }}</label>
                                    <div class="controls">
                                        <textarea type="text" class="form-control span11 @if ($errors->get('motif')) is-invalid @endif"
                                            name="motif" id="motif" placeholder="Motif">{{ old('motif') }}</textarea>
                                        <!------- error message --------->
                                        @if ($errors->get('motif'))
                                            @foreach ($errors->get('motif') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>
                                <!-------------------- fin champs 7 -------------------------->

                                <div class="widget-title bg_ly"><span class="icon"><i
                                            class="icon-edit"></i></span>
                                    <h5>2. Informations :</h5>
                                </div>

                                <!-------------------- champs 8 -------------------------->
                                <div class="control-group">
                                    <label for="pharmacien" class="control-label ">{{ __('Pharmacist') }}</label>
                                    <div class="controls">
                                        <input type="text" class="form-control span11 @if ($errors->get('pharmacien')) is-invalid @endif"
                                            name="pharmacien" id="pharmacien" placeholder="Pharmacien"
                                            value="{{ old('pharmacien') }}">
                                        <!------- error message --------->
                                        @if ($errors->get('pharmacien'))
                                            @foreach ($errors->get('pharmacien') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>
                                <!-------------------- fin champs 8 -------------------------->
                                <!------------------ champs 9 ------------------>
                                <div class="control-group">
                                    <label class="control-label" for="patente">{{ __('Patent') }}</label>
                                    <div class="controls">
                                        <input type="text" class="form-control span11 @if ($errors->get('patente')) is-invalid @endif"
                                            name="patente" id="patente" placeholder="Patente"
                                            value="{{ old('patente') }}">
                                        <!------- error message --------->
                                        @if ($errors->get('Patente'))
                                            @foreach ($errors->get('Patente') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>
                                <!------------------ fin champs 9 ------------------>

                                <!-------------------- champs 10 -------------------------->
                                <div class="control-group">
                                    <label for="ice" class="control-label">{{ __('ICE') }}</label>
                                    <div class="controls">
                                        <input type="text" class="form-control span11 @if ($errors->get('ice')) is-invalid @endif" name="ice"
                                            id="ice" placeholder="ICE" value="{{ old('ice') }}">
                                        <!------- error message --------->
                                        @if ($errors->get('ice'))
                                            @foreach ($errors->get('ice') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>
                                <!------------------ fin champs 10 ------------------>

                                <!-------------------- champs 11 -------------------------->
                                <div class="control-group">
                                    <label for="i_f" class="control-label ">{{ __('IF') }}</label>
                                    <div class="controls">
                                        <input type="text" class="form-control span11 @if ($errors->get('i_f')) is-invalid @endif" name="i_f"
                                            id="i_f" placeholder="IF" value="{{ old('i_f') }}">
                                        <!------- error message --------->
                                        @if ($errors->get('i_f'))
                                            @foreach ($errors->get('i_f') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>
                                <!-------------------- fin champs 11 -------------------------->

                                <!-------------------- champs 12 -------------------------->
                                <div class="control-group">
                                    <label for="autorisation" class="control-label ">{{ __('Authorization') }}</label>
                                    <div class="controls">
                                        <input type="text" class="form-control span11 @if ($errors->get('autorisation')) is-invalid @endif"
                                            name="autorisation" id="autorisation" placeholder="Autorisation"
                                            value="{{ old('autorisation') }}">
                                        <!------- error message --------->
                                        @if ($errors->get('autorisation'))
                                            @foreach ($errors->get('autorisation') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>
                                <!-------------------- champs 12 -------------------------->

                                <!-------------------- champs 13 -------------------------->
                                <div class="control-group">
                                    <label for="rc" class="control-label ">{{ __('RC') }}</label>
                                    <div class="controls">
                                        <input type="text" class="form-control span11 @if ($errors->get('rc')) is-invalid @endif" name="rc"
                                            id="rc" placeholder="RC" value="{{ old('rc') }}">
                                        <!------- error message --------->
                                        @if ($errors->get('rc'))
                                            @foreach ($errors->get('rc') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>
                                <!-------------------- champs 13 -------------------------->

                                <!-------------------- champs 14 -------------------------->
                                <div class="control-group">
                                    <label for="cin" class="control-label ">{{ __('CIN') }}</label>
                                    <div class="controls">
                                        <input type="text" class="form-control span11 @if ($errors->get('cin')) is-invalid @endif" name="cin"
                                            id="cin" placeholder="CIN" value="{{ old('cin') }}">
                                        <!------- error message --------->
                                        @if ($errors->get('cin'))
                                            @foreach ($errors->get('cin') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>
                                <!-------------------- fin champs 14 -------------------------->

                                <!-------------------- champs 15 -------------------------->

                                <!-------------------- fin champs 15 -------------------------->

                                <!-------------------- champs 16 -------------------------->
                                <div class="control-group">
                                    <label for="contact" class="control-label ">{{ __('Contact') }}</label>
                                    <div class="controls">
                                        <input type="text" class="form-control span11 @if ($errors->get('contact')) is-invalid @endif"
                                            name="contact" id="contact" placeholder="Contact"
                                            value="{{ old('contact') }}">
                                        <!------- error message --------->
                                        @if ($errors->get('contact'))
                                            @foreach ($errors->get('contact') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>
                                <!-------------------- fin champs 16 -------------------------->

                                <!-------------------- champs 17 -------------------------->
                                <div class="control-group">
                                    <label for="sage" class="control-label">{{ __('Code Sage') }}</label>
                                    <div class="controls">
                                        <input type="text" class="form-control span11 @if ($errors->get('sage')) is-invalid @endif" name="sage"
                                            id="sage" placeholder="Code sage" value="{{ old('sage') }}">
                                        <!------- error message --------->
                                        @if ($errors->get('sage'))
                                            @foreach ($errors->get('sage') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>
                                <!-------------------- fin champs 17 -------------------------->
                                <div class="widget-title bg_ly"><span class="icon"><i
                                            class="icon-edit"></i></span>
                                    <h5>3. Documents :</h5>
                                </div>

                                <!-------------------- champs 18 -------------------------->
                                <div class="control-group">
                                    <label class="control-label">{{ __('Documents') }}</label>
                                    <div class="controls">
                                        <label for="f_cin">
                                            <input type="checkbox" id="f_cin" name="f_cin"
                                                {{ old('f_cin') == 'on' ? 'checked' : '' }}>
                                            {{ __('CIN') }}</label>



                                        <label for="f_autorisation">
                                            <input type="checkbox" id="f_autorisation" name="f_autorisation"
                                                {{ old('f_autorisation') == 'on' ? 'checked' : '' }}>
                                            {{ __('Authorization') }}</label>


                                        <label for="f_if_ice">
                                            <input type="checkbox" id="f_if_ice" name="f_if_ice"
                                                {{ old('f_if_ice') == 'on' ? 'checked' : '' }}>
                                            {{ __('IF, ICE') }}</label>
                                    </div>
                                </div>
                                <!-------------------- fin champs 18 -------------------------->

                                <!-------------------- champs 19 -------------------------->
                                <div class="control-group">
                                    <label class="control-label">{{ __('File') }}</label>
                                    <div class="controls">
                                        <input type="file" name="fichier" id="fichier"
                                            class="span12 @if ($errors->get('fichier')) is-invalid @endif " accept=".zip,.rar"
                                            value="{{ old('fichier') }}" />
                                        <!------- error message --------->
                                        @if ($errors->get('fichier'))
                                            @foreach ($errors->get('fichier') as $msg)
                                                <ul class="list-unstyled text-danger">
                                                    <li> {{ $msg }} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                        <!------- fin error message --------->
                                    </div>
                                </div>


                                <div class="widget-title bg_ly"><span class="icon"><i
                                            class="icon-edit"></i></span>
                                    <h5>4. Plvs :</h5>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="plvs">Plvs</label>
                                    <div class="controls">
                                        <select multiple class="form-control span8 @error('plvs') is-invalid @enderror"
                                            id="plvs" name="plvs[]">

                                            @foreach ($plvs as $plv)
                                                <option value="{{ $plv->id }}"
                                                    {{ isset($client)? ($client->plvs->where('finished_at', null)->pluck('id')->contains($plv->id)? 'selected': ''): '' }}>
                                                    {{ $plv->designation }}</option>

                                            @endforeach
                                        </select>
                                        <!------- error message --------->
                                        @error('plvs')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                                <!-------------------- fin champs 19 -------------------------->
                                @cannot('client.lecture', Auth::user())
                                    <div class="form-actions">
                                        <input type="submit" id="save" value="{{ __('Create') }}" class="btn btn-success">
                                    </div>
                                @endcannot
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------------------- end form create ----------------------------------------->
@endsection
