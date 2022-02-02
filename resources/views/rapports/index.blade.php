@extends('layouts.dashboard.designe')
@section('title', 'rapport')
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('rapports.index') }}" title="Statistiques" class="tip-bottom current"><i class="icon-bar-chart"></i>
                Tableau de bord</a>
        </div>
        <!-- breadcrumbs -->

    </div>
    <!--End-Action boxes-->
    <div class="container-fluid">

        <div class="container-fluid">
            <div class="quick-actions_homepage">
                <ul class="quick-actions">

                    <li class="bg_lb span3">
                        <a id="visiteMedcine"> <i class="icon-user-md"></i> <span class="label label-primary"></span>
                            Visite Médecin
                        </a>
                    </li>

                    <li class="bg_lb span3">
                        <a id="emg"> <i class="icon-gift"></i>
                            EMG
                        </a>
                    </li>

                    <li class="bg_lb span3">
                        <a id="plv"> <i class="icon-picture"></i>
                            PLV
                        </a>
                    </li>

                    <li class="bg_lb span3">
                        <a id="fiche"> <i class="icon-picture"></i>
                            Fiche
                        </a>
                    </li>

                @cannot('Delegue.Responsable-Delegue.Acheteur', Auth::user())

                        <li class="bg_lb span3">
                        <a id="nombres"> <i class="icon-map-marker"></i>
                            Nombre De Visites
                        </a>
                    </li>
                    <li class="bg_lb span3">
                        <a id="duo"> <i class="icon-group"></i>
                            DUO
                        </a>
                    </li>
                    @endcannot

                    <li class="bg_lb span3">
                        <a id="visitePharmacies"> <i class="icon-beaker"></i>
                            Visite Pharmacie
                        </a>
                    </li>

                    <li class="bg_lb span3">
                        <a id="demandeSpeciale"> <i class="icon-info-sign"></i>
                            Demande Speciale
                        </a>
                    </li>
                    @cannot('Delegue.Responsable-Delegue.Acheteur', Auth::user())
                    <li class="bg_lb span3">
                        <a id="parcours"> <i class="icon-road"></i>
                            Déplacement
                        </a>
                    </li>

                    <li class="bg_lb span3">
                        <a id="rupture"> <i class="icon-ban-circle"></i>
                            Les ruptures
                        </a>
                    </li>

                    <li class="bg_lb span3">
                        <a id="autre"> <i class="icon-ban-circle"></i>
                            Autre médecin
                        </a>
                    </li>
                    @endcannot

                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        
        <div class="row-fluid">

            <div id="display">
            @can('admin.Manager+.Manager', Auth::user())
               <div class="row-fluid hidden-phone">
                    <div class="widget-box span12">
                        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                            <h5>Visites par spécialité</h5>
                        </div>
                        <div class="widget-content">
                            <div class="row-fluid">
                                <div class="controls">
                                    <div class="form-action">

                                        <div  class="span4 form-control" >

                                            De:&nbsp
                                            <input type="date"name="de" id="de_pie" value="{{ $de}}">
                                        </div>
                                        <div  class="span3 form-control" >

                                            &nbspA:&nbsp
                                            <input type="date" name="a" id="a_pie" value="{{ $a }}">
                                        </div>
                                        <div  class="span4 form-control" >
                                            <input type="button" name="filter" id="filter_pie" value="Filter" class="btn btn-info "/> 

                                        </div>
                                    </div>

                                
                                </div>
                            </div>                    

                            <hr>
                            <div id="chartByDatePie" style="width: 95%;">
                                @include('rapports.chartPieByDate')

                            </div>
                            
                        </div>
                    </div>
                </div> 
                <div class="row-fluid hidden-phone">
                    <div class="widget-box span12">
                        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                            <h5>Visites par région</h5>
                        </div>
                        <div class="widget-content">
                            <div id="container" >
                                <div class="row-fluid">
                                    <div class="controls">
                                        <div class="form-action">

                                            <div  class="span4 form-control" >

                                                De:&nbsp
                                                <input type="date"name="de" id="de" value="{{ $de}}">
                                            </div>
                                            <div  class="span3 form-control" >

                                                &nbspA:&nbsp
                                                <input type="date" name="a" id="a" value="{{ $a }}">
                                            </div>
                                            <div  class="span4 form-control" >
                                                <input type="button" name="filter" id="filter" value="Filter" class="btn btn-info "/> 

                                            </div>
                                        </div>

                                    
                                    </div>
                                </div>
                                <hr>
                                
                                <div id='chartByDate'>
                                    @include('rapports.chartBarVisitesByRegion')
                                </div>

                            </div>
                            
                        </div>
                    </div>
                </div>

                
                <div class="row-fluid hidden-phone">
                    <div class="widget-box span12">
                        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                            <h5>Visites par mois</h5>
                        </div>
                        <div class="widget-content">
                            <div id="container" style="width: 95%;">
                                <canvas id="canvas1"></canvas>

                            </div>
                            
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <script src="{{ asset('layout/js/Chart-bar.js') }}"></script>
    <script src="{{ asset('layout/js/utils.js') }}"></script>
    @can('admin.Manager+.Manager', Auth::user())

    <script>
        var color = Chart.helpers.color;
        // var labels = {!! json_encode($labels) !!};
        // var data1 = {!! json_encode($data1) !!};
        // var data2 = {!! json_encode($data2) !!};
        var labelsNb = {!! json_encode($labelsNb) !!};
        var data1Nb = {!! json_encode($data1Nb) !!};
        var data2Nb = {!! json_encode($data2Nb) !!};
        var data3Nb = {!! json_encode($data3Nb) !!};
////////////////////////////////////////////////////
        var barChartDataNb = {
            labels: labelsNb,
            datasets: [{
                    label: 'Visite Pharmacie',
                    lineTension: 0,
                    backgroundColor: color(window.chartColors.orange).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.orange,
                    borderWidth: 1,
                    data: data1Nb
                },
                {
                    label: 'Visite médecin',
                    lineTension: 0,
                    backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.blue,
                    borderWidth: 1,
                    data: data2Nb
                },
                {
                    label: 'Commande',
                    lineTension: 0,
                    backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.green,
                    borderWidth: 1,
                    data: data3Nb
                }
            ]
        };
        var ctx = document.getElementById('canvas1').getContext('2d');
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartDataNb,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Nombre de visite par mois'
                }
            }
        });
    </script>
    @endcan
   
    <script>
        $("#filter").click(function(e) {
            e.preventDefault();
            var de = $("#de").val();
            var a = $("#a").val();
            var url = "{{route('rapport.change.chart.by.date', [":de",":a"])}}";
                url = url.replace(':de', de);
                url = url.replace(':a', a);
            $.ajax({
                url: url,
                cache: false,
                success: function(r) {
                    $("#chartByDate").hide().html(r).fadeIn(0);
                }
            });
        });
        $("#filter_pie").click(function(e) {
            e.preventDefault();
            var de = $("#de_pie").val();
            var a = $("#a_pie").val();
           
            var url = "{{route('rapport.change.chart.by.date.pie', [":de",":a"])}}";
                url = url.replace(':de', de);
                url = url.replace(':a', a);

            $.ajax({
                url: url,
                cache: false,
                success: function(r) {
                    $("#chartByDatePie").hide().html(r).fadeIn(0);
                }
            });
        });
        
        $("#visiteMedcine").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.mdecine') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });
        
        $("#emg").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.emg') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });

        
        $("#duo").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.duo') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });

        $("#plv").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.plv') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });
        $("#fiche").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.fiche') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });
        $("#nombres").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.nombres') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });
        $("#visitePharmacies").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.pharmacies') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });
        $("#demandeSpeciale").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.demandes') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });
        
        
        $("#parcours").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.parcours') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });
        $("#rupture").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.rupture') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });
        $("#autre").click(function() {
            $.ajax({
                url: "{{ route('rapport.visite.autre') }}",
                cache: false,
                success: function(r) {
                    $("#display").hide().html(r).fadeIn(500);
                }
            });
        });
    </script>
    <script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
    <script src="{{ asset('layout/js/matrix.js') }}"></script>
    
@endsection