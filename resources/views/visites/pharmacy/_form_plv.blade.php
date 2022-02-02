<div class="widget-box">
    <div class="widget-title plv"> <span class="icon"> <i class="icon-picture"></i> </span>
        <h5 class="plv">PLV</h5>
    </div>
    <div class="widget-content nopadding">
        <div class="finDisplay">

        <div class="addpf">
            <!------------------ champs 3 ------------------>
            <div class="control-group">
                <label for="porduit_fini" class="control-label ">Plv</label>
                <div class="controls">
                    <select class="form-control span6" id="plv"
                        name="plv">
                        <option value=""></option>

                        @for ($i = 0; $i < count($plvs); $i++)
                            <!-- { (old("distinataire") == $distinataire[$i]->id  ? "selected":"") }  Define the selected option with the old input -->
                            <option value="{{ $plvs[$i]->id }}">
                                {{ $plvs[$i]->designation }}</option>
                        @endfor
                    </select>
                    <!------- error message --------->

                    <!------- fin error message --------->
                </div>
            </div>

            <!------------------ fin champs 3.1.1 ------------------>
            <!------------------ fin champs 3.1 ------------------>
        </div>

        <div class="form-actions">

            <a class="btn btn-success btn-large hide savePlv">Enregistrer</a>
            <a class="btn btn-primary btn-large pull-right next-emg ">Etape suivante</a>

        </div>
        </div>
        <div id="displayPlvTable"></div>

    </div>
</div>


<script>
    $(document).ready(function() {
        var show_emg = 0;

        var client_id = $("#client_id").val();
        var url = "{{route('visites.getClientPlv.pharmacy', [":id"])}}";
             url = url.replace(':id', client_id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $("#displayPlvTable").hide().html(data).fadeIn(100);
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#plv").on("change", function () {
            if ($(this).val() != "") {

                $('.savePlv').show(500);

            } else{
                
                $('.savePlv').hide(250);

            }
        });

        $('.savePlv').click(function(e) {
            if ($("#plv").val() == "") {
            } else {
                e.preventDefault();
                var plv_id = $("#plv").val();
               
                var visiteId = $("#visiteID").val();


                $("#plv option:selected").remove();
                $("#plv option:first").attr('selected', 'selected');
                $('.savePlv').hide(500);

                if (show_emg == 0 && $("#visiteStep").val() ==5) {
                    $(".next-emg").show();
                    show_emg++;
                }

               
                $.ajax({
                    type: 'POST',
                    url: "{{ route('visites.plvstore.pharmacy') }}",
                    data: {
                        plv_id: plv_id,
                        client_id: client_id,
                        visite_id: visiteId
                    },
                    success: function(data) {
                        $("#displayPlvTable").hide().html(data).fadeIn(100);
                    }
                });
            }

        });

        $('.next-emg').click(function(e) {
           
            show_emg++;
            e.preventDefault();
            $(this).hide();
            var visiteId = $("#visiteID").val();  
            
            $("#visiteStep").val(6);        

            var url = "{{route('visites.emg.pharmacy', [":id"])}}";
             url = url.replace(':id', visiteId);
            $.ajax({
                type: 'GET',
                url: url,
               
                success: function(r) {
                    $("#displayEmg").hide().html(r).fadeIn(100);

                }
            });

        });

        if ($("#visiteStep").val() >= 6) {

            $(".next-emg").hide();

            var visiteId = $("#visiteID").val();
            var from = $("#from").val();
            var url = "{{route('visites.emg.pharmacy', [":id"])}}";
             url = url.replace(':id', visiteId);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(r) {
                    $("#displayEmg").hide().html(r).fadeIn(100);

                }
            });
        }

        if ($("#visite_fin").val() == 1) {

            $(".finDisplay").hide();

            }
    });
</script>
