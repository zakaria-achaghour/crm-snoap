<div class="container selectetsearch"> 
    <h1 class="text-center">Planning enregistré</h1>
    <img src="{{ asset('layout/img/check.png') }}" width="150px" height="150px" style="position: absolute;
    left: 50%;padding: 181px 0 0 0;-webkit-transform: translate(-50%, -50%);transform: translate(-50%, -50%);" />
</div>
<script>
    setTimeout(function() {
        var url = "{{route('plannings.index.pharmacies')}}";
        window.location.href =url;
    }, 1000);
</script>
