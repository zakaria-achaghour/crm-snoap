
$(document).ready(function(){
	
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	

	
	// Form Validation
    $("#basic_validate").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	}); 
	
	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#password_validate").validate({
		rules:{
			pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			pwd2:{
				required:true,
				minlength:4,
				maxlength:20,
				equalTo:"#pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#form_validation").validate({
		rules:{
			fichier:{
				maxlength:40
			},
			intitule:{
				required: true,
				minlength:4,
				maxlength:550
			},
			sa:{
				required: true,
				minlength:4,
				maxlength:250
			},
			ss:{
				required: true,
				minlength:4,
				maxlength:250
			},
			motif_sa:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pmp:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pac:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pp:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pfab:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pfou:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pane:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pie:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pic:{
				required: true,
				minlength:4,
				maxlength:250
			},
			ppc:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pael:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pbat:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pautre:{
				required: true,
				minlength:4,
				maxlength:250
			},
			pwd:{
				required: true,
				minlength:6,
				maxlength:250
			},
			pwd2:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});


});
