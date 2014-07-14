$("#widget").append("<script type='text/javascript' src='/sites/all/themes/osu_confident/js/jquery.livequery.js'></script>");
$("#widget").append("<script type='text/javascript' src='http://www.librarything.com/api_getdata.php?userid=ValleyKindle&key=1288152105&coverwidth=70&resultsets=books&callback=kindleWidget&booksort=author&max=500'></script>");


// Runs on librarything load, sets up arrays and displays first nine books
function kindleWidget (results) {
		boooks = results.books;

		// Get array associating natural numbers with book keys
		var i = 1;
		keys = new Array();
		for (key in boooks) {
			keys[i] = key;
			i++;
		}
		total = keys.length -1;
		kindleDisplay(1,14);

}


// Updates the display status of back/next links
function toggleLinks () {
	if (start-14 <= 0)
		$("#back").hide();
	else
		$("#back").show();
	if (end >= total)
		$("#next").hide();
	else
		$("#next").show();
}


// While getting books numbered from START to END, print the book with the key correspding to the current number
function kindleDisplay (current, last) {
	$("#widget_display").empty();
	start = current;
	end = last;
	while (current <= last) {
		var key = keys[current];
		if (key) {
			var book = boooks[key].title;
			var cover = boooks[key].cover;
			if (boooks[key].ISBN) {
				$("#widget_display").append("<div><a href='http://www.librarything.com/isbn/" + boooks[key].ISBN + "'><img src='" + cover + "' title='" + book + "' alt='" + book + "' /></a></div>");
			} else {
				$("#widget_display").append("<div><img src='" + cover + "' title='" + book + "' alt='" + book + "' /></div>");
			}
		}
		current++;
	}
	$("#widget span").text("Page " + Math.round(current/14) + "/" + Math.ceil(total/14));
	toggleLinks();
}


// Update display with back/next links are clicked
$("#back").click(function() {
	if (start-14 >= 0)
		kindleDisplay(start-14, end-14);
	return false;
});

$("#next").click(function() {
	if (end < total)
		kindleDisplay(start+14, end+14);
	return false;
});


function tooltip() {
	$("#widget_display img").livequery(function() {
		$(this).hover(function(e) {
			tip = this.title;
			this.title = "";
			$("#widget").after("<div id='tooltip'>" + tip + "</div>");
			$("#tooltip")
				.css("top",(e.pageY - 45) + "px")
				.css("left",(e.pageX + 5) + "px")
		}, function() {
			this.title = tip;
			$("#tooltip").remove();
		});
	});
	$("#widget_display img").livequery("mousemove", function(e) {
		$("#tooltip")
			.css("top",(e.pageY - 45) + "px")
			.css("left",(e.pageX + 5) + "px");
	});
};

$(document).ready(function() {
	var browser=navigator.appName;
	var b_version=navigator.appVersion;
	var version=parseFloat(b_version);
	if (browser!="Microsoft Internet Explorer" || version>4)
		tooltip();
});