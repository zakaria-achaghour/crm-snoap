@extends('layouts.dashboard.designe')
@section('title', 'ADVS')
@section('content')

    <div id="content-header">
        <div id="breadcrumb">
            <a href="{{ route('advs.index') }}" title="Liste Des ADV" class="tip-bottom "><i class="icon-book"></i>
                ADV</a>
            <a href="{{ route('advs.create') }}" title="Ajouter Commande" class="tip-bottom current"><i
                    class="icon-bar-chart"></i>Commande</a>
        </div>
    </div>


    <div class="container-fluid">
        <hr>
        <!-- ============================================================== -->
        <!-- Start Form Create User -->
        <!-- ============================================================== -->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Creation Commande</h5>
                </div>
                <div class="widget-content ">
                    <form class="form-horizontal" id="form_validation" method="POST" action="#"
                        enctype="multipart/form-data">
                        @csrf
                        @include('adv.commander._form_achat')
                        <div class="form-actions">
                            <a class="btn btn-success btn-large commander">Enregistrer</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="display"></div>
    </div>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.commander').click(function(e) {
                if ($("#adv_id").val() == '' || $("#tva").val() == '' || $("#budgetReel").val() == '' || $(
                        "#fournisseur").val() == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur...',
                        text: 'Merci de remplir tous les champs',
                    })
                } else {
                    var adv = $("#adv_id").val();
                    var tva = $("#tva").val();
                    var budgetReel = $("#budgetReel").val();
                    var fournisseur = $("#fournisseur").val();


                    swal.fire({
                            title: "Confirmation!!",
                            icon: 'question',
                            text: "Êtes-vous sûr de vouloir Commander cet article? ",
                            type: "warning",
                            showCancelButton: !0,
                            confirmButtonText: "Oui",
                            cancelButtonText: "Non"
                        })
                        .then((willDelete) => {
                            if (willDelete.value === true) {
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('advs.commande.store') }}",
                                    data: {
                                        id: adv,
                                        tva: tva,
                                        budgetReel: budgetReel,
                                        fournisseur: fournisseur
                                    },
                                    success: function(response) {
                                        swal.fire("Commande créée avec succès!", response
                                                .status,
                                                "success")
                                            .then((result) => {
                                                window.location.href = '/adv/commander';
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
