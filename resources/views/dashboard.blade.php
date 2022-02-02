@extends('layouts.app')
@section('title', __('Dashboard'))
@section('content')

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('dashboard') }}" title="Statistiques" class="tip-bottom current"><i class="icon-bar-chart"></i>
                {{ __('Statistics') }}</a>
        </div>
        <!-- breadcrumbs -->

    </div>
    <!--End-Action boxes-->
    <div class="container-fluid">

        <div class="container-fluid">
            <div class="quick-actions_homepage">
                <ul class="quick-actions">
                    <li class="bg_lr span2">
                        <a id="bloque"> <i class="icon-ban-circle"></i> <span class="label label-primary">{{ $dataCount['clients_bloque'] }}</span>
                            {{ __('bank transfer')}}
                        </a>
                    </li>

                    <li class="bg_ly span2">
                        <a id="docManquant"> <i class="icon-file"><span class="label label-primary">{{ $dataCount['clients_docManque'] }}</span></i>
                            {{ __('Missing documents')}}
                        </a>
                    </li>
                    <li class="bg_lb  span2">
                        <a id="infoManquant"> <i class="icon-info-sign"><span class="label label-primary">{{ $dataCount['clients_infoManque'] }}</span></i>
                            {{ __('Missing information')}}
                        </a>
                    </li>
                    <li class="bg_lg span2 hidden-phone">
                        <a id="ville"> <i class="icon-home"></i>
                            {{ __('By city') }}
                        </a>
                    </li>
                    <li class="bg_lg span2">
                        <a id="toutInfo"> <i class="icon-info-sign"></i><span class="label label-primary">{{ $dataCount['clients_count'] }}</span>
                         {{ __('By') }} Informations
                        </a>
                    </li>
                    <li class="bg_lb span2">
                        <a id="tout"> <i class="icon-asterisk"></i><span class="label label-primary">{{ $dataCount['clients_count'] }}</span>
                            {{ __('All') }}
                        </a>
                    </li>
                  
                    @can('admin.manage', Auth::user())
                    <li class="bg_lr span2">
                        <a id="userBloque"> <i class="icon-ban-circle"></i><span class="label label-primary">{{ $dataCount['users_bloque'] }}</span>
                            {{ __('Blocked Users') }}
                        </a>
                    </li>
                    @endcan
                    @can('admin.administration', Auth::user())
                        <li class="bg_lg span2">
                            <a id="recouv"> <i class="icon-money"></i><span class="label label-primary"></span>
                                {{ __('Recovery')}}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
    <!--End-Action boxes-->
    <div class="container-fluid">

        <div id="display">
            <div class="row-fluid hidden-phone">
                <div class="widget-box span12">
                    <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                        <h5>{{ __('Statistics')}} </h5>
                    </div>
                    <div class="widget-content" >
                        <div id="container" style="width: 75%;">
                            <canvas id="canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="widget-box span6">
                    <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                        <h5>{{ __('Statistics')}} </h5>
                    </div>
                    <div class="widget-content" >
                        <div class="row-fluid">
                            <div class="span6">
                                <canvas id="myChart" width="400" height="400"></canvas>
                            </div>
                            <div class="span6">
                                <ul class="site-stats">
                                    <li class="bg_lh"><i class="icon-group"></i> <strong>{{ $dataCount['clients_count'] }}</strong> <small>Total clients</small></li>
                                    <li class="bg_lh"><i class="icon-ban-circle"></i> <strong>{{ $dataCount['clients_bloque'] }}</strong> <small>Clients bloqués</small></li>
                                    <li class="bg_lh"><i class="icon-file"></i> <strong>{{ $dataCount['clients_docManque'] }}</strong> <small>Docs manquants </small></li>
                                    <li class="bg_lh"><i class="icon-info-sign"></i> <strong>{{ $dataCount['clients_infoManque'] }}</strong> <small>Infos manquantes</small></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('layout/js/Chart-bar.js') }}"></script>
    <script src="{{ asset('layout/js/utils.js') }}"></script>
    <script>
     
		var color = Chart.helpers.color;
        var labels ={!! json_encode($labels)!!};
        var data1 ={!! json_encode($data1)!!};

     
		var barChartData = {
			labels: labels,
			datasets: [{
				label: 'Clients',
				backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
				borderColor: window.chartColors.green,
				borderWidth: 1,
				data: data1
			}]

		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Nombre de clients par région'
					}
				}
			});

		};

	</script>

    
    <script src="{{ asset('layout/js/Chart.js') }}"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');

        var clients_count ={!! json_encode($dataCount['clients_count'])!!};
        var clients_blq ={!! json_encode($dataCount['clients_bloque'])!!};
        var clients_info ={!! json_encode($dataCount['clients_infoManque'] )!!};

        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Clients qualifiés', 'Informations manquantes'],
                datasets: [{
                    label: '# of Votes',
                    data: [clients_count - clients_blq - clients_info , clients_info],
                    backgroundColor: [
                        '#84c49c',
                        '#ea9d1c'
                    ],
                    borderColor: [
                        '#84c49c',
                        '#ea9d1c'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
              
            }
        });
    </script>

    <script>
        $(document).ready(function() {


            $("#bloque").click(function() {

                $.ajax({
                    url: "{{ route('statistique.bloque') }}",
                    cache: false,
                    success: function(r) {
                        $("#display").hide().html(r).fadeIn(500);
                    }
                });
            });



            $("#ville").click(function() {
                $.ajax({
                    url: "{{ route('statistique.listVille') }}",
                    cache: false,
                    success: function(r) {
                        $("#display").hide().html(r).fadeIn(500);
                    }
                });
            });

            $("#tout").click(function() {
                $.ajax({
                    url: "{{ route('statistique.tout') }}",
                    cache: false,
                    success: function(r) {
                        $("#display").hide().html(r).fadeIn(600);
                    }
                });
            });

            $("#toutInfo").click(function() {
                $.ajax({
                    url: "{{ route('statistique.toutInfo') }}",
                    cache: false,
                    success: function(r) {
                        $("#display").hide().html(r).fadeIn(600);
                    }
                });
            });


            $("#docManquant").click(function() {
                $.ajax({
                    url: "{{ route('statistique.docManque') }}",
                    cache: false,
                    success: function(r) {
                        $("#display").hide().html(r).fadeIn(600);
                    }
                });
            });

            $("#infoManquant").click(function() {
                $.ajax({
                    url: "{{ route('statistique.infoManquant') }}",
                    cache: false,
                    success: function(r) {
                        $("#display").hide().html(r).fadeIn(600);
                    }
                });
            });

            $("#userBloque").click(function() {
                $.ajax({
                    url: "{{ route('statistique.userBloque') }}",
                    cache: false,
                    success: function(r) {
                        $("#display").hide().html(r).fadeIn(600);
                    }
                });
            });
            $("#recouv").click(function() {
                $.ajax({
                    url: "{{ route('statistique.recouvrement') }}",
                    cache: false,
                    success: function(r) {
                        $("#display").hide().html(r).fadeIn(500);
                    }
                });
            });
        });

    </script>
@endsection
