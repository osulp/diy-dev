<!-- // Start of AdSubtract JavaScript block; you can ignore this.
    // It is used when AdSubtract blocks cookies or pop-up windows.
document.iMokie = "cookie blocked by AdSubtract";
document.iMferrer = "referrer blocked by AdSubtract";
function iMwin() {
	this.location = "";
	this.frames = new Array(9);
	this.frames[0] = this;
	this.frames[1] = this;
	this.frames[2] = this;
	this.frames[3] = this;
	this.frames[4] = this;
	this.frames[5] = this;
	this.frames[6] = this;
	this.frames[7] = this;
	this.frames[8] = this;
	this.length = 0;
}
// End of AdSubtract JavaScript block. --
window.onload = function(e) {
	if (document.getElementById("sidenav"))
    {
    setup();
    }
	var cookie = readCookie("style");
	var title = cookie ? cookie : getPreferredStyleSheet();
	setActiveStyleSheet(title);
	check_for_chatting();
	}
/*
	Written by Jonathan Snook, http://www.snook.ca/jonathan
	Add-ons by Robert Nyman, http://www.robertnyman.com
*/

function getElementsByClassName(oElm, strTagName, strClassName){
	var arrElements = (strTagName == "*" && oElm.all)? oElm.all : oElm.getElementsByTagName(strTagName);
	var arrReturnElements = new Array();
	strClassName = strClassName.replace(/-/g, "\-");
	var oRegExp = new RegExp("(^|\s)" + strClassName + "(\s|$)");
	var oElement;
	for(var i=0; i<arrElements.length; i++){
		oElement = arrElements[i];
		if(oRegExp.test(oElement.className)){
			arrReturnElements.push(oElement);
		}
	}
	return (arrReturnElements)
}

// Cookie functions
function setCookie(cookieName,variable,value,days,path,domain,secure) {
	var checkCookie = readCookie(cookieName);

// get the value of the cookie
	if (checkCookie != null) {
    	newCookie = new String;
    	found = 0;
		//startOfVars = checkCookie.indexOf("=") + 1;
       	result = unescape(checkCookie);
       	rlist = result.split(",");
       	for (i=0; i < rlist.length-1; i++ ) {
           	label = rlist[i].split("=");
            if ( label[0] == variable ) {
               	label[1] = value;
               	found = 1;
           	}
            newCookie = newCookie + escape(label[0] + "=" + label[1] + ",");
		}
		if ( found == 0 ) {
           		newCookie = newCookie + escape(variable + "=" + value + ",");
        	}
	}
	else {
		newCookie = escape(variable + "=" + value + ",");
    }
createCookie(cookieName,newCookie,days,path,domain,secure);
}
function getCookie(requested) {
    // get the value of the cookie
  //  cookieBodyText = document.cookie;
  	var checkCookie = readCookie("library");
	if (checkCookie != null) {
		result = unescape(checkCookie);
        rlist = result.split(",");
        for (i=0; i<rlist.length; i++ ) {
            label = rlist[i].split("=");
            if ( label[0] == requested ) {
                return label[1];
            }
        }
    }
    return null;
}


/*** search forms ***/
function setkeywords() {
	var textcookie = document.getElementById('textname').value;
	createCookie('searchbox',textcookie);
}

/*** font size ***/
function fontsizeup() {
  active = getActiveStyleSheet();
  switch (active) {
    case 'A--' :
      setActiveStyleSheet('A-');
      break;
    case 'A-' :
      setActiveStyleSheet('A');
      break;
    case 'A' :
      setActiveStyleSheet('A+');
      break;
    case 'A+' :
      setActiveStyleSheet('A++');
      break;
    case 'A++' :
      break;
    default :
      setActiveStyleSheet('A');
      break;
  }
}
function fontsizedown() {
  active = getActiveStyleSheet();
  switch (active) {
    case 'A++' :
      setActiveStyleSheet('A+');
      break;
    case 'A+' :
      setActiveStyleSheet('A');
      break;
    case 'A' :
      setActiveStyleSheet('A-');
      break;
    case 'A-' :
      setActiveStyleSheet('A--');
      break;
    case 'A--' :
       break;
    default :
      setActiveStyleSheet('A--');
      break;
  }
}
function setActiveStyleSheet(title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
}
function getActiveStyleSheet() {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title") && !a.disabled) return a.getAttribute("title");
  }
  return null;
}
function getPreferredStyleSheet() {
  return ('A-');
}
function createCookie(name,value,days,path,domain,secure) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else expires = "";
  document.cookie = name+"="+value+expires+((path) ? "; path=" + path : "") + ((domain) ? "; domain=" + domain : "") + ((secure) ? "; secure" : "");

}
function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}
window.onunload = function(e) {
  var title = getActiveStyleSheet();
  createCookie("style", title, 365, '/');
}
var cookie = readCookie("style");
var title = cookie ? cookie : getPreferredStyleSheet();
if (title == 'null') {
  title = getPreferredStyleSheet();
}
setActiveStyleSheet(title);


// Modified protected email script
// Original script by Joe Maller (http://www.joemaller.com)
// Modified by Mike O'Reilly (http://www.supportnexus.com) and
// Ben Shields (http://ben.falktech.com)
// Function form added by Michael Hall 4/24/03


function safemail(emailN, emailD, emailT) {
emailN=(emailN + '@' + emailD)
if(!emailT)
{ emailT = emailN}
document.write("<a href=\"mailto:" + emailN + "\">" + emailT + '</a>')
}
