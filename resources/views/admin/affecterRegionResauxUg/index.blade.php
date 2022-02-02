@extends('layouts.dashboard.designe')
@section('title','Affecter')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('affecter.index') }}" 
                class="current tip-bottom current">
                <i class="icon-book"></i> Affecter</a>
        </div>
    </div>
    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('affecter.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
               New Affectation</a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                  
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                              <th>
                                  Réseaux
                              </th>
                              <th>
                                  Régions Mc
                              </th>
                            
                              <th>
                               Actions
                            </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($rns as $rn)
                            <tr>
                               
                          
                                <td>{{ $rn->network }}</td>
                               
                                <td>{{ $rn->regionmc }}</td>
                               
                               
                                <td class="table-action">
                                    <form action="{{ route('affecter.destroy', ['id' => $rn->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-mini  tip"><i class="icon-trash"></i></button>
                                    </form>
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
