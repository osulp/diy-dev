var xmlhttp;
function showHours(date)
{
	var url="/sites/all/themes/doug_fir_library/js/checkhours.php";
	url=url+"?q="+date;
	url=url+"&sid="+Math.random();
	
	xmlhttp=GetXmlHttpObject();
	
	if (xmlhttp==null)
	  {
	  window.open(url,'Library Hours','width=200,height=200');
	  return;
	  }
	  
	xmlhttp.onreadystatechange=stateChanged;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function stateChanged()
{
	if (xmlhttp.readyState==4)
	  {
	  document.getElementById("libHours").innerHTML=xmlhttp.responseText;
	  }
}

function GetXmlHttpObject()
{
	if (window.XMLHttpRequest)
	  {
	  // code for IE7+, Firefox, Chrome, Opera, Safari
	  return new XMLHttpRequest();
	  }
	if (window.ActiveXObject)
	  {
	  // code for IE6, IE5
	  return new ActiveXObject("Microsoft.XMLHTTP");
	  }
	return null;
}
