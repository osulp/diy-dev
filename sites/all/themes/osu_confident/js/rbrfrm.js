$(document).ready(function() {


var materialsVar=2;
var courses=2;
var instructors=2;


function addMaterial () {
	$("#materials").append("<div class='material" + materialsVar + "'><h3 class='materialTypeHeading'>Material " + materialsVar + ": <span></span></h3><p><label>Material Type: <select name='" + materialsVar + "_Type' class='materialType'><option></option><option value='library material'>Library Material</option><option value='personal material'>Personal Material</option><option value='reserve binder'>Reserve Binder (signature required)</option><option value='reserve purchase request'>Reserve Purchase Request</option></select></label></p><div class='loan_copies'><p><label>Loan Period: <select name='" + materialsVar + "_Loan'><option value='3 hour'>3 hour</option><option value='2 day'>2 day</option></select></label></p><p><label># Copies: <select name='" + materialsVar + "_Copies'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select></label></p></div><div class='library_material'><p><label>Call Number: <input type='text' size='30' name='" + materialsVar + "_Call+Number' /></label></p><p><label>Title: <input type='text' size='30' name='" + materialsVar + "_Title' /></label></p><p><label>Author: <input type='text' size='30' name='" + materialsVar + "_Author' /></label></p></div><div class='personal_material'><p><label>Title: <input type='text' size='30' name='" + materialsVar + "_Title+' /></label></p><p><label>Author: <input type='text' size='30' name='" + materialsVar + "_Author+' /></label></p><p><label>Edition/Publication Year: <input type='text' size='30' name='" + materialsVar + "_Year' /></label></p></div><div class='reserve_binder'><p><label>Title: <input type='text' size='30' name='" + materialsVar + "_Title++' /></label></p><p><em>Please submit the same number of copies of each article for reserve reading packets.</em></p></div><div class='reserve_purchase_request'><p><label>Title: <input type='text' size='30' name='" + materialsVar + "_Title+++' /></label></p><p><label>Author: <input type='text' size='30' name='" + materialsVar + "_Author++' /></label></p><p><label>Edition/Publication Year: <input type='text' size='30' name='" + materialsVar + "_Year++' /></label></p><p><label>Publisher: <input type='text' size='30' name='" + materialsVar + "_Publisher' /></label></p><p><label>ISBN: <input type='text' size='30' name='" + materialsVar + "_ISBN' /></label></p></div></div>");
	
	materialsVar++;
	
	$(".materialType").change(function() {
		var foo = this.parentNode.parentNode.parentNode.className;
		// clear material-specific inputs and heading, and hide material-specific displays
		$("." + foo + " input").each(function() {$(this).val("");});
		$("." + foo + " .materialTypeHeading span").text("");
		$("." + foo + " div").hide();
		
		// display sections for selected material type, provided it is not blank
		var type = $(this).val().toString().replace(/ /g,"_");
		if (type) {
			$("." + foo + " .loan_copies").show();
			$("." + foo + " ." + type).show();
		}
		
		// set heading for selected material type
		var heading = $(this).children("option:selected").text();
		if (heading == "Reserve Binder (signature required)")
			var heading = "Reserve Binder (<a href='#copyright'>signature required</a>)";
		$("." + foo + " .materialTypeHeading span").html(heading);
	});
}

function addInstructor() {
	$("#instructor").append("<p class='nomargin'><label>Instructor " + instructors + ": <input type='text' size='30' name='INSTRUCTOR" + instructors + "' /></label></p>");
	instructors++;
}

function addCourse() {
	$("#course").append("<p class='nomargin'><label>Course Number " + courses + ": <input type='text' size='30' name='COURSENUMBER" + courses + "' /></label></p><p class='nomargin'><label>Course Title " + courses + ": <input type='text' size='30' name='COURSETITLE" + courses + "' /></label></p>");
	courses++;
}

// Restore extra material types
var i=2;
while ($.cookie(i + "_Type")) {
	addMaterial();
	i++;
};

// Restore extra instructors on load
var i=2;
while ($.cookie("INSTRUCTOR" + i)) {
	addInstructor();
	i++;
};

// Restore extra courses on load
var i=2;
while ($.cookie("COURSE" + i)) {
	addCourse();
	i++;
};
// Restore terms on load
$("input[type=checkbox]").each(function() {
	if ($.cookie($(this).val()) == "y")
		$(this).attr("checked", "checked");
	else
		$(this).removeAttr("checked");
});

// Restore stamp on load
$("input[type=radio]").each(function() {
	if ($.cookie("stamp") == $(this).val())
		$(this).attr("checked", "checked");
	else
		$(this).removeAttr("checked");
});

// Use session cookies to restore form on load
$("input[type=text], select, textarea").each(function() {
	//if this item has been cookied, restore it
	var name = $(this).attr("name");
	if ($.cookie(name)) {
		$(this).val($.cookie(name));
	};
	if ($(this).hasClass("materialType")) {
		var foo = this.parentNode.parentNode.parentNode.className;
		var type = $("option:selected", this).val().replace(" ","_").replace(" ","_");
		if (type) {
			$("." + foo + " .loan_copies").css("display", "block");
			$("." + foo + " ." + type).css("display", "block");
		};
	};
});


// Add on click
$("#addMaterial").click(function() {addMaterial();});
$("#addInstructor").click(function() {addInstructor();});
$("#addCourse").click(function() {addCourse();});


// When material type is changed, update the following displayed fields
$(".materialType").change(function() {
	var foo = this.parentNode.parentNode.parentNode.className;
	// clear material-specific inputs and heading, and hide material-specific displays
	$("." + foo + " input").each(function() {$(this).val("");});
	$("." + foo + " .materialTypeHeading span").text("");
	$("." + foo + " div").hide();
	
	// display sections for selected material type, provided it is not blank
	var type = $(this).val().toString().replace(/ /g,"_");
	if (type) {
		$("." + foo + " .loan_copies").show();
		$("." + foo + " ." + type).show();
	}
	
	// set heading for selected material type
	var heading = $(this).children("option:selected").text();
	if (heading == "Reserve Binder (signature required)")
		var heading = "Reserve Binder (<a href='#copyright'>signature required</a>)";
	$("." + foo + " .materialTypeHeading span").html(heading);
});


// On form change, store values in session cookies
$("input[type=text], select, textarea").livequery("change", function() {
	$.cookie($(this).attr("name"), $(this).val());
});

// On checkbox change, store checkbox values in session cookies
$("input[type=checkbox]").change(function() {
	if ($(this).attr("checked"))
		$.cookie($(this).val(), "y");
	else
		$.cookie($(this).val(), "n");
});

// On radio change, store radio values in session cookies
$("input[type=radio]").change(function() {
	$.cookie("stamp", $(this).val());
});


});