function showFormField(){
	var id = document.getElementById("spec_id").value;
	var fields = document.getElementById("spec_" + id);
	fields.style.display = "block";
			
	id = parseInt(id)+1;
	if(id > 15){
		document.getElementById("add_spec").style.display = "none";
	}

	document.getElementById("spec_id").value = id;
}

(function ($) {

	$.validator.setDefaults({
		submitHandler: function(form) {
		//use default form action
		form.submit(); 
		}
	});
	
	$.metadata.setType("attr", "validate");
	
	$(document).ready(function(){
		$("#hours-add").validate();
		// the form by default with javascript to keep it accessable
		//hide elements by class... that way when the user picks a type we can just show that class
		$("#term_start_date").focus();
		//datepicker
		$('.datepicker').datepicker({
			dateFormat: 'mm/dd/yy'
		});
		$('.time').timeEntry();
	});
}(jQuery));