$(document).ready(function() {

// Function for adding more books (up to 15)
var osubooks=2;
function addBook() {
	if (osubooks<16) {
		$("#osubooks").append("<p><label>Title " + osubooks + ": <input type=\"text\" name=\"" + osubooks + "_title\" /></label><br /><label>Author " + osubooks + ": <input type=\"text\" name=\"" + osubooks + "_author\" /></label></p>");
		osubooks++;	
	} else {
		$("#addBook").attr("disabled", "true");
	}
}



// RESTORE FORM

// Restore extra titles
i=2;
while (($.cookie(i + "_title")) || ($.cookie(i + "_author"))) {
	addBook();
	i++;
};

// Use session cookies to restore form on load
$("input[type=text]").each(function() {
	//if this item has been cookied, restore it
	var name = $(this).attr("name");
	if ($.cookie(name)) {
		$(this).val($.cookie(name));
	};
});

// Restore type on load
$("input[type=radio]").each(function() {
	if ($.cookie("type") == $(this).val())
		$(this).attr("checked", "checked");
	else
		$(this).removeAttr("checked");
});




// STORE INPUTS IN COOKIES

// On text input change, store values in session cookies
$("input[type=text]").livequery("change", function() {
	$.cookie($(this).attr("name"), $(this).val());
});


// On radio change, store radio values in session cookies
$("input[type=radio]").change(function() {
	$.cookie("type", $(this).val());
});



// UPDATE DISPLAY

// On click, add book
$("#addBook").click(function() {addBook();});


// On blue, display email confirmation error if appropriate
$("#confirm").after("<p style=\"display: none\" id=\"error\">Please confirm your email address.</p>");

$("input[name^=\"email\"]").blur(function(){
	var email = $("input[name=\"email_confirm\"]").attr("value");
	if (email != "") {
		if (email != $("input[name=\"email\"]").attr("value"))
			$("#confirm + p").css("display", "block");
		else
			$("#confirm + p").css("display", "none");
	}
});

});