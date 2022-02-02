<div class="widget-box">
    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
        <h5>{{ __("Clients by city")}} </h5>
    </div>
    <div class="widget-content nopadding">
        <div class="form-actions">
            <form class="form-horizontal" id="form_validation" enctype="multipart/form-data">
                <div class="control-group">
                    <label class="control-label">{{ __("City")}}</label>
                    <div class="controls span6">
                        <select name='ville' id="getVille" value="{{ old('ville') }}">
                            <option value=""></option>
                            @foreach ($villes as $ville)
                                <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<div id="displayVille">

</div>

<script>
    $("#getVille").change(function() {
        var id = $("#getVille").val();
        var url = "statistique/ville/" + id;
        $.ajax({
            url: url,
            cache: false,
            success: function(r) {
                $("#displayVille").hide().html(r).fadeIn(500);
            }
        });
    });

</script>
<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
<script src="{{ asset('layout/js/matrix.js') }}"></script>
