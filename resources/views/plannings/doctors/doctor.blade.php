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
        <h1>Choix Médecin <span id="nb"></span></h1>
        <input type="hidden" value="{{ $de }}" id="de" >
        <input type="hidden" value="{{ $a }}" id="a" >

        <form class="form-horizontal" method="POST" action="#" enctype="multipart/form-data">
            <select multiple="multiple" name="doctor" id="doctor">
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">

                         {{ $doctor->name }} | {{ $doctor->designation }} | {{ $doctor->statut_mc ==='PRIVE'?'P':'H' }} | {{ $doctor->adresse }} 
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
        var select = document.getElementById("doctor");
        multi(select, {
            non_selected_header: "Médecins",
            selected_header: "Planning"
        });

        $("select[name=doctor]").on("change", function() {
            var id = $("#doctor").val();
            if(id==null){
                $("#nb").text("[0]");
            }else{
                $("#nb").text("["+id.length+"]");
            }            
            
        });

        $("#submit").on("click", function() {
            if($("#doctor").val()!=null){
                var de = $("#de").val();
                var a = $("#a").val();
                var delegue = $("#delegue").val();
                var id = $("#doctor").val();
                
                var url = "{{route('plannings.store.doctors', [":id",":de",":a",":delegue"])}}";
                    url = url.replace(':id', id);
                    url = url.replace(':de', de);
                    url = url.replace(':a', a);
                    url = url.replace(':delegue', delegue);

                $.ajax({
                    url: url,
                    cache: false,
                    success: function(r) {
                        $("#displayDoctors").hide().html(r).fadeIn(100);
                    }
                });
            }else{
                Swal.fire({
                        icon: 'error',
                        title: 'Erreur...',
                        text: 'Veuillez choisir au moins un médcin',
                    })
            }
            
        });
    </script>
</body>

</html>
