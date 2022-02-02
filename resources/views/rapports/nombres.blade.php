
<div class="span6">
    <div class="widget-box ">
        <div class="widget-title"> <span class="icon"><i class="icon-map-marker"></i></span>
            <h5>NOMBRE DE VISITES PAR DELEGUE</h5>
        </div>
        <div class="widget-content nopadding">
            <form class="form-horizontal"  enctype="multipart/form-data">

                <div class="control-group">

                    <div class="controls">
                        De:&nbsp
                        <input type="date" class="span4 form-control" name="de" id="de" value="{{ Carbon\Carbon::now()->startOfWeek()->format('Y-m-d') }}">
                        &nbspA:&nbsp
                        <input type="date" class="span4 form-control" name="a" id="a" value="{{ date('Y-m-d',  strtotime('+1 day')) }}">
                    </div>
                </div>
                            
                @can('delegue', Auth::user())
                <input type="hidden" value="{{ Auth::id() }}" name="delegue" id="delegue" />
                @else
                <div class="control-group {{(count($delegues)>1)?'':'hide' }}">
                    <label  class="control-label ">Délégue</label>
                    <div class="controls ">
                        <select multiple name='delegues[]' id="delegue" class='span8'>
                           @foreach ($delegues as $delegue)
                                <option value="{{ $delegue->id }}" >{{ $delegue->firstname }} {{ $delegue->lastname }} </option>
                            @endforeach
                            
                        </select>
                    </div>
                </div>
                @endcan
            

                <div class="form-actions">
                    <button   class="btn btn-success btn-large exporter" >Exporter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="span6">
    <div class="widget-box ">
        <div class="widget-title"> <span class="icon"><i class="icon-map-marker"></i></span>
            <h5>NOMBRE DE VISITES PAR REGION</h5>
        </div>
        <div class="widget-content nopadding">
            <form class="form-horizontal"  enctype="multipart/form-data">

                <div class="control-group">

                    <div class="controls">
                        De:&nbsp
                        <input type="date" class="span4 form-control" name="de2" id="de2" value="{{ Carbon\Carbon::now()->startOfWeek()->format('Y-m-d') }}">
                        &nbspA:&nbsp
                        <input type="date" class="span4 form-control" name="a2" id="a2" value="{{ date('Y-m-d',  strtotime('+1 day')) }}">
                    </div>
                </div>
                            
                <div class="control-group">
                    <label  class="control-label ">Région</label>
                    <div class="controls ">
                        <select multiple name='regions[]' id="regions" class='span8'>
                        @foreach ($regions as $region)
                                <option value="{{ $region->id }}" >{{ $region->designation }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            

                <div class="form-actions">
                    <button   class="btn btn-success btn-large exporterRegion" >Exporter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="displayRapport">

</div>



@php
    $i=0;

@endphp


<script>
    
    $(".exporter").click(function(e) {
        e.preventDefault();
        var de = $("#de").val();
        var a = $("#a").val();
        var delegues = $("#delegue").val();
        var produit = $("#produit").val();
        var aa = [];
        if(delegues ==null){

            $("#delegue option").each(function(){
                   aa.push($(this).val());
                });
            delegues = aa.join(',');
        }
       
        if(de==''){
            de=0;
        }

        if(a==''){
            a=0;
        }

        if(de>a||de==0||a==0){
            alert('Date incorrecte');
        }else{
            var url = "{{route('rapport.visite.nombres.table', [":de",":a",":delegues"])}}";
                url = url.replace(':de', de);
                url = url.replace(':a', a);
                url = url.replace(':delegues', delegues);
            $.ajax({
                type: 'GET',
                url:url ,
                cache:false,
                success: function(r) {
                    $("#displayRapport").hide().html(r).fadeIn(500);
                }
            });
        }
        
    });

    $(".exporterRegion").click(function(e) {
        e.preventDefault();
        var de2 = $("#de2").val();
        var a2 = $("#a2").val();
        var regions = $("#regions").val();
   
        if(de2==''){
            de2=0;
        }

        if(a2==''){
            a2=0;
        }

        if(de2>a2||de2==0||a2==0){
            alert('Date incorrecte');
        }else{
            var url = "{{route('rapport.visite.nombres.regions.table', [":de2",":a2",":regions"])}}";
                url = url.replace(':de2', de2);
                url = url.replace(':a2', a2);
                url = url.replace(':regions', regions);
            $.ajax({
                type: 'GET',
                url:url ,
                cache:false,
                success: function(r) {
                    $("#displayRapport").hide().html(r).fadeIn(500);
                }
            });
        }
        
    });
 </script>
 <script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
 <script src="{{ asset('layout/js/matrix.js') }}"></script>
