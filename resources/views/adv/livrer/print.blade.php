@extends('layouts.dashboard.designe')
@section('title', 'ADVS')
@section('content')
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('advs.index') }}" title="Liste des ADV"
                class="current tip-bottom {{ request()->segment(1) == 'advs' ? 'current' : '' }}">
                <i class="icon-book"></i>ADV</a>
        </div>
    </div>
    <!--End-breadcrumbs-->

    <div class="container-fluid ">
        <hr>
        <div id="print">
            <div class="logo-print">
                <img src="{{ asset('layout/img/logo3.jpg') }}" alt="logo">
            </div>

            <div class="widget-content nopadding">

                <h3 class="text-center">Bon de livraison</h3>

                <div class="group-print">
                    <div class="span6">
                        <p for="demandeur" class="titleprint">demandeur :</p>
                        <p class="resprint">
                            {{ $adv->autre_user ? $adv->autre_user : $adv->user->firstname . ' ' . $adv->user->lastname }}
                        </p>
                    </div>
                </div>

                <div class="group-print">
                    <div class="span6">
                        <p for="doctor" class="titleprint">Medecin :</p>
                        <p class="resprint">{{ $adv->autre_doctor ? $adv->autre_doctor : $adv->doctor->name }}</p>
                    </div>

                    <div class="span6">
                        <p for="Speciality" class="titleprint">Info médecin :</p>
                        <p class="resprint">
                            {{ $adv->autre_specialty ? $adv->autre_specialty : $adv->doctor->specialty->designation }}
                        </p>
                    </div>
                </div>

                <div class="group-print">
                    <div class="span6">
                        <p for="nature" class="titleprint">Nature :</p>
                        <p class="resprint">{{ $adv->nature->designation }}</p>
                    </div>

                    @if ($adv->tva != 0)
                        <div class="span6">
                            <p for="budgetPrev" class="titleprint">Budget Réel HT:</p>
                            <p class="resprint">{{ $adv->budget_reel }}</p>
                        </div>
                    @else
                        <div class="span6">
                            <p for="budgetPrev" class="titleprint">Budget Réel:</p>
                            <p class="resprint">{{ $adv->budget_reel }}</p>
                        </div>
                    @endif
                </div>

                <div class="group-print">
                    <div class="span6">
                        <p for="month" class="titleprint">Date de Livraison:</p>
                        <p class="resprint">{{ Carbon\Carbon::parse($adv->updated_at)->format('d-m-Y') }}</p>
                    </div>

                    @if ($adv->tva != 0)
                        <div class="span6">
                            <p for="month" class="titleprint">Budget Réel TTC :</p>
                            <p class="resprint">
                                {{ $adv->budget_reel + ($adv->tva == 0 ? 0 : ($adv->budget_reel * $adv->tva) / 100) }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="last_group">
                    <div class="inner_last_grp">
                        <p for="dNature" class="titleprint">Details Nature :</p>
                        <p class="resprint">{{ $adv->nature_detail }}</p>
                    </div>
                </div>
            </div>

            <div class="visa">
                <p>Signature Délégué</p>
            </div>

            <div class="visa_benificiere">
                <p>Signature Benificiere</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('layout/js/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#print").printThis({
                debug: false, // show the iframe for debugging
                importCSS: true, // import parent page css
                importStyle: false, // import style tags
                printContainer: false, // print outer container/$.selector
                loadCSS: "{{ asset('layout/css/bonlivraison.css') }}", // path to additional css file - use an array [] for multiple
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
            $("#print").hide();
            setTimeout(function() {
                window.close();
            }, 4000);
        });
    </script>

@endsection
