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

	var cascades_meebome_mode = '2';
	var cascades_meebome_url =	'http://widget.meebo.com/mm.swf?YJkUNbyKsM';

// If the meebome_mode is set to 'popup' the following
// default variables are read. meebome_unlock can be
// either '1' (can be resized) or '0' (set dimensions).

	var cascades_meebome_width =	'450';
	var cascades_meebome_height =	'300';
	var cascades_meebome_unlock =	'1';
	
/* ==========================================================
	Usage Syntax
=============================================================

//loading the meebo application

	launch_meebome([new_mode,new_url,new_width,new_height,new_unlock,debug])

		- new_mode :	override meebome_mode
		- new_url :	override meebome_url
		- new_width :	override meebome_width
		- new_height :	override meebome_height
		- new_unlock :	override meebome_unlock
		- debug	 :	displays a debug alert box when set to '1'
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

	var cascades_meebo_library_version = '1.2';
	var cascades_meebome_window;
	var cascades_meebome_current_mode;
	var cascades_meebome_current_url;
	var cascades_meebome_current_width;
	var cascades_meebome_current_height;
	var cascades_meebome_current_unlock;

//Begin the library of functions

function cascades_meebome_window_exists() {
	var cascades_meebome_exists;
	if (cascades_meebome_window && !cascades_meebome_window.closed) {
		//window does exist
		cascades_meebome_exists = true;
	} else {
		//winow does not exist
		cascades_meebome_exists = false;
	}
	return cascades_meebome_exists;
}

function chatting_image() {
	// document.getElementById('ask').getElementsByTagName('img')[0].src = 'http://osulibrary.oregonstate.edu/images/chatting.jpg';
}

function launch_cascades_meebome(new_mode,new_url,new_width,new_height,new_unlock,debug) {
	//update variables
	if (new_mode)	{cascades_meebome_current_mode = new_mode;} else {cascades_meebome_current_mode = cascades_meebome_mode;}
	if (new_url)	{cascades_meebome_current_url = new_url;} else {cascades_meebome_current_url = cascades_meebome_url;}
	if (new_width)	{cascades_meebome_current_width = new_width;} else {cascades_meebome_current_width = cascades_meebome_width;}
	if (new_height)	{cascades_meebome_current_height = new_height;} else {cascades_meebome_current_height = cascades_meebome_height;}
	if (new_unlock)	{cascades_meebome_current_unlock = new_unlock;} else {cascades_meebome_current_unlock = cascades_meebome_unlock;}

	//launch debug alert
	if (debug == 1) {
		alert('DEBUG [meebo javascript library v' + cascades_meebo_library_version + '] READOUT\n\n\n'+
		'\n\nmode: '+cascades_meebome_current_mode+
		'\n\nurl: '+cascades_meebome_current_url+
		'\n\nwidth: '+cascades_meebome_current_width+
		'\n\nheight: '+cascades_meebome_current_height+
		'\n\nunlock: '+cascades_meebome_current_unlock);
	}

	//prepare meebo html
	var cascades_meebome_html = '<!doctype html public "-//w3c//dtd xhtml 1.0 strict//en" "http://www.w3.org/tr/xhtml1/dtd/xhtml1-strict.dtd">'+
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
		'<embed src="' + cascades_meebome_current_url + '" type="application/x-shockwave-flash"></embed>'+
		'</div>'+
		'</body>'+
		'</html>';

	//begin launching behaviour
	if (cascades_meebome_current_mode == '1') {
		// mode is not set to popup - load into current screen
		window.document.open();
		window.document.write(cascades_meebome_html);
		window.document.close();
	} else {
		//mode says we should open a popup window - test to see if it is already open
		if (!cascades_meebome_window_exists()) {
			//popup not present - launch it
			cascades_meebome_window = window.open('about:blank','meebome_window','status=0,menubar=0,resizable=' + cascades_meebome_current_unlock + ',width=' + cascades_meebome_current_width + ',height=' + cascades_meebome_current_height);

			//test to see if popup launched successfully
			if (cascades_meebome_window_exists()) {
				//launch was ok - inject html
				cascades_meebome_window.document.open();
				cascades_meebome_window.document.write(cascades_meebome_html);
				cascades_meebome_window.document.close();
				chatting_image();
			} else {
				//launch failed - alert the user and then refocus meebo me!
				if (cascades_meebome_current_mode != '3') {
					alert('meebo me! warning:'+
						'\n\nYour browser prevented meebo from launching a popup that is required for live chat to function properly.'+
						'\n\nIf you still wish to use this service, please allow popups from the current site and try again.');
				}
			}
		} else {
			//popup is present
			cascades_meebome_window.focus();
		}
	}
}