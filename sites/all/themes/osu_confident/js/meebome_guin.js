/* ==========================================================
	Credits
=============================================================

Version:

	1.2	(08/04/2006)

Authors:

	aquaflare7
	- aquaflare7@gmail.com

	aquafusion studios
	- http://www.afstudios.net

Notes:

	This source code is protected and should not be
	copied or modified without expressed permission
	from it's rightful owner(s). If modifications
	are made you should state so under the version
	header above.

	Under no circumstances should any of the original
	authors be removed from the above list. The
	author(s) have put alot of work into this code
	and deserve due credit for it.

=============================================================
	Configuration
========================================================== */

// This is where you configure the default settings
// for the meebo library. meebome_mode can be either
// '1' (self), '2' (popup), or '3' (like 2, but
// supresses the popup failure alert box).

	var guin_meebome_mode =	'2';
	var guin_meebome_url =	'http://widget.meebo.com/mm.swf?cCezfiHUWx';

// If the meebome_mode is set to 'popup' the following
// default variables are read. meebome_unlock can be
// either '1' (can be resized) or '0' (set dimensions).

	var guin_meebome_width =	'450';
	var guin_meebome_height =	'300';
	var guin_meebome_unlock =	'1';

/* ==========================================================
	Usage Syntax
=============================================================

//loading the meebo application

	launch_meebome([new_mode,new_url,new_width,new_height,new_unlock,debug])

		- new_mode   :	override meebome_mode
		- new_url    :	override meebome_url
		- new_width  :	override meebome_width
		- new_height :	override meebome_height
		- new_unlock :	override meebome_unlock
		- debug	     :	displays a debug alert box when set to '1'
//example

	launch_meebome('2','','200','300','0');

		-This will create a 200x300 popup that cannot be resized.

	launch_meebome('1');

		-This will load meebo into the current window, ignoring
		 the meebome_mode variable.

//html link examples

	<a href="javascript:launch_meebome();">Launch meebo me!</a>

		-This is an html clickable link that will launch meebo me!
		with the default settings.

=============================================================
	Library
========================================================== */

// Below are the main contents of the meebo library. Do
// not modify unless you know exactly what you are doing.

//Declare needed variables in advance

	var guin_meebo_library_version = '1.2';

	var guin_meebome_window;
	var guin_meebome_current_mode;
	var guin_meebome_current_url;
	var guin_meebome_current_width;
	var guin_meebome_current_height;
	var guin_meebome_current_unlock;

//Begin the library of functions

function guin_meebome_window_exists() {
	var guin_meebome_exists;
	if (guin_meebome_window && !guin_meebome_window.closed) {
		//window does exist
		guin_meebome_exists = true;
	} else {
		//winow does not exist
		guin_meebome_exists =  false;
	}
	return guin_meebome_exists;
}
	
function chatting_image() {
	// document.getElementById('ask').getElementsByTagName('img')[0].src = 'http://osulibrary.oregonstate.edu/images/chatting.jpg';
}

function launch_guin_meebome(new_mode,new_url,new_width,new_height,new_unlock,debug) {
	//update variables
	if (new_mode)	{guin_meebome_current_mode = new_mode;} else     {guin_meebome_current_mode = guin_meebome_mode;}
	if (new_url)	{guin_meebome_current_url = new_url;} else       {guin_meebome_current_url = guin_meebome_url;}
	if (new_width)	{guin_meebome_current_width = new_width;} else   {guin_meebome_current_width = guin_meebome_width;}
	if (new_height)	{guin_meebome_current_height = new_height;} else {guin_meebome_current_height = guin_meebome_height;}
	if (new_unlock)	{guin_meebome_current_unlock = new_unlock;} else {guin_meebome_current_unlock = guin_meebome_unlock;}

	//launch debug alert
	if (debug == 1) {
		alert('DEBUG [meebo javascript library v' + guin_meebo_library_version + '] READOUT\n\n\n'+
		'\n\nmode: '+guin_meebome_current_mode+
		'\n\nurl: '+guin_meebome_current_url+
		'\n\nwidth: '+guin_meebome_current_width+
		'\n\nheight: '+guin_meebome_current_height+
		'\n\nunlock: '+guin_meebome_current_unlock);
	}

	//prepare meebo html
	var guin_meebome_html = '<!doctype html public "-//w3c//dtd xhtml 1.0 strict//en" "http://www.w3.org/tr/xhtml1/dtd/xhtml1-strict.dtd">'+
		'<html>'+
		'<head>'+
		'<title>meebo me!</title>'+
		'<style type="text/css">'+
			'html {padding:0; margin:0; width:100%; height:100%;}'+
			'body {padding:0; margin:0; width:100%; height:100%;}'+
			'div.meebome {padding:0; margin:0; width:100%; height:100%;}'+
			'div.meebome embed {padding:0; margin:0; width:100%; height:100%;}'+
		'</style>'+	
		'</head>'+
		'<body onBlur="window.focus()">'+
			'<div id="meebome" class="meebome">'+
				'<embed src="' + guin_meebome_current_url + '" type="application/x-shockwave-flash"></embed>'+
			'</div>'+
		'</body>'+
		'</html>';

	//begin launching behaviour
	if (guin_meebome_current_mode == '1') {
		// mode is not set to popup - load into current screen
		window.document.open();
		window.document.write(guin_meebome_html);
		window.document.close();
	} else {
		//mode says we should open a popup window - test to see if it is already open
		if (!guin_meebome_window_exists()) {
			//popup not present - launch it
			guin_meebome_window = window.open('about:blank','meebome_window','status=0,menubar=0,resizable=' + guin_meebome_current_unlock + ',width=' + guin_meebome_current_width + ',height=' + guin_meebome_current_height);

			//test to see if popup launched successfully
			if (guin_meebome_window_exists()) {
				//launch was ok - inject html
				guin_meebome_window.document.open();
				guin_meebome_window.document.write(guin_meebome_html);
				guin_meebome_window.document.close();
				chatting_image();
			} else {
				//launch failed - alert the user and then refocus meebo me!
				if (guin_meebome_current_mode != '3') {
					alert('meebo me! warning:'+
						'\n\nYour browser prevented meebo from launching a popup that is required for live chat to function properly.'+
						'\n\nIf you still wish to use this service, please allow popups from the current site and try again.');
				}
			}
		} else {
			//popup is present
			guin_meebome_window.focus();
		}
	}
}