@extends('layouts.dashboard.designe')
@section('title', 'Docteurs')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('doctors.index') }}" title="Docteurs"
                class="current tip-bottom {{ request()->segment(2) == 'doctors' ? 'current' : '' }}">
                <i class="icon-book"></i> Docteurs</a>
        </div>
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('doctors.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
                Ajouter Docteur</a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>list des Docteurs </h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Nom et prénom</th>
                                <th>Téléphoner </th>
                                <th>Region</th>
                                <th>Ville</th>
                                <th>UG</th>
                                <th>Adresse</th>
                                <th>Spécialité</th>
                                <th>Statut</th>
                                <th>Nombre de Patient</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($doctors as $doctor)
                                <tr>
                                    <td >{{ $doctor->name }}</td>
                                    <td >{{ $doctor->phone }}</td>
                                    <td >{{ $doctor->region }}</td>
                                    <td >{{ $doctor->ville }}</td>
                                    <td >{{ $doctor->ug }}</td>


                                    <td >{{ $doctor->adresse }}</td>
                                    <td >{{ $doctor->specialty }}</td>
                                    <td>{{ $doctor->statut_mc }}</td>
                                    <td >{{ $doctor->nombre_patients }}</td>

                                    

                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('doctors.edit', ['doctor' => $doctor->id]) }}" title="Modifier"><i
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
