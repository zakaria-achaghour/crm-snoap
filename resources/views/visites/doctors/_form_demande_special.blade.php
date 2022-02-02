<div class="widget-box">
    <div class="widget-title demandeSpecial"> <span class="icon"> <i class="icon-tasks"></i> </span>
        <h5 class="demandeSpecial">DEMANDE SPECIALE</h5>
    </div>
    <div class="widget-content  nopadding">
       
            <div class="control-group ouiNonDemande">
                <label class="control-label">Demande speciale</label>
                <div class="controls">
    
                
    
                    <a id="demande_oui" class="btn btn-default btn-large mr-3">OUI</a>
                    <a id="demande_non" class="btn btn-danger btn-large  mr-3">NON</a>
    
                </div>
            </div>
            <div class="control-group hide showDemande">
             
                <div class="controls ">
                    <textarea class="form-control span10" name="demandeText" id="demandeText"  rows="4"></textarea>
                </div>
            </div>
            
            <div class="form-actions">

                <a class="btn btn-success btn-large hide saveDemande">Enregistrer</a>
                <a class="btn btn-primary btn-large pull-right visites ">fin</a>

            </div>
    
       
   
     

    </div>
</div>



<script>
    $(document).ready(function() {

        var visite_id = $("#visiteID").val();
      
       
       $('#demande_oui').click(function(e) {
            $("#demande_non").removeClass("btn-danger");
            $("#demande_non").addClass("btn-default");

            $(this).addClass("btn-success");
            $('.showDemande').show();
            $(".saveDemande").show(500);
            $('.visites').hide();

         

        });
        $('#demande_non').click(function(e) {
            $("#demande_oui").removeClass("btn-success");
            $("#demande_oui").addClass("btn-default");

            $(this).addClass("btn-danger");
            $(".saveDemande").hide(500);
            $('.showDemande').hide();

            $('.visites').show();

        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       

      
        $('.saveDemande').click(function(e) {

            var demande = $("#demandeText").val();
            var visiteId = $("#visiteID").val();
            
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
                    $.ajax({
                        type: "POST",
                        url: "{{ route('visites.demande.store') }}",

                        data: {
                            visiteId: visiteId,
                            demande: demande
                        },
                        success: function(response) {
                            swal.fire("Visite créée avec succès!", response.status, "success")
                            .then((result) => {
                                var url = "{{route('visites.index.doctor')}}";
                                window.location.href =url;
                            });
                        }
                    });
                }
            });
           
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
                   
                    var url = "{{route('visites.fin.doctor', [":visite"])}}";
                        url = url.replace(':visite', visiteId);
                       
                    $.ajax({
                        type: "get",
                        url: url,
                        success: function(response) {
                            swal.fire("Visite créée avec succès!", response.status, "success")
                                .then((result) => {
                                    var url = "{{route('visites.index.doctor')}}";
                                    window.location.href = url;
                                });
                        }
                    });
                }
            });
        });

        
      

      
        
        if ($("#visite_fin").val() == 1) {

            $(".saveEmg").hide();
            $(".visites").hide();
            $(".saveProduct").hide();
            $(".savePlv").hide();
            $(".delete_fin").hide();
            $(".demande").hide();

                        
            $('#demande_oui').addClass("disable-click");
            $('#demande_non').addClass("disable-click");

            if ($('#demandeSpecial').val()==0){
                $(".demandeSpecial").addClass("widget-title-orange");
                $("#demande_oui").removeClass("btn-success");
                $("#demande_oui").addClass("btn-default");
                $("#demande_non").addClass("btn-danger");
                 $("#demande_non").removeClass("btn-default");
                

            }else{
                $("#demande_oui").addClass("btn-success");
                $("#demande_oui").removeClass("btn-default");
                $("#demande_non").removeClass("btn-danger");
                 $("#demande_non").addClass("btn-default");
                $(".demandeSpecial").addClass("widget-title-green");
                $('.showDemande').show();
                $('.showDemande').addClass('disabled');
                $('#demandeText').val($("#demandeSpecial").val()) ;
                $('#demandeText').attr('disabled','disabled') ;
               $('.ouiNonDemande').hide();


            }

        }
        if ($("#visite_fin").val() == 1) {

            $(".finDisplay").hide();

            }

    });
</script>