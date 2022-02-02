<div class="widget-box">
    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
        <h5>Visite Médecin </h5>
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
                    
            <div class="control-group">
                <label  class="control-label ">{{ __('Regions') }}</label>
                <div class="controls ">
                    <select multiple name='regionmc[]' id="region" class='span8'>
                        <option></option>
                        @foreach ($regionmcs as $regionmc)
                            <option value="{{ $regionmc->id }}" >{{ $regionmc->designation }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
         
            <div id="ugDisplay">
                @include('rapports.ug')
            </div>
            <div class="control-group">
                <label class="control-label">Produit</label>
                <div class="controls">
                    <select multiple name='produit[]' id="produit"  class='span8' >
                        <option value=""></option>
                        @foreach ($produits as $produit)
                            <option value="{{ $produit->id }}">{{ $produit->designation }}</option>
                        @endforeach
                    </select>
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
        <div id="displayRapport">

        </div>
    </div>
</div>



<script>
 

       
$("#region").change(function() {

    
    var regionchange = $("#region").val();
    if(regionchange ==null){
        regionchange = 'all'
    }
    var url = '/rapports/visite/change/ug/'+regionchange;
    var url = "{{route('rapport.visite.mdecine.change.ug', [":regionchange"])}}";
                url = url.replace(':regionchange', regionchange);
              
    $.ajax({
        type: 'GET',
        url:url ,
        cache:false,
        success: function(r) {
            $("#ugDisplay").hide().html(r).fadeIn(0);
        }
    });
   
   
});


$(".exporter").click(function(e) {
            e.preventDefault();

    var de = $("#de").val();
    var a = $("#a").val();
    var region = $("#region").val();
    var ug = $("#ug").val();
    var produit = $("#produit").val();
    var delegues = $("#delegue").val();
    
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
        
   
      

        var url = "{{route('rapport.visite.medecin.exporter', [":de",":a",":region",":ugs",":produit",":delegues"])}}";
                url = url.replace(':de', de);
                url = url.replace(':a', a);
                url = url.replace(':ugs', ug);
                url = url.replace(':region', region);
                url = url.replace(':delegues', delegues);
                url = url.replace(':produit', produit);
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
 

