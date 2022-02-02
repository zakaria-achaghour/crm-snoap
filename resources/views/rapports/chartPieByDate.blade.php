
<canvas id="canvas2"></canvas>
<hr>
@php
    $total = $visites[0]+$visites[1]+$visites[2]+$visites[3];
@endphp
<div class="text-center">
    <ul class="stat-boxes2 text-center">

        <li>
            <div class="left peity_bar_neutral"><span>
            <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
            </span>{{ ($total==0)?'0':number_format( ($visites[0]*100/($total)) , 2, '.', '') }}%</div>
            <div class="right "> <strong>{{ $visites[0] }}</strong> PS </div> 
        </li> 
        <li>
            <div class="left peity_bar_neutral"><span>
            <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
            </span>{{ ($total==0)?'0':number_format( ($visites[1]*100/($total)) , 2, '.', '')}}%</div>
            <div class="right "> <strong>{{ $visites[1] }}</strong> PG </div> 
        </li>  
        <li>
            <div class="left peity_bar_neutral"><span>
            <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
            </span>{{ ($total==0)?'0':number_format( ($visites[2]*100/($total)) , 2, '.', '')}}%</div>
            <div class="right "> <strong>{{ $visites[2] }}</strong> HS </div> 
        </li>  
        <li>
            <div class="left peity_bar_neutral"><span>
            <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
            </span>{{ ($total==0)?'0':number_format( ($visites[3]*100/($total)) , 2, '.', '')}}%</div>
            <div class="right "> <strong>{{ $visites[3] }}</strong> HG </div> 
        </li>   
        
        <li>
            <div class="left peity_bar_neutral"><span>
            <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
            </span>100%</div>
            <div class="right "> <strong>{{ $total }}</strong> Total médecin </div> 
        </li>   
        
        <li>
            <div class="left peity_bar_neutral"><span>
            <i width="50"  height="24" class="icon-bar-chart chart-size text-success "></i>
            </span>100%</div>
            <div class="right "> <strong>{{ $pharmacie }}</strong> Total pharmacie </div> 
        </li>   
        
    </ul>
</div>
<script src="{{ asset('layout/js/Chart-bar.js') }}"></script>
<script src="{{ asset('layout/js/utils.js') }}"></script>
<script>


    data = {
        datasets: [{
            data: {!! json_encode($visites) !!},
            backgroundColor: ['#33d9b2', '#218c74', '#ffb142', '#cc8e35'],

        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
            'PS',
            'PG',
            'HS',
            'HG'
        ]
    };

    var ctx = document.getElementById('canvas2').getContext('2d');
    window.myBar = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Visites par spécialité'
            }
        }
    });
    


</script>
