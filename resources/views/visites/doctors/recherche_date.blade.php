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
<div id="displayVisite">

</div>


<script>
    $('#document').ready(function() {
        var user = $("#user").val();
        var url = "{{route('visite.user.doctor', [":user"])}}";
             url = url.replace(':user', user);
        $.ajax({
            url: url,
            cache: false,
            success: function(r) {
                $("#displayVisite").hide().html(r).fadeIn(100);
            }
        });
    });
    $("#delegue").change(function() {
        var user = $("#delegue").val();
        var url = "{{route('visite.user.doctor', [":user"])}}";
             url = url.replace(':user', user);
        $.ajax({
            url: url,
            cache: false,
            success: function(r) {
                $("#displayVisite").hide().html(r).fadeIn(100);
            }
        });
    });

    $("#getDate").click(function() {
        user = $("#user").val();

        if ($("#delegue").val()) {
            user = $("#delegue").val();
        }


        var de = $("#de").val();
        var a = $("#a").val();

        if (de < a) {
            var url = "{{route('visite.recherche.doctor', [":de",":a",":user"])}}";
             url = url.replace(':user', user);
                url = url.replace(':de', de);
             url = url.replace(':a', a);

            $.ajax({
                url: url,
                cache: false,
                success: function(r) {
                    $("#displayVisite").hide().html(r).fadeIn(500);
                }
            });
        } else {
           
            var url = "{{route('planningError')}}";
            $.ajax({
                url: url,
                cache: false,
                success: function(r) {
                    $("#displayVisite").hide().html(r).fadeIn(100);
                }
            });
        }

    });
</script>