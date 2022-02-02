@extends('layouts.dashboard.designe')
@section('title', 'ADV')
@section('content')
    <!--------------------------------------- form create ----------------------------------------->

    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb">
            {{-- <a href="{{ route('advs.index') }}" title="Liste Des ADV" class="tip-bottom "><i
                class="icon-book"></i> ADV</a> --}}
        </div>
    </div>
    <!--End-breadcrumbs-->

 
    <div class="container-fluid">
        <hr>
        <!-- ============================================================== -->
        <!-- Start Form Create User -->
        <!-- ============================================================== -->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Valider Livraison</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST" action="#"
                        >
                        @csrf
                        {{-- @method('PUT') --}}
                  
                        <input type="hidden" value="{{ $adv->id }}" id="adv"/>

                       @include('adv.livrer._form_achat')

                    {{-- <div class="form-actions">
                        <button type="submit" class="btn btn-success span2  offset3">Livrer</button>
                       
                    </div> --}}
                    <div class="form-actions">
                        <a class="btn btn-success btn-large livrer">Livrer</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.livrer').click(function(e) {
            if ($("#adv").val() == '' || $("#demandeur").val() == '' || $("#network").val() == '' || $(
                    "#regionmc").val() == ''|| $(
                    "#ug").val() == ''|| $(
                    "#doctor").val() == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur...',
                    text: 'Merci de remplir tous les champs',
                })
            } else {
                var adv = $("#adv").val();
                var demandeur = $("#demandeur").val();
                var network = $("#network").val();
                var regionmc = $("#regionmc").val();
                var ug = $("#ug").val();
                var doctor = $("#doctor").val();


                swal.fire({
                        title: "Confirmation!!",
                        icon: 'question',
                        text: "Êtes-vous sûr de vouloir Livrer cet article? ",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Oui",
                        cancelButtonText: "Non"
                    })
                    .then((willDelete) => {
                        if (willDelete.value === true) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('advs.livrer.store') }}",
                                data: {
                                    adv: adv,
                                    demandeur: demandeur,
                                    network: network,
                                    regionmc: regionmc,
                                    ug:ug,
                                    doctor:doctor
                                },
                                success: function(response) {
                                    swal.fire("Enregestré avec succès!", response
                                            .status,
                                            "success")
                                        .then((result) => {
                                            window.location.href = '/adv/historique';
                                        });
                                }
                            });
                        }
                    });
            }

        });
    });
</script>

    

@endsection