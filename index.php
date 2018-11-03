<?php
include ("dbconnect.php");
$sql="SELECT * FROM options WHERE 1";
$result=mysql_query($sql);
$line1=mysql_fetch_array($result);
$line2=mysql_fetch_array($result);
$line3=mysql_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Moodin.cy</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js" ></script>
<script type="text/javascript" src="jquery.corner.js" ></script>
<script type="text/javascript">
$(document).ready(function()
	{
		$("#round").corner();
		
		
		
		$(".options").click(function()
			{
			$(".options").removeClass("active");
			$(this).addClass("active");
			var oid=$(this).attr("oid");		
					//get the text and display it in div 1
					$("#optext").load("process.php?action=get_option_text&option="+oid);
					$("#question1").load("process.php?action=get_question1&option="+oid);
					$("#menu2").load("process.php?action=get_question1_answers&option="+oid);
					
					$("#question2").html("");
					$("#menu3").html("");
					$("#question3").html("");
					$("#items").html("");
			
			});
		
		$("#close").click(function(){
								   
								   $("#overlay").fadeOut("slow");
								   $("#modal").fadeOut("slow");
								   return false;
								   });
		
	});


</script>
<style type="text/css">
/* the overlayed element */
.simple_overlay {
	
	/* must be initially hidden */
	display:none;
	
	/* place overlay on top of other elements */
	z-index:10000;
	
	/* styling */

	
	width:675px;	
	min-height:200px;
	border:1px solid #666;
	
	/* CSS3 styling for latest browsers */
	-moz-box-shadow:0 0 90px 5px #000;
	-webkit-box-shadow: 0 0 90px #000;	
}

/* close button positioned on upper right corner */
.simple_overlay .close {
	background-image:url(../img/overlay/close.png);
	position:absolute;
	right:-15px;
	top:-15px;
	cursor:pointer;
	height:35px;
	width:35px;
}

</style>
</head>
<body>
<div id="logo">
	<h1><a href="#" id="optext">Select an option:</a></h1>
</div>
<div id="menu">
	<ul>
		<li class="options" rel="#mies1" oid="1"><a href="#" title=""><img src="images/happy.gif"><?=$line1['name']?></a></li>
		<li class="options" oid="2"><a href="#" title=""><img src="images/sad.gif"><?=$line2['name']?></a></li>
		<li class="options" oid="3"><a href="#" title=""><img src="images/need.gif"><?=$line3['name']?></a></li>
	</ul>
</div>
<div id="wrapper">
	<div id="col-one">
		<div class="image"><img src="images/img03.jpg" alt="" width="180" height="150" /></div>
		<div class="container">
			<div class="boxed">
				<h2 class="title" id="question1"></h2>
					
						<div id="menu2" >

						</div>			
					
			</div>
		</div>
	</div>
	<div id="col-two">
		<div class="image"><img src="images/img09.jpg" alt="" width="300" height="150" /></div>
		<div class="container">
			<div class="boxed">
		 		<h2 class="title" id="question3"></h2>
				<div id="items">
                
                </div>
		 	</div>	
		</div>
	</div>
	<div id="col-three">
		<div class="image"><img src="images/img06.jpg" alt="" width="180" height="150" /></div>
		<div class="container">
		 	<div class="boxed">
		 		<h2 class="title" id="question2"></h2>
		 		<div id="menu3">
							
						</div>			
		 	</div>	
		</div>
	</div>
	
	
	<div id="extra" style="clear: both;">
	
	</div>
</div>
<div id="footer">



</div>
<div style="position:fixed; top:0px;  left:0px; height:100%; width:100%; background-color:#000; filter:alpha(opacity=50); opacity: 0.5; -moz-opacity:0.5; display:none;" id="overlay">
</div>
<div style="position:fixed; width:600px; height:300px; background-color:#FFF; left:25%; top:25%; padding:10px; display:none;" id="modal">
<div style="position:relative">
<div ><a href="#" id="close">CLOSE</a></div>
<div id="modal_content">

</div>
</div>
</div>
</body>
</html>
