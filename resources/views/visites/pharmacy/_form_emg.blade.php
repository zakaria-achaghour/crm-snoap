<div class="widget-box">
    <div class="widget-title emg"> <span class="icon"> <i class="icon-gift"></i> </span>
        <h5 class="emg">EMG</h5>
    </div>
    <div class="widget-content nopadding">
        <div class="finDisplay">

            <div class="addpf">
                <!------------------ champs 3 ------------------>
                <div class="control-group">
                    <label for="emg" class="control-label ">Produits</label>
                    <div class="controls">
                        <select class="form-control span6 " id="emg" name="emg">
                            <option value=""></option>

                            @for ($i = 0; $i < count($emgs); $i++)
                                <option value="{{ $emgs[$i]->id }}">
                                    {{ $emgs[$i]->designation }}
                                </option>
                            @endfor
                        </select>

                    </div>
                </div>
                <div class="control-group hide" id="emg_qte">
                    <!------------------ champs 3.1.1 ------------------>
                    <label for="qte" class="control-label">Quantité</label>
                    <div class="controls">
                        <a id="emg_p" class="btn btn-default btn-large radius-left"><i class="icon-plus"></i></a>
                        <input type="number" step="1" class="span1 text-center form-control height34 " name="qteEmg"
                            id="qteEmg" value="{{ old('qte', 0 ?? null) }}" disabled>
                        <a id="emg_m" class="btn btn-default btn-large  radius-right"><i class="icon-minus"></i></a>

                        <!------- fin error message --------->
                    </div>
                </div>

                <div class="form-actions">

                    <a class="btn btn-success btn-large hide saveEmg">Enregistrer</a>
                    <a class="btn btn-primary btn-large pull-right hide visites">Fin</a>



                </div>
            </div>
        </div>
        <div id="displayEmgTable">

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        var visite_id = $("#visiteID").val();
        $('.visites').show();
        $('.demande').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#emg").on("change", function() {
            if ($(this).val() != "") {

                $('#emg_qte').show(500);

            } else {

                $('#emg_qte').hide(500);
                $("input[name=qteEmg]").val(0);
                $('.saveEmg').hide(250);

            }
        });

        $("#emg_p").click(function() {

            $("#qteEmg").val(parseInt($("#qteEmg").val()) + 1);

            if ($("#qteEmg").val() > 0) {
                $('.saveEmg').show(500);
            } else {
                $('.saveEmg').hide(250);
            }

        });

        $("#emg_m").click(function() {

            if ($("#qteEmg").val() > 0) {

                $("#qteEmg").val(parseInt($("#qteEmg").val()) - 1);

            }

            if ($("#qteEmg").val() > 0) {
                $('.saveEmg').show(500);
            } else {
                $('.saveEmg').hide(250);
            }

        });

        $('.saveEmg').click(function(e) {
            if ($("#emg").val() == "" || $("#qteEmg").val() == 0) {} else {
                e.preventDefault();
                var product_id = $("#emg").val();
                var qte = $("#qteEmg").val();
                $("#emg option:selected").remove();
                $("#emg option:first").attr('selected', 'selected');
                $("input[name=qteEmg]").val(0);
                $('.saveEmg').hide(250);
                $('#emg_qte').hide(500);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('visites.emgStore.pharmacy') }}",
                    data: {
                        visite_id: visite_id,
                        product_id: product_id,
                        qte: qte,
                    },
                    success: function(data) {
                        $("#displayEmgTable").hide().html(data).fadeIn(100);
                    }
                });
            }
        });

        $('.visites').click(function(e) {
            e.preventDefault();
            swal.fire({
                title: "Confirmation!!",
                icon: 'question',
                text: "Êtes-vous sûr de vouloir créer cette visite? ",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui",
                cancelButtonText: "Non"
            })
            .then((willDelete) => {
                if (willDelete.value === true) {
                    var data = {
                        "_token": $('input[name=_token]').val(),
                        "id": visite_id,
                    };
                    var url = "{{route('visites.fin.pharmacy', [":id"])}}";
                         url = url.replace(':id', visiteId);
          
                    $.ajax({
                        type: "get",
                        url: url,
                        data: data,
                        success: function(response) {
                            swal.fire("Visite créée avec succès!", response.status, "success")
                                .then((result) => {
                                    var url = "{{route('visites.index.pharmacy')}}";
                                    window.location.href =url;
                                });
                        }
                    });
                }
            });
        });

        var url = "{{route('visites.clientEmg.pharmacy', [":id"])}}";
                         url = url.replace(':id', visiteId);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $("#displayEmgTable").hide().html(data).fadeIn(0);
            }
        });

        if ($("#visite_fin").val() == 1) {
            $(".saveEmg").hide();
            $(".visites").hide();
            $(".saveProduct").hide();
            $(".savePlv").hide();
            $(".delete_fin").hide();
            $(".demande").hide();
        }

        if ($("#visite_fin").val() == 1) {
            $(".finDisplay").hide();
        }
    });
</script>
