
<canvas id="canvas"></canvas>
<script src="{{ asset('layout/js/Chart-bar.js') }}"></script>
<script src="{{ asset('layout/js/utils.js') }}"></script>
<script>
    var color = Chart.helpers.color;
    var labels = {!! json_encode($labels) !!};
    var data1 = {!! json_encode($data1) !!};
    var data2 = {!! json_encode($data2) !!};
    var data3 = {!! json_encode($data3) !!};
  

    var barChartData = {
        labels: labels,
        datasets: [{
                label: 'Visite Pharmacie',
                lineTension: 0,
                backgroundColor: color(window.chartColors.orange).alpha(1.5).rgbString(),
                borderColor: window.chartColors.orange,
                borderWidth: 1,
                data: data1
            },
            {
                label: 'Visite médecin',
                lineTension: 0,
                backgroundColor: color(window.chartColors.blue).alpha(1.0).rgbString(),
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: data2
            },
            {
                label: 'Commande',
                lineTension: 0,
                backgroundColor: color(window.chartColors.green).alpha(1.0).rgbString(),
                borderColor: window.chartColors.green,
                borderWidth: 1,
                data: data3
            }
        ]

    };


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
                text: 'Nombre de visite par région'
            }
        }
    });


</script>
