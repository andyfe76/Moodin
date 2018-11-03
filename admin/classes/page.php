<?php
require './../language/back_end.php';
require_once './classes/mysql.php';
class page
  {
    var $page;
    var $title;
	var $mysql;
 
    function page($menu="")
      {
        $this->mysql=new MySQL();
		
		session_start();
	    if(!empty($_SESSION['aa']))
	      {
            $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
     	    if(strpos($_SESSION['aa'], $url)=== false && strpos($url,"image_delete")=== false)
	          {
	            $_SESSION['ac']=$_SESSION['ab'];  
	            $_SESSION['ab']=$_SESSION['aa'];  
                $_SESSION['aa']=$url;
	          } 
	      }	
	    $this->title="Admin";
        $this->page='';
        $this->addHeader($menu);
        $this->redirect();
      }
   
   
    function addHeader($menu="")
      {
        global $product_catalog;
	    global $images;
	    global $edit_designers;
	    global $edit_links;
	    global $view_orders;
	    global $logout;
		
		$sql="select * from categories order by category";
		$result=$this->mysql->query($sql);
		while($row=$result->fetch())
		  {
		    $categories.=<<<EOD
<tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="categories_edit.php?id=$row[id]">$row[category]</a></font><font size="1"></font></font></td>
                                </tr>
EOD;
		  }
		  
		
		$sql="select * from designers order by designer asc";
		$result=$this->mysql->query($sql);
		while($row=$result->fetch())
		  {
		    $designers.=<<<EOD
<tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="designers_edit.php?id=$row[id]">$row[designer]</a></font><font size="1"></font></font></td>
                                </tr>
EOD;
		  }  
		  
		$sql="select * from trends order by trend";
		$result=$this->mysql->query($sql);
		while($row=$result->fetch())
		  {
		    $trends.=<<<EOD
<tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="trends_edit.php?id=$row[id]">$row[trend]</a></font><font size="1"></font></font></td>
                                </tr>
EOD;
		  }   
		  
		  
		$sql="select * from pages order by pages.index";
		$result=$this->mysql->query($sql);
		while($row=$result->fetch())
		  {
		    $pages.=<<<EOD
<tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="1"><a href="pages_edit.php?id=$row[id]"><font color="#ff0066">$row[page]</font></a></font></td>
                                </tr>
EOD;
		  }  
		  
			
		$this->page.=<<<EOD
<html><head><title>Bag Anonymous - Administrative Back-End</title>
<link href="css/style.css" type="text/css" rel="stylesheet">
<SCRIPT LANGUAGE='javascript'>
function redirect(url)
  {
     location.href=url;
  }
</SCRIPT>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<style type="text/css">

#dhtmltooltip{
font:normal 11px Verdana;
position: absolute;
left: -300px;
width: 150px;
border: 1px solid black;
padding: 4px;
background-color: lightyellow;
visibility: hidden;
z-index: 100;
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}

</style>
<script type="text/javascript">
function hideDivs(nr)
  {
    var i;
	for(i=1;i<nr;i++)
	  document.getElementById(i).style.visibility= 'hidden'; 
	document.getElementById("hideShow").innerHTML="<input type=\"button\" value=\"Show\" onclick=\"showDivs("+nr+")\">";
  }
  
function showDivs(nr)
  {
    var i;
	for(i=1;i<nr;i++)
	  document.getElementById(i).style.visibility= 'visible'; 
	document.getElementById("hideShow").innerHTML="<input type=\"button\" value=\"Hide\" onclick=\"hideDivs("+nr+")\">";
  }
/***********************************************
* Cool DHTML tooltip script II- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetfromcursorX=12 //Customize x offset of tooltip
var offsetfromcursorY=10 //Customize y offset of tooltip

var offsetdivfrompointerX=10 //Customize x offset of tooltip DIV relative to pointer image
var offsetdivfrompointerY=14 //Customize y offset of tooltip DIV relative to pointer image. Tip: Set it to (height_of_pointer_image-1).

document.write('<div id="dhtmltooltip"></div>') //write out tooltip DIV
document.write('<img id="dhtmlpointer" src="img/arrow2.gif">') //write out pointer image

var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

var pointerobj=document.all? document.all["dhtmlpointer"] : document.getElementById? document.getElementById("dhtmlpointer") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thewidth, thecolor){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var nondefaultpos=false
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20
var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20

var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX
var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY

var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth){
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=curX-tipobj.offsetWidth+"px"
nondefaultpos=true
}
else if (curX<leftedge)
tipobj.style.left="5px"
else{
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetfromcursorX-offsetdivfrompointerX+"px"
pointerobj.style.left=curX+offsetfromcursorX+"px"
}

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight){
tipobj.style.top=curY-tipobj.offsetHeight-offsetfromcursorY+"px"
nondefaultpos=true
}
else{
tipobj.style.top=curY+offsetfromcursorY+offsetdivfrompointerY+"px"
pointerobj.style.top=curY+offsetfromcursorY+"px"
}
tipobj.style.visibility="visible"
if (!nondefaultpos)
pointerobj.style.visibility="visible"
else
pointerobj.style.visibility="hidden"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
pointerobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onmousemove=positiontip

</script>
<style type="text/css">

#hintbox{ /*CSS for pop up hint box */
position:absolute;
top: 0;
background-color: lightyellow;
width: 150px; /*Default width of hint.*/ 
padding: 3px;
border:1px solid black;
font:normal 11px Verdana;
line-height:18px;
z-index:10000;
border-right: 3px solid black;
border-bottom: 3px solid black;
visibility: hidden;
}

.hintanchor{ /*CSS for link that shows hint onmouseover*/
font-weight: bold;
color: navy;
margin: 3px 8px;
}


</style>

<script type="text/javascript">

var horizontal_offset="9px" //horizontal offset of hint box from anchor link

/////No further editting needed

var vertical_offset="0" //horizontal offset of hint box from anchor link. No need to change.
var ie=document.all
var ns6=document.getElementById&&!document.all

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1
if (whichedge=="rightedge"){
var windowedge=ie && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-30 : window.pageXOffset+window.innerWidth-40
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure+obj.offsetWidth+parseInt(horizontal_offset)
}
else{
var windowedge=ie && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetHeight
}
return edgeoffset
}

function showhint(menucontents, obj, e, tipwidth){
if ((ie||ns6) && document.getElementById("hintbox")){
dropmenuobj=document.getElementById("hintbox")
dropmenuobj.innerHTML=menucontents
dropmenuobj.style.left=dropmenuobj.style.top=-500
if (tipwidth!=""){
dropmenuobj.widthobj=dropmenuobj.style
dropmenuobj.widthobj.width=tipwidth
}
dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+obj.offsetWidth+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+"px"
dropmenuobj.style.visibility="visible"
obj.onmouseout=hidetip
}
}

function hidetip(e){
dropmenuobj.style.visibility="hidden"
dropmenuobj.style.left="-500px"
}

function createhintbox(){
var divblock=document.createElement("div")
divblock.setAttribute("id", "hintbox")
document.body.appendChild(divblock)
}

if (window.addEventListener)
window.addEventListener("load", createhintbox, false)
else if (window.attachEvent)
window.attachEvent("onload", createhintbox)
else if (document.getElementById)
window.onload=createhintbox

</script>

<script name="javascript">
function treeMenu(id,setHeight)
  {
	var divid, contentid;
	divid="menu"+id;
	contentid="content"+id;
	
	if( document.getElementById(divid).style.visibility=="hidden")
	  {
		
		document.getElementById(divid).innerHTML=document.getElementById(contentid).innerHTML;
	    document.getElementById(divid).style.visibility= 'visible';
	  }
	
	else
	  {
		info_concert_id=0;
		document.getElementById(divid).innerHTML="";

	    document.getElementById(divid).style.visibility= 'hidden';
			    
	  }
  }
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head><body leftmargin="0" topmargin="0" alink="#333333" bgcolor="#ffffff" link="#333333" vlink="#333333">
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
  <tbody><tr>
    <td bgcolor="#cccccc" valign="top" width="225"> 
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
          <td width="15">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td width="15">&nbsp;</td>
          <td>
            <table border="0" cellpadding="0" cellspacing="0" width="210">
              <tbody><tr> 
                <td><b><font color="#000000" face="Century Gothic, Arial" size="1"><a href="logout.php">LOG 
                  OUT</a></font><a href="#"><font color="#000000" face="Century Gothic, Arial" size="2"> 
                  </font></a></b></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td> 
                  <table border="0" cellpadding="0" cellspacing="0" width="210">
                    <tbody>
                    <tr>
                      <td height="35"><b><font face="Century Gothic, Arial" size="1"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="products.php_files/add_button.jpg" height="10" width="10"><b>&nbsp;</b></font><a style="text-decoration: none;" href="meta_tags.php"><font color="#ff0066">Meta Tags </font></a></font></b></td>
                    </tr>
                    <tr> 
                      <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;<font size="1">CATEGORY 
                        MANAGEMENT</font></b><font size="1"> </font></font></td>
                    </tr>
                    <tr> 
                      <td> 
                        <table border="0" cellpadding="0" cellspacing="0" width="210">
                          <tbody><tr> 
                            <td width="18">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;</b></font><a  style="text-decoration:none"  href=javascript:treeMenu('11','60')><font color="#ff0066">Bag 
                              Types</font></a></font></b></td>
                          </tr>
                          <tr> 
                            <td width="18">&nbsp;</td>
                            <td><div id="menu11">
                              <table border="0" cellpadding="0" cellspacing="0" width="192">
                                <tbody><tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="categories_add.php">Add 
                                    Type </a></font><font size="1"></font></font></td>
                                </tr>
                                $categories
                                
                              </tbody></table>
							  </div>
							  
							  <div id="content11" style="visibility:hidden;height:0px">
                              <table border="0" cellpadding="0" cellspacing="0" width="192">
                                <tbody><tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="categories_add.php">Add 
                                    Type </a></font><font size="1"></font></font></td>
                                </tr>
                                $categories
                                
                              </tbody></table>
							  </div>                            </td>
                          </tr>
                          <tr> 
                            <td width="10">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;</b></font><a  style="text-decoration:none"  href=javascript:treeMenu('12','60')><font color="#ff0066">Designers</font></a></font></b></td>
                          </tr>
                          <tr> 
                            <td width="10">&nbsp;</td>
                            <td>
							  <div id="menu12">
                              <table border="0" cellpadding="0" cellspacing="0" width="192">
                                <tbody><tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="designers_add.php">Add 
                                    Designer </a></font><font size="1"></font></font></td>
                                </tr>
                                $designers
                              </tbody></table>
							  </div>
							  
							  <div id="content12" style="visibility:hidden;height:0px">
                              <table border="0" cellpadding="0" cellspacing="0" width="192">
                                <tbody><tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="designers_add.php">Add 
                                    Designer </a></font><font size="1"></font></font></td>
                                </tr>
                                $designers
                              </tbody></table>
							  </div>                            </td>
                          </tr>
                          <tr> 
                            <td width="10">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;</b></font><a  style="text-decoration:none"  href=javascript:treeMenu('13','60')><font color="#ff0066">Trends</font></a></font></b></td>
                          </tr>
                          <tr>
                            <td width="10">&nbsp;</td>
                            <td>
							  <div id="menu13">
                              <table border="0" cellpadding="0" cellspacing="0" width="192">
                                <tbody><tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="trends_add.php">Add 
                                    Trend </a></font><font size="1"></font></font></td>
                                </tr>
                               $trends
                              </tbody></table>
							  </div>
							  
							  <div id="content13" style="visibility:hidden;height:0px">
                              <table border="0" cellpadding="0" cellspacing="0" width="192">
                                <tbody><tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="trends_add.php">Add 
                                    Trend </a></font><font size="1"></font></font></td>
                                </tr>
                               $trends
                              </tbody></table>
							  </div>                            </td>
                          </tr>
                        </tbody></table>                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
              <tr> 
                <td> 
                  <table border="0" cellpadding="0" cellspacing="0" width="210">
                    <tbody><tr> 
                      <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><a href="products.php" style="text-decoration:none"><b>&nbsp;<font size="1">PRODUCT 
                        MANAGEMENT </font></b></font></a></td>
                    </tr>
                    <tr> 
                      <td> 
                        <table border="0" cellpadding="0" cellspacing="0" width="210">
                          <tbody><tr> 
                            <td width="18">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="2"><font size="1"><a href="products_add.php"><font color="#ff0066">Add 
                              Product </font></a></font><font color="#ff0066" size="1"></font></font></b></td>
                          </tr>
                        </tbody></table>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
              <tr> 
                <td> 
                  <table border="0" cellpadding="0" cellspacing="0" width="210">
                    <tbody><tr> 
                      <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;<font size="1">CUSTOMER 
                        MANAGEMENT </font></b></font></td>
                    </tr>
                    <tr> 
                      <td> 
                        <table border="0" cellpadding="0" cellspacing="0" width="210">
                          <tbody><tr> 
                            <td width="18">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><a href="expert_view.php"><font color="#ff0066">View 
                              Customers </font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                          </tr>
                          <tr> 
                            <td width="10">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><a href="expert_add.php"><font color="#ff0066">Add 
                              Customer </font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                          </tr>
                        </tbody></table>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
              <tr> 
                <td> 
                  <table border="0" cellpadding="0" cellspacing="0" width="210">
                    <tbody><tr>
                      <td height="35">
                        <table border="0" cellpadding="0" cellspacing="0" width="210">
                          <tbody><tr> 
                            <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;<font size="1">ORDER 
                              MANAGEMENT</font></b></font></td>
                          </tr>
                          <tr> 
                            <td> 
                              <table border="0" cellpadding="0" cellspacing="0" width="210">
                                <tbody><tr> 
                                  <td width="18">&nbsp;</td>
                                  <td><b><font face="Century Gothic, Arial" size="1"><a href="revenue.php?action=ytd"><font color="#ff0066">Total 
                                    Revenue Year to Date</font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                                </tr>
                                <tr> 
                                  <td width="10">&nbsp;</td>
                                  <td><b><font face="Century Gothic, Arial" size="1"><a href="revenue.php?action=mtd"><font color="#ff0066">Total 
                                    Revenue Month to Date</font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                                </tr>
                                <tr> 
                                  <td width="10">&nbsp;</td>
                                  <td><b><font face="Century Gothic, Arial" size="1"><a href='orders_unful.php' ><font color="#ff0066">Pending 
                                    Orders </font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                                </tr>
                                <tr> 
                                  <td width="10">&nbsp;</td>
                                  <td><b><font face="Century Gothic, Arial" size="1"><a href="orders_ful.php"><font color="#ff0066">Fulfilled 
                                    Orders </font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                                </tr>
                                <tr> 
                                  <td width="10">&nbsp;</td>
                                  <td><b><font face="Century Gothic, Arial" size="1"><a href="products_out.php"><font color="#ff0066">Current 
                                    Bags Outstanding</font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                                </tr>
                              </tbody></table>
                            </td>
                          </tr>
                        </tbody></table>
                      </td>
                    </tr>
                    <tr> 
                      <td height="35"> 
                        <table border="0" cellpadding="0" cellspacing="0" width="210">
                          <tbody><tr> 
						  <tr>
                              <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="products.php_files/add_button.jpg" height="10" width="10"><b>&nbsp;<font size="1"><a style="text-decoration:none;" href="inventory_total.php">INVENTORY MANAGEMENT </a></font></b></font></td>
                            </tr>
                            <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;<font size="1">SUBSCRIPTION 
                              MANAGEMENT </font></b></font></td>
                          </tr>
                          <tr> 
                            <td> 
                              <table border="0" cellpadding="0" cellspacing="0" width="210">
                                <tbody><tr> 
                                  <td width="18">&nbsp;</td>
                                  <td><b><font face="Century Gothic, Arial" size="1"><a href="ratem.php"><font color="#ff0066">Update 
                                    Monthly Subscription Rate</font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                                </tr>
                                <tr> 
                                  <td width="10">&nbsp;</td>
                                  <td><b><font face="Century Gothic, Arial" size="1"><a href="ratey.php"><font color="#ff0066">Update 
                                    Yearly Subscription Rate</font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                                </tr>
                              </tbody></table>
                            </td>
                          </tr>
                        </tbody></table>
                      </td>
                    </tr>
                    <tr> 
                      <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;<font size="1">COUPON 
                        CODES </font></b></font></td>
                    </tr>
                    <tr> 
                      <td> 
                                               <table border="0" cellpadding="0" cellspacing="0" width="210">
                          <tbody><tr> 
                            <td width="18">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><font color="#000000" face="Century Gothic, Arial" size="2"></font><a href="coupon_view_all.php"><font color="#ff0066">Current 
                              Coupons </font></a></font></b></td>
                          </tr>
                          <tr> 
                            <td width="18">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="products.php_files/add_button.jpg" height="10" width="10"><b>&nbsp;</b></font><a href="coupon_view.php?type=subscr"><font color="#ff0066">Subscription 
                              Coupons </font></a></font></b></td>
                          </tr>
                          <tr> 
                            <td width="18">&nbsp;</td>
                            <td> 
                              <table border="0" cellpadding="0" cellspacing="0" width="192">
                                <tbody><tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="coupon_add.php?mode=do&type=subscr">Add 
                                    $ off Coupon</a></font><font size="1"></font></font></td>
                                </tr>
                                <tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="coupon_add.php?mode=po&type=subscr">Add 
                                    % off Coupon</a></font><font size="1"></font></font></td>
                                </tr>
                              </tbody></table>
                            </td>
                          </tr>
                          <tr> 
                            <td width="10">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="products.php_files/add_button.jpg" height="10" width="10"><b>&nbsp;</b></font><a href="coupon_view.php?type=rental"><font color="#ff0066">Rental 
                              Coupons </font></a></font></b></td>
                          </tr>
                          <tr> 
                            <td width="10">&nbsp;</td>
                            <td> 
                              <table border="0" cellpadding="0" cellspacing="0" width="192">
                                <tbody><tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="coupon_add.php?mode=do&type=rental">Add 
                                    $ off Rental Coupon</a></font><font size="1"></font></font></td>
                                </tr>
                                <tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="coupon_add.php?mode=po&type=rental">Add 
                                    % off Rental Coupon</a></font><font size="1"></font></font></td>
                                </tr>
                              </tbody></table>
                            </td>
                          </tr>
                          <tr> 
                            <td width="10">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="products.php_files/add_button.jpg" height="10" width="10"><b>&nbsp;</b></font><a href="coupon_view.php?type=sale"><font color="#ff0066">For 
                              Sale Coupons</font></a></font></b></td>
                          </tr>
                          <tr> 
                            <td width="10">&nbsp;</td>
                            <td> 
                              <table border="0" cellpadding="0" cellspacing="0" width="192">
                                <tbody><tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="coupon_add.php?mode=do&type=sale">Add 
                                    $ off Purchase Coupon</a></font><font size="1"></font></font></td>
                                </tr>
                                <tr> 
                                  <td width="25">&nbsp;</td>
                                  <td><font color="#000000" face="Century Gothic, Arial" size="2"><font size="1"><a href="coupon_add.php?mode=po&type=sale">Add 
                                    % off Purchase Coupon</a></font><font size="1"></font></font></td>
                                </tr>
                              </tbody></table>
                            </td>
                          </tr>
                        </tbody></table>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
              <tr> 
                <td> 
                  <table border="0" cellpadding="0" cellspacing="0" width="210">
                    <tbody><tr> 
                      <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;<font size="1">TAX 
                        PARAMATERS </font></b></font></td>
                    </tr>
                    <tr> 
                      <td> 
                        <table border="0" cellpadding="0" cellspacing="0" width="210">
                          <tbody><tr> 
                            <td width="18">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><a href="state_taxes.php"><font color="#ff0066">Current 
                              Tax Settings</font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                          </tr>
                         
                        </tbody></table>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
              <tr> 
                <td> 
                  <table border="0" cellpadding="0" cellspacing="0" width="210">
                    <tbody><tr> 
                      <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;<font size="1">SHIPPING 
                        PARAMATERS </font></b></font></td>
                    </tr>
                    <tr> 
                      <td> 
                        <table border="0" cellpadding="0" cellspacing="0" width="210">
                          <tbody><tr> 
                            <td width="18">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><a href="shipping_edit.php"><font color="#ff0066">Change Shipping Prices</font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                          </tr>
                         
                        </tbody></table>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
              <tr> 
                <td> 
                  <table border="0" cellpadding="0" cellspacing="0" width="210">
                    <tbody><tr> 
                      
                    </tr>
                  </tbody></table>
                </td>
              </tr>
              <tr> 
                <td> 
                  <table border="0" cellpadding="0" cellspacing="0" width="210">
                    <tbody><tr> 
                      <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10"><b>&nbsp;<font size="1">MAILING 
                        LIST </font></b></font></td>
                    </tr>
                    <tr> 
                      <td> 
                        <table border="0" cellpadding="0" cellspacing="0" width="210">
                          <tbody><tr> 
                            <td width="18">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><a href="emails.php"><font color="#ff0066">Current 
                              Subscribers </font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                          </tr>
                          <tr> 
                            <td width="10">&nbsp;</td>
                            <td><b><font face="Century Gothic, Arial" size="1"><a href="newsletter_send.php"><font color="#ff0066">Send 
                              a New E-Mail Message</font></a></font><font color="#ff0066"><a href="#"><font face="Century Gothic, Arial" size="2"></font></a></font></b></td>
                          </tr>
                          
                        </tbody></table>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
			  <tr> 
                <td> 
                  <table border="0" cellpadding="0" cellspacing="0" width="210">
                    <tbody><tr> 
                      <td height="35"><a href="pages.php" style="text-decoration:none"><font color="#000000" face="Century Gothic, Arial" size="2"><img src="images/add_button.jpg" height="10" width="10" border="0"><b>&nbsp;<font size="1">STATIC CONTENT </font></b></font></a></td>
                    </tr>
                    <tr> 
                      <td> 
                        <table border="0" cellpadding="0" cellspacing="0" width="210">
                          <tbody>
                          $pages
                        </tbody></table>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
              <tr> 
                <td>&nbsp; </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
      </tbody></table>
    </td>

EOD;
      }




    function addContent($content="",$title="")
      {
        $title=strtoupper($title);
		
		$this->page.=<<<EOD
<td valign="top">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr> 
          <td width="15">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td width="15">&nbsp;</td>
          <td><img src="images/logo_big.jpg" height="137" width="520"></td>
        </tr>
        <tr>
          <td width="15">&nbsp;</td>
          <td>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody><tr>
                <td width="35">&nbsp;</td>
                <td>
                  <table border="0" cellpadding="0" cellspacing="0" width="700">
                    <tbody><tr> 
                      <td valign="top" width="660"> 
                        <table border="0" cellpadding="0" cellspacing="0" width="660">
                          <tbody><tr bgcolor="#eeeeee"> 
                            <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2"><b>&nbsp;&nbsp;$title </b></font></td>
                          </tr>
                          <tr> 
                            <td height="35"><font color="#000000" face="Century Gothic, Arial" size="2">
							  $content
							</td>
                          </tr>
                          
                        </tbody></table>
                      </td>
                      
                    </tr>
                  </tbody></table>
                </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
        <tr> 
          <td width="15">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </tbody></table>
    </td>
  </tr>
</tbody></table>
</body></html>
EOD;
      }


    function addFooter()
      {
        $this->page.=<<<EOD
 </center>
</div>
EOD;
      }

    function get()
      {
        $temp=$this->page;
        $this->addFooter();
        $page=$this->page;
        $this->page=$temp;
        return $page; 
      }
   
    function redirect()
      {
        if(empty($_SESSION['admin'])||empty($_SESSION['id_a']))
	      { 
		    header("location: index.php"); 
            exit;  
	      }	  
      } 

    function submenu()
      {
        $content=<<<EOD
<tr valign="top">
  <td align="center" valign="top">
    <table class="text" width="100%" border="0">
	  <tr>        
		<td align="left">
	      <b>$_SESSION[site_name]:</b>&nbsp;&nbsp;&nbsp;
        </td>		
		<td valign="top">
		  <table class="text">
		    <tr>		
		      <td class="submenu" align="center">  
                <a href="orders.php">Orders</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="designers.php">Edit designers</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="offers.php">Special Offer</a>       
              </td>		
	 	    </tr>
		  </table>
		</td>   
	  </tr>   
	</table>	
  </td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
EOD;

       return $content;
      }  
 function categoriesletter()
   {
     $content=<<<EOD
<SCRIPT LANGUAGE='javascript'>
  function categoriesletter_send(id,email)
    {
      if(confirm("Do you really want to send the categoriesletter?"))
      location.href='categoriesletter_send.php';
    }
</SCRIPT>
<tr valign="top">
  <td align="center" valign="top">
    <table class="text" width="100%" border="0">
	  <tr>        
		<td align="left">
	      <b>categoriesLETTER:</b>&nbsp;&nbsp;&nbsp;
        </td>		
		<td valign="top">
		  <table class="text">
		    <tr>		
		      <td class="submenu" align="center">  
                <a href="emails.php">Emails</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="categoriesletters.php">categoriesletters</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="categoriesletter_edit.php">Edit categoriesletter</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
				<a href="#" onClick="categoriesletter_send(); return false;">Send categoriesletter</a>       
              </td>		
	 	    </tr>
		  </table>
		</td>   
	  </tr>   
	</table>	
  </td>
</tr>
<tr>
  <td>&nbsp;
    
  </td>
</tr>  
EOD;
     return $content;
   }  
    
  }
?>