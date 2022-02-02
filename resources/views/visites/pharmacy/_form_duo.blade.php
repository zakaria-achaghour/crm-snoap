<div class="widget-box">
    <div class="widget-title duo"> <span class="icon"> <i class="icon-group"></i> </span>
        <h5 class="duo">DUO</h5>
    </div>
    <div class="widget-content nopadding">

        <!------------------ champs 5 ------------------>
        <div class="control-group">
            <label class="control-label">Duo</label>
            <div class="controls">
                <input type="hidden" id="duo" value="{{(count($duo)>0) ? 1:0}}">

                <input type="hidden" id="pfMsp" value="0">

                <a id="duo_oui" class="btn btn-default btn-large mr-3">OUI</a>
                <a id="duo_non" class="btn btn-danger btn-large  mr-3">NON</a>

            </div>
        </div>

        <div id="animateur" class="hide">
            <div class="control-group selectetsearch">
                <select multiple="multiple" name="getanimateur" id="getanimateur" >
                    @foreach ($responsable as $responsable)
                        <option value="{{ $responsable->id }}" {{ isset($duo)?(($duo->pluck('responsable_id')->contains($responsable->id)?' selected':'')):'' }} >{{ $responsable->firstname . ' ' . $responsable->lastname }}
                            </option>
                    @endforeach
                    
                </select>
                    
            </div>
        </div>

            <!------------------ fin champs 5 ------------------>
        <div class="form-actions">

            <a class="btn btn-success btn-large saveduo hide">Enregistrer</a>
            <a class="btn btn-primary btn-large pull-right plv">Etape suivante</a>
        </div>

    </div>

    <script>
         $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       // alert('duo'+$('#duo').val());
        var select = document.getElementById("getanimateur");
        multi(select, {
            non_selected_header: "",
            selected_header: ""
        });

        $("select[name=getanimateur]").on("change", function() {
            var id = $("#getanimateur").val();
            if(id!=null){

                $(".saveduo").show(500);
                
            }else{
                $(".saveduo").hide(500);
            }
                    
            
        });

        var show_plv = 0;
        
        $('#duo_oui').click(function(e) {
            $("#duo_non").removeClass("btn-danger");
            $("#duo_oui").addClass("btn-success");
            $("#animateur").removeClass("hide");
            $("#responsable").removeClass("hide");
            $(".plv").hide(500);        

        });
        $('#duo_non').click(function(e) {
            $("#duo_oui").removeClass("btn-success");
            $("#duo_non").addClass("btn-danger");
            $("#animateur").addClass("hide");
            $("#responsable").addClass("hide");
            $(".saveduo").hide(500);
            if(show_plv==0){
                $(".plv").show(500);
            }
            $('#getanimateur').val([]);
        });
    
        $('.saveduo').click(function(e) {
            
            e.preventDefault();
           // var respo = $("#getrespo").val();
            var responsable = $("#getanimateur").val();
            var visiteId = $("#visiteID").val();
            var client_id = $("#client_id").val();
          
            $("#duo_non").addClass("disable-click");
            $("#duo_oui").addClass("disable-click");
            $(this).hide();

            $("#getanimateur option").prop("disabled", true);

            $.ajax({
                type: 'POST',
                url: "{{ route('visites.duostore.pharmacy') }}",
                data: {
                    visiteId: visiteId,
                  //  respo: respo,
                    responsable: responsable,
                    client_id:client_id,
                },
                success: function(data) {
                    $("#displayPlv").hide().html(data).fadeIn(100);
                }
            });
        });

        $('.plv').click(function(e) {
            show_plv++;
            $(this).hide();
            $("#visiteStep").val(5);

            var visiteId = $("#visiteID").val();
            var client_id = $("#client_id").val();

          
            var url = "{{route('visites.plv.pharmacy', [":visite",":client"])}}";
                url = url.replace(':visite', visiteId);
                url = url.replace(':client', client_id);

            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    $("#displayPlv").hide().html(data).fadeIn(100);
                }
            });
        });

        if( $("#duo").val() == 1) {
            $('.plv').hide();
            $("#duo_non").removeClass("btn-danger");
            $("#duo_oui").addClass("btn-success");
            $("#animateur").removeClass("hide");
            $("#responsable").removeClass("hide");
            $("#duo_non").addClass("disable-click");
            $("#duo_oui").addClass("disable-click");
            

            $("#getanimateur option").prop("disabled", true);
        }else{
            $("#duo_oui").removeClass("btn-success");
            $("#duo_non").addClass("btn-danger");
            $("#animateur").addClass("hide");
            $("#responsable").addClass("hide");
            if(show_plv==0){
                $(".plv").show(500);
            }
            $('#getanimateur').val([]);
            $('.show').hide();

        }

        if ($("#visiteStep").val() >= 5) {
            show_plv++;

            $(".saveduo").hide();
            $(".plv").hide();

            var visiteId = $("#visiteID").val();
            var client_id = $("#client_id").val();
            var url = "{{route('visites.plv.pharmacy', [":visite",":client"])}}";
                url = url.replace(':visite', visiteId);
                url = url.replace(':client', client_id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    $("#displayPlv").hide().html(data).fadeIn(100);
                }
            });
        }
            
        if ($("#visite_fin").val() == 1) {

            $("#duo_non").addClass("disable-click");
            $("#duo_oui").addClass("disable-click");
            if ($('#duo').val()==0){
                $(".duo").addClass("widget-title-orange");
            }else{
                $(".duo").addClass("widget-title-green");
            }

        }

    });

</script>

