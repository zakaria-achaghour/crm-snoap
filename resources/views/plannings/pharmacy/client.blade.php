<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />

    <!-- Include multi.js -->
    <link rel="stylesheet" href="{{ asset('layout/css/multi.min.css') }}" />
    <script src="{{ asset('layout/js/multi.min.js') }}"></script>

</head>

<body>
    <div class="container selectetsearch">
        <h1>Choix Pharmacies <span id="nb"></span></h1>
        <input type="hidden" value="{{ $de }}" id="de" >
        <input type="hidden" value="{{ $a }}" id="a" >
      


        <form class="form-horizontal" method="POST" action="#" enctype="multipart/form-data">
            <select multiple="multiple" name="client" id="client">
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">
                        {{(($client->is==1)?'E':'P')}} | {{ $client->nom }} | {{ $client->adresse }}
                    </option>
                @endforeach
            </select>
            <br>
            @cannot('client.lecture', Auth::user())
                <div class='form-actions'>
                    <a id="submit" href='#' class="btn maxi-width btn-success btn-large">Enregistrer</a>
                </div>
            @endcannot
        </form>
    </div>



    <script>
        var select = document.getElementById("client");
        multi(select, {
            non_selected_header: "Pharmacies",
            selected_header: "Planning"
        });

        $("select[name=client]").on("change", function() {
            var id = $("#client").val();
            if(id==null){
                $("#nb").text("[0]");
            }else{
                $("#nb").text("["+id.length+"]");
            }            
            
        });

        $("#submit").on("click", function() {
            if($("#client").val()!=null){

                var de = $("#de").val();
                var a = $("#a").val();
                var delegue = $("#delegue").val();
                var id = $("#client").val();
            

                var url = "{{route('plannings.store.pharmacies', [":id",":de",":a",":delegue"])}}";
                    url = url.replace(':id', id);
                    url = url.replace(':de', de);
                    url = url.replace(':a', a);
                    url = url.replace(':delegue', delegue);

                $.ajax({
                    url: url,
                    cache: false,
                    success: function(r) {
                        $("#displayClient").hide().html(r).fadeIn(100);
                    }
                });
            }else{
                Swal.fire({
                        icon: 'error',
                        title: 'Erreur...',
                        text: 'Veuillez choisir au moins une pharmacie',
                    })
            }
        });
    </script>
</body>

</html>
