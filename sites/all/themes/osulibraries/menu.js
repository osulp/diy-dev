function findOwner( evt )
{
    var node;
    if (isNav6)
    {
        node = evt.target;
        while (node)
        {
            if ( node.nodeType == Node.ELEMENT_NODE &&
                 node.nodeName == "DIV")
            {
                return node;
            }
            node = node.parentNode;
        }
    }
    else if (isIE4)
    {
        node = window.event.srcElement;
        while (node)
        {
            if (node.tagName == "DIV")
            {
                return node;
            }
            node = node.parentElement;
        }
    }
    return null;
}
function highlight( evt )
{
    var divObj = findOwner( evt );
    if (isNav6) { divObj.style.cursor = "pointer"; }
   divObj.style.color = "#ff0000";
}
function dim( evt )
{
    var divObj = findOwner( evt );
    if (isNav6) { divObj.style.cursor = "default"; }
   divObj.style.color = "#000000";
}
function getObject( nameStr )
{
    if (isNav6)
    {
        return document.getElementById( nameStr );
    }
    else if (isIE4)
    {
        return document.all[nameStr];
    }
}
function showMenu( evt )
{
    var owner = findOwner( evt );
    var divNum;
    if (isNav6)
    {
        divNum = owner.attributes.getNamedItem("id").nodeValue;
    }
    else if (isIE4)
    {
        divNum = owner.id;
    }
    divNum = parseInt( divNum.substr(1));


if (getIdProperty( "s" + divNum, "display") != "block" )
    {
    expand(divNum);
	}
    else
    {
	collapse(divNum);
  }

}
function expand( divNum )
{ setIdProperty("s" + divNum, "display", "block");
        setIdProperty("m" + divNum, "border", "0");
        document.images["i" + divNum].src = "http://osulibrary.oregonstate.edu/images/open.gif";
   setCookie("library", divNum, "expanded", "", "/", "oregonstate.edu", "");
}
function collapse( divNum )
{
setIdProperty("s" + divNum, "display", "none");
        document.images["i" + divNum].src = "http://osulibrary.oregonstate.edu/images/closed.gif";
        if ((divNum != "0") && (divNum != "5"))
 	{
	setIdProperty("m" + divNum, "borderBottom", "1px solid #a5c064");
	}
     setCookie("library", divNum, "collapsed", "", "/", "oregonstate.edu", "");
}

function setupAction( node )
{
    if (isNav6)
    {
        node.addEventListener( "click", showMenu, false);
    }
    else if (isIE4)
    {
        node.onclick = showMenu;
    }
  setupHighlight( node );
}

function setupHighlight( node )
{
 if (isNav6)
    {
       node.addEventListener( "mouseover", highlight, false );
       node.addEventListener( "mouseout", dim, false );
    }
    else if (isIE4)
    {
        node.onmouseover = highlight;
        node.onmouseout = dim;
    }
}


function setupEvents()
{
    var i;
    var theNode;
    for (i=0; i<vocabList.length; i++)
    {
        theNode = document.getElementById( "s" + i );
        setupAction( theNode );
    }
}

function setup()
{
    var i;
    var j;
    var obj;
    var obj2;
    var val = readCookie ("view");

    j = val == "v3" ? 3 : 6;

    for (i=0; i < j; i++)
    {
        obj = getObject( "m" + i );
	setupAction( obj );
	var tempval = getCookie( i );
	if(tempval == "collapsed"){
		collapse( i );
	} else if (tempval == 'expanded'){
		expand( i );
	}
    }
    for (i=0; i < 3; i++)
    {
	obj2 = getObject( "v" + i );
	setupHighlight( obj2 );
    }
}

/* There are multiple versions of the sidebar, each contained in                                                 its own file.  main.js calls this method on pageload after checking
   the client cookie to see which sidebar to render based on previous
   browsing.  Pulls down the sidebar code and pushes to the sidenav div.                                         This seems hackish, but I can't think of a better way.                                                     */

function renderSidebar() {
        var val = readCookie("view");
        var sideBarPath = "/includes/menus/";

        if(val == "v3") {
                sideBarPath = sideBarPath + "ecampus.inc";
        } else {
                sideBarPath = sideBarPath + "main.inc";
        }

        var request = xhr();
        request.onreadystatechange = function() {
          if(request.readyState == 4 && request.status == 200)    document.getElementById("sidenav").innerHTML = request.responseText;
        }
        var str = request.open("GET", sideBarPath);
        request.send(null);                                                                                   }

/* A nice factory for generating a xmlhttprequest.  Checks
   the browser and returns the appropriate request, null if
   browser is old enough to not support it.
   Thanks webreflection.blogspot.com
*/

function xhr() {
	var xhr = null, b = navigator.userAgent;

	if(window.XMLHttpRequest)
		xhr = new XMLHttpRequest();
	else if(!/MSIE 4/i.test(b)) {
		if(/MSIE 5/i.test(b))
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		else
			xhr = new ActiveXObject("Msxml2.XMLHTTP");
	}
	return xhr;
}


setBrowser();
