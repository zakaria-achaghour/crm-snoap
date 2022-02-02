@extends('layouts.dashboard.designe')
@section('title','Produits')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('products.index') }}" title="list des Produits"
                class="current tip-bottom {{ request()->segment(2) == 'products' ? 'current' : '' }}">
                <i class="icon-book"></i> Produits</a>
        </div>
    </div>

    <!--End-breadcrumbs-->
    <div class="container-fluid ">
        <hr>
        <div class="form-actions">
            <a href="{{ route('products.create') }}" class="btn btn-success"><i class="icon icon-plus"></i>
               Ajouter Produit</a>
        </div>
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>List des Produits</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table ">
                        <thead>
                            <tr>
                                <th>Code sage</th>
                                <th>Désignation</th>
                                <th>DCI</th>
                                <th>Classe</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="table-action">{{ $product->code_sage }}</td>
                                    <td class="table-action">{{ $product->designation }}</td>
                                    <td class="table-action">{{isset($product->dci->designation)?$product->dci->designation:'' }}</td>

                                    <td class="table-action">{{ isset($product->dci->classe->designation)?$product->dci->classe->designation:'' }}</td>
                                    <td class="table-action">{{isset($product->dci->classe->type)?$product->dci->classe->type:'' }}</td>
                                   

                                    <td class="table-action">{{ $product->statut ==1?'active':'Désactiver' }}</td>
                                  
                              

                                    <td class="table-action">
                                        <a class="btn btn-success btn-mini green tip"
                                            href="{{ route('products.edit', ['product' => $product->id]) }}" title="Modifier"><i
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
