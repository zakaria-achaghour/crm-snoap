@extends('layouts.dashboard.designe')
@section('title', 'ADV')
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('advs.index') }}" title="Liste Des ADV" class="tip-bottom "><i class="icon-book"></i>
                ADV</a>
            <a href="{{ route('advs.show', ['adv' => $adv->id]) }}" title="Ajouter ADV" class="tip-bottom current"><i
                    class="icon"></i>Détail ADV</a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <div class="container-fluid print">
        <hr>
        <input type="hidden" id="adv" value="{{ $adv->id }}">

        <form class="form-horizontal" method="post" action="#" enctype="multipart/form-data">
            @csrf
            @include('adv.adv._form_show')
        </form>

        <hr>

        <!-------------------    Product step   -------------------->
        <div class="row-fluid ">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Produits</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table table-invoice">
                        <thead>
                            <tr>
                                <th>PF</th>
                                <th>Quantité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="table-action">{{ $product->designation }}</td>
                                    <td class="table-action">{{ $product->qte ? $product->qte : 0 }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-------------------    buttons   -------------------->
    <div class="container-fluid ">
        <form class="form-horizontal" method="post" action="#" enctype="multipart/form-data">

            @if ($adv->step == 1)
                @can('admin.Manager', Auth::user())
                    <div class="form-actions">
                        <a class="btn btn-success span2  offset3 accepter mb">Accepter</a>
                        <a href="#" class="btn btn-warning span2 refuser ">Refuser</a>
                    </div>
                @endcan
            @endif

            @if ($adv->step == 2)
                @can('admin.Manager+', Auth::user())
                    <div class="form-actions">
                        <a class="btn btn-success span2  offset3 valider mb">Valider</a>
                        <a href="#" class="btn btn-danger span2 rejeter  ">Rejeter</a>
                    </div>
                @endcan
            @endif

            @if ($adv->step == 4)
                @can('admin.Acheteur', Auth::user())
                    <div class="form-actions">
                        <a class="btn btn-success span2  offset3 commander mb" href="{{route('advs.commande',['adv'=>$adv->id]) }}">Commander</a>
                        <a href="#" class="btn btn-danger span2 imprimer  ">Imprimer</a>
                    </div>
                @endcan
            @endif

            @if ($adv->step == 6)
                @can('admin.Acheteur', Auth::user())
                    <div class="form-actions">
                        <a class="btn btn-success span2 offset3 livrer mb" href="{{route('advs.livrer',['adv'=>$adv->id]) }}">Livrer</a>
                        <a class="btn btn-warning span2 editComande" href="{{route('advs.commande',['adv'=>$adv->id]) }}">Modifier</a>
                    </div>
                @endcan
            @endif
        </form>
    </div>


    <script src="{{ asset('layout/js/printThis.js') }}"></script>
    <script>
        var adv = $('#adv').val();
        $('.accepter').click(function(e) {
            $.ajax({
                type: 'GET',
                url: '/advs/status/2/' + adv,
                success: function(data) {
                    window.location.href = '/adv/accepte';
                }
            });
        });
        // $('.livrer').click(function(e) {
        //     alert('ok');
        //     $.ajax({
        //         type: 'GET',
        //         url: '/advs/livrer/' + adv,
        //         success: function(data) {
                  
        //         }
        //     });
        // });

        $('.refuser').click(function(e) {
            $.ajax({
                type: 'GET',
                url: '/advs/status/3/' + adv,
                success: function(data) {
                    window.location.href = '/adv/accepte';
                }
            });
        });

        $('.valider').click(function(e) {
            $.ajax({
                type: 'GET',
                url: '/advs/status/4/' + adv,
                success: function(data) {
                    window.location.href = '/adv/valider';
                }
            });
        });

        $('.rejeter').click(function(e) {
            $.ajax({
                type: 'GET',
                url: '/advs/status/5/' + adv,
                success: function(data) {
                    window.location.href = '/adv/valider';
                }
            });
        });

        $('.imprimer').click(function() {
            $(".secondaire").show();
            $(".visa").show();

            $(".print").printThis({
                debug: false, // show the iframe for debugging
                importCSS: true, // import parent page css
                importStyle: false, // import style tags
                printContainer: false, // print outer container/$.selector
                loadCSS: "{{ asset('layout/css/invoice.css') }}", // path to additional css file - use an array [] for multiple
                pageTitle: "", // add title to print page
                removeInline: false, // remove inline styles from print elements
                removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline must be true
                printDelay: 333, // variable print delay
                header: null, // prefix to html
                footer: null, // postfix to html
                base: false, // preserve the BASE tag or accept a string for the URL
                formValues: true, // preserve input/form values
                canvas: false, // copy canvas content
                doctypeString: '', // enter a different doctype for older markup
                removeScripts: false, // remove script tags from print content
                copyTagClasses: true, // copy classes from the html & body tag
                beforePrintEvent: null, // function for printEvent in iframe
                beforePrint: null, // function called before iframe is filled
                afterPrint: null, // function called before iframe is removed
            });
        });
    </script>
@endsection
