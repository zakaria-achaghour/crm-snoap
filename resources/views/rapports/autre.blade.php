<div class="widget-box">
    <div class="widget-title"> <span class="icon"><i class="icon-user-md"></i></span>
        <h5>Autre médecin</h5>
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
                <label  class="control-label ">Ug</label>
                <div class="controls ">
                    <select multiple name='ugs[]' id="ugs" class='span8'>
                        @foreach ($ugs as $ug)
                            <option value="{{ $ug->id }}" >{{ $ug->designation }}  </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label  class="control-label ">Spécialité</label>
                <div class="controls ">
                    <select multiple name='specialtie[]' id="specialtie" class='span8'>
                        @foreach ($specialties as $specialtie)
                            <option value="{{ $specialtie->id }}" >{{ $specialtie->designation }}  </option>
                        @endforeach
                    </select>
                </div>
            </div>
           

            <div class="form-actions">
                <button  class="btn btn-success btn-large exporter" >Exporter</button>
            </div>
        </form>
        <div id="displayRapport">

        </div>
    </div>
</div>

<script>
    
    $(".exporter").click(function(e) {
        e.preventDefault();
        var de = $("#de").val();
        var a = $("#a").val();
        var ugs = $("#ugs").val();
        var specialties = $("#specialtie").val();
       
        if(de==''){
            de=0;
        }

        if(a==''){
            a=0;
        }

        if(de>a||de==0||a==0){
            alert('Date incorrecte');
        }else{
            
            var url = "{{route('rapport.visite.autre.table', [":de",":a",":ugs",":specialties"])}}";
                url = url.replace(':de', de);
                url = url.replace(':a', a);
                url = url.replace(':ugs', ugs);
                url = url.replace(':specialties', specialties);

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
