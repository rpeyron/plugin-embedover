
var embedover_visible;

function embedover_click(e, click, style)
{
    // Update style
    document.getElementById("embedover_div" ).setAttribute("style", style);
	document.getElementById("embedover_div" ).style.cssText = style;
    // Update contents
    if ((click == document.getElementById("embedover_div" ).src) && 
         (embedover_visible != 'no') )
    {
        document.getElementById("embedover_div" ).style.display= 'none';
        embedover_visible = 'no';
    }
    else
    {
        document.getElementById("embedover_div" ).src=click; // encodeURIComponent
        document.getElementById("embedover_div" ).style.display = 'block' ;
        embedover_visible = 'yes';
    }
    // Update position
    if (!e) var e = window.event;
	if (e.pageX || e.pageY) 	{ posy = e.pageY; }
	else if (e.clientX || e.clientY) 	{ 		posy = e.clientY + document.body.scrollTop 	+ document.documentElement.scrollTop; 	}
    document.getElementById("embedover_div" ).style.top = posy;
    document.getElementById("embedover_div" ).style.left = document.body.clientWidth - document.getElementById("embedover_div").offsetWidth ;
}


// From  : http://www.dynamicdrive.com/dynamicindex17/iframessi2.htm
// Use : <iframe id="myframe" src="externalpage.htm" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" style="overflow:visible; width:100%; display:none"></iframe>

/***********************************************
* IFrame SSI script II- © Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
* Visit DynamicDrive.com for hundreds of original DHTML scripts
* This notice must stay intact for legal use
***********************************************/

//Input the IDs of the IFRAMES you wish to dynamically resize to match its content height:
//Separate each ID with a comma. Examples: ["myframe1", "myframe2"] or ["myframe"] or [] for none:
var iframeids=["embedover_div"];

//Should script hide iframe from browsers that don't support this script (non IE5+/NS6+ browsers. Recommended):
var iframehide="yes";

var getFFVersion=navigator.userAgent.substring(navigator.userAgent.indexOf("Firefox")).split("/")[1];
var FFextraHeight=parseFloat(getFFVersion)>=0.1? 16 : 0; //extra height in px to add to iframe in FireFox 1.0+ browsers

function resizeCaller() {
var dyniframe=new Array();
for (i=0; i<iframeids.length; i++){
if (document.getElementById)
resizeIframe(iframeids[i]);
//reveal iframe for lower end browsers? (see var above):
if ((document.all || document.getElementById) && iframehide=="no"){
var tempobj=document.all? document.all[iframeids[i]] : document.getElementById(iframeids[i]);
//tempobj.style.display="block";
}
}
}

function resizeIframe(frameid){
var currentfr=document.getElementById(frameid);
if (currentfr && !window.opera){
//currentfr.style.display="block";
if (currentfr.contentDocument && currentfr.contentDocument.body.offsetHeight) //ns6 syntax
currentfr.height = currentfr.contentDocument.body.offsetHeight+FFextraHeight; 
else if (currentfr.Document && currentfr.Document.body.scrollHeight) //ie5+ syntax
currentfr.height = currentfr.Document.body.scrollHeight;
if (currentfr.addEventListener)
currentfr.addEventListener("load", readjustIframe, false);
else if (currentfr.attachEvent){
currentfr.detachEvent("onload", readjustIframe); 
currentfr.attachEvent("onload", readjustIframe);
}
}
}

function readjustIframe(loadevt) {
var crossevt=(window.event)? event : loadevt;
var iframeroot=(crossevt.currentTarget)? crossevt.currentTarget : crossevt.srcElement;
if (iframeroot)
resizeIframe(iframeroot.id);
}

function loadintoIframe(iframeid, url){
if (document.getElementById)
document.getElementById(iframeid).src=url;
}

if (window.addEventListener)
window.addEventListener("load", resizeCaller, false);
else if (window.attachEvent)
window.attachEvent("onload", resizeCaller);
else
window.onload=resizeCaller;

