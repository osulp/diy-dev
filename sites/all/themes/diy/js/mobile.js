/* Mobile JS - OSU Libraries */

var expire = 365; //days

if(isMobile()){
    var choice = get_cookie('mobileuser');
    if(choice != null){
        var get = getUrlVars();
        if(get['opt_out'] == 'true'){
            set_cookie('mobileuser', false);
        }else if(choice == 'true'){
            window.location = "http://m.library.oregonstate.edu";
        }
    }else{
        var usem = confirm("Would you like to use the mobile site?");
        set_cookie('mobileuser', usem);
        if(usem)
            window.location = "http://m.library.oregonstate.edu";
    }
}

function mobileOptIn() {
	if(isMobile()){
		set_cookie('mobileuser', true);
	}
	window.location = "http://m.library.oregonstate.edu";
}

function isMobile() {
    var agent = navigator.userAgent.toLowerCase();
    var match = agent.match(/(iphone|ipod|blackberry|android 0.5|htc|lg|midp|mmp|mobile|nokia|opera mini|palm|pocket|psp|sgh|smartphone|symbian|treo mini|playstation portable|sonyericsson|samsung|mobileexplorer|palmsource|benq|windows phone|windows mobile|iemobile|windows ce|nintendo wii)/i);
	var noask = agent.match(/ipad/i);
	return (!noask && match);
}

function set_cookie(name, value) {
  var cookie_string = name + "=" + escape ( value );
  var expires_date = new Date();
  expires_date.setTime( expires_date.getTime() * 1000 * 60 * 60 * 24 * expire);
  cookie_string += "; expires=" + expires_date.toGMTString();
  cookie_string += "; path=/";
  document.cookie = cookie_string;
}

function get_cookie( cookie_name ) {
  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
  if ( results )
    return ( unescape ( results[2] ) );
  else
    return null;
}

function getUrlVars() {
    var vars = [];
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++) {
        var hash = hashes[i].split('=');
        vars[hash[0]] = hash[1];
    }
    return vars;
}
