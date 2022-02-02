
$(document).ready(function(){
	
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();
    $('.datepicker').datepicker();
});

$(document).ready(function() { 	

	//------------- Tags plugin  -------------//
	
	$("#tags").select2({
		tags:["red", "green", "blue", "orange"]
	});

	//------------- Elastic textarea -------------//
	if ($('textarea').hasClass('elastic')) {
		$('.elastic').elastic();
	}

	//------------- Input limiter -------------//


	//------------- Masked input fields -------------//

	//------------- Toggle button  -------------//


	//------------- Spinners with steps  -------------//


	//------------- Colorpicker -------------//
	if($('div').hasClass('picker')){
		$('.picker').farbtastic('#color');
	}	
	//------------- Datepicker -------------//
	if($('#datepicker').length) {
		$("#datepicker").datepicker({
			showOtherMonths:true
		});
	}
	if($('#datepicker-inline').length) {
		$('#datepicker-inline').datepicker({
	        inline: true,
			showOtherMonths:true
	    });
	}

	//------------- Combined picker -------------//
	if($('#combined-picker').length) {
		$('#combined-picker').datetimepicker();
	}
	
    //------------- Time entry (picker) -------------//


	//------------- Select plugin -------------//
	$("#select1").select2();
	$("#select2").select2();

	//--------------- Dual multi select ------------------//

	//--------------- Tinymce ------------------//
	

});//End document ready functions

//sparkline in sidebar area
