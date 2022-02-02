<hr>


    <div class="form-actions">
        <div class="control-group">

            <div class="controls">
                De:&nbsp
                <input type="date" class="span4 form-control" name="de" id="de" value="{{ old('de', $week_start ?? '') }}">
                &nbspA:&nbsp
                <input type="date" class="span4 form-control" name="a" id="a" value="{{ old('a', $week_end ?? '') }}">
            </div>
        </div>
        <button type="button" id="getDate" class="btn btn-success  btn-large"><i class="icon icon-search"></i>
            Recherche
        </button>
    </div>



        <!------------------------------- fin message de formation ------------------------------->
        <div id="displayPlanningDoctors">
            
        </div>
        

    </div>

    <script>
        $('#document').ready(function(){
            var user= $("#user").val();
           // console.log(user);
           var url = "{{route('plannings.user.doctors', [":id"])}}";
                url = url.replace(':id', user);
            $.ajax({
                    url: url,
                    cache: false,
                    success: function(r) {
                        $("#displayPlanningDoctors").hide().html(r).fadeIn(100);
                    }
                });
        });
        $("#delegue").change(function() {
            var user = $("#delegue").val();
           

            var url = "{{route('plannings.user.doctors', [":id"])}}";
                url = url.replace(':id', user);
            $.ajax({
                    url: url,
                    cache: false,
                    success: function(r) {
                        $("#displayPlanningDoctors").hide().html(r).fadeIn(100);
                    }
                });
        });
    
        $("#getDate").click(function() {
            user= $("#user").val();
          
            if($("#delegue").val()){
                user = $("#delegue").val();
            }
           
            
            var de = $("#de").val();
            var a = $("#a").val();

            if(de<a){
                var url = "{{route('plannings.recherche.doctors', [":de",":a",":id"])}}";
                url = url.replace(':id', user);
                url = url.replace(':de', de);
                url = url.replace(':a', a);
               // var url = "doctors/recherche/" +de+"/"+a+"/"+user;
                $.ajax({
                    url: url,
                    cache: false,
                    success: function(r) {
                        $("#displayPlanningDoctors").hide().html(r).fadeIn(500);
                    }
                });
            }else{
                var url = "{{route('planningError')}}";
                $.ajax({
                    url: url,
                    cache: false,
                    success: function(r) {
                        $("#displayPlanningDoctors").hide().html(r).fadeIn(100);
                    }
                });
            }
            
            
        });

    </script>