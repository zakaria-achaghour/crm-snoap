<div id="display">
    <div class="row-fluid hidden-phone">
        <div class="widget-box span12">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                <h5>{{ __('Statistics') }} </h5>
            </div>
            <div class="widget-content">
                <div id="container" style="width: 95%;">
                    <canvas id="canvas"></canvas>

                </div>
                
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="widget-box widget-plain">
            <div class="center">
                <ul class="stat-boxes2">


                    @for ($i = 0; $i <5; $i++)
                        <li>
                            <div class="left"><span>
                                <i width="50"  height="24" class="icon-bar-chart chart-size @if($data3[$i]<50000) text-success @elseif($data3[$i]<100000) text-warning @else text-danger @endif "></i>
                                </span>{{ $data2[$i]*100/$data1[$i]}}%</div>
                            <div class="right"> <strong>{{ number_format($data3[$i],2)}}</strong> Le reste {{ $labels[$i]}} </div>
                        </li>
                    @endfor
                    <li>
                        <div class="right "> <strong>{{ number_format($total,2)}}</strong> Total impayé </div> 
                    </li>  
                    
                </ul>
            </div>
        </div>
    </div>
    
    <div class="row-fluid">
        <div class="widget-box span12">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                <h5>{{ __('unpaid checks per year') }} </h5>
            </div>
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th class="table-action">{{ __('year')}}</th>
                        <th class="table-action">{{ __('Number of unpaid checks')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cheques as $cheque)
                        <tr>
                            <td class="table-action">{{ $cheque->annee }}</td>
                            <td class="table-action">{{ $cheque->cheque }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>


<script>
    var color = Chart.helpers.color;
    var labels = {!! json_encode($labels) !!};
    var data1 = {!! json_encode($data1) !!};
    var data2 = {!! json_encode($data2) !!};
    var data3 = {!! json_encode($data3) !!};


    var barChartData = {
        labels: labels,
        datasets: [{
                label: 'Montant',
                lineTension: 0,
                backgroundColor: color(window.chartColors.orange).alpha(0.0).rgbString(),
                borderColor: window.chartColors.orange,
                borderWidth: 1,
                data: data1
            },
            {
                label: 'Montant payé',
                lineTension: 0,
                backgroundColor: color(window.chartColors.blue).alpha(0.0).rgbString(),
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: data2
            },
            {
                label: 'Montant réstant',
                lineTension: 0,
                backgroundColor: color(window.chartColors.red).alpha(0.0).rgbString(),
                borderColor: window.chartColors.red,
                borderWidth: 1,
                data: data3
            }
        ]

    };


    var ctx = document.getElementById('canvas').getContext('2d');
    window.myBar = new Chart(ctx, {
        type: 'line',
        data: barChartData,
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Montant des cheques impayé par année'
            }
        }
    });

</script>

<script src="{{ asset('layout/js/matrix.tables.js')}}"></script>
