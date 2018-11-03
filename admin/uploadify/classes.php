<?php
session_start();
//error_reporting(0);

include_once ("../../dbconnect.php");


function thumb1($image)
	{
	$arr=explode(".",$image);

	$image=$arr[0]."_thumb1.".$arr[1];
	
	return $image;
	}
function thumb2($image)
	{
	$arr=explode(".",$image);

	$image=$arr[0]."_thumb2.".$arr[1];
	
	return $image;
	}
function thumb3($image)
	{
	$arr=explode(".",$image);

	$image=$arr[0]."_thumb3.".$arr[1];
	
	return $image;
	}
function thumb4($image)
	{
	$arr=explode(".",$image);

	$image=$arr[0]."_thumb4.".$arr[1];
	
	return $image;
	}

 class manager
	{
	var $table;
	function set_table($tab)
		{
		$this->table=$tab;
		}
	function get_element_by_id($id)
		{
		$tbl=$this->table;
		$sql="SELECT * FROM {$this->table} WHERE id='$id'";
		
		$result=mysql_query($sql);
		$line=mysql_fetch_array($result);
                return $line;
		}
	function db_insert($form)
		{
		$tbl=$this->table;
		$part1="";
		$part2="";
			foreach($form as $key=>$value)
				{
			
				$part1.="`$key`,";
				$part2.="'$value',";
				
				}
		$part1 = substr_replace($part1,"",-1);
		$part2 = substr_replace($part2,"",-1);
    	$sql="INSERT into $tbl ($part1) VALUES ($part2)";
		//echo $sql;
		$str=mysql_query($sql) or die(mysql_error());
		$id=mysql_insert_id();
		return $id;
		}
	function db_modify($form,$id)
		{
		$tbl=$this->table;
		$part1="";
			foreach($form as $key=>$value)
			{
			
			$part1.="`$key`='$value',";
			}
		$part1 = substr_replace($part1,"",-1);
    	$sql="UPDATE $tbl SET $part1 where id='$id'";
		//echo $sql;
		$result=mysql_query($sql) or die(mysql_error());
		return $result;
		}
	function db_delete($id)
		{
		$tbl=$this->table;
		$sql="DELETE  FROM $tbl WHERE ";
		$sql.="$id";
		$res=mysql_query($sql);
		return $res;
		}
	function query($sql)
		{
		$result=mysql_query($sql) or die(mysql_error());
		return $result;
		}
	function fetch($result)
		{
		$line=mysql_fetch_array($result);
		return $line;
		}
}

class user extends manager
	{

	
	
	

	
	function register($form)
		{
		$this->db_insert($form);
		}
	function login($user,$pass)
		{
		$result=$this->query("SELECT * FROM {$this->table} where user='$user' AND pass='$pass' AND confirm='1'");
		
		$num=mysql_num_rows($result);
		if($num) {
					$user=$this->fetch($result);
					$school_id=$user['school_id'];
					$id=$user['id'];
					$_SESSION['school_id']=$school_id;
					$_SESSION['id']=$id;
					return $id;
				}
		else return 0;
		}
	function logout()
		{
		session_destroy();
		}
	}  
function add_header($type="")
	{ 
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>Simpla Admin</title>
		
		<!--                       CSS                       -->
	  
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />	
		
		<!-- Colour Schemes
	  
		Default colour scheme is green. Uncomment prefered stylesheet to use it.
		
		<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />
		
		<link rel="stylesheet" href="resources/css/red.css" type="text/css" media="screen" />  
	 
		-->
		
		<!-- Internet Explorer Fixes Stylesheet -->
		
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" />
		<![endif]-->
		
		<!--                       Javascripts                       -->
  
		<!-- jQuery -->
		<script type="text/javascript" src="resources/scripts/jquery-1.3.2.min.js"></script>
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="resources/scripts/simpla.jquery.configuration.js"></script>
		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="resources/scripts/facebox.js"></script>
		
		<!-- jQuery WYSIWYG Plugin -->
		<script type="text/javascript" src="resources/scripts/jquery.wysiwyg.js"></script>
		
		<!-- jQuery Datepicker Plugin -->
		<script type="text/javascript" src="resources/scripts/jquery.datePicker.js"></script>
		<script type="text/javascript" src="resources/scripts/jquery.date.js"></script>
		<!--[if IE]><script type="text/javascript" src="resources/scripts/jquery.bgiframe.js"></script><![endif]-->

		
		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
		
	</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
			<h1 id="sidebar-title"><a href="#">Simpla Admin</a></h1>
		  
			<!-- Logo (221px wide) -->
			<a href="#"><img id="logo" src="resources/images/logo.png" alt="Simpla Admin logo" /></a>
		  
			<!-- Sidebar Profile links -->
			<div id="profile-links">
      Hello, Andrei<br />
				<br />
				<a href="#" title="View the Site">View the Site</a> | <a href="#" title="Sign Out">Sign Out</a>
			</div>        
			
			<ul id="main-nav">  <!-- Accordion Menu -->
				
				<li>
					<a href="../../../www.google.com" class="nav-top-item no-submenu"> <!-- Add the class "no-submenu" to menu items with no sub menu -->
						Dashboard
					</a>       
				</li>
				
				<li> 
					<a href="#" class="nav-top-item current"> <!-- Add the class "current" to current menu item -->
					Optiuni
					</a>
					<ul>
					<?php
					$sql="SELECT * FROM options WHERE 1";
					$result=mysql_query($sql);
					while($line=mysql_fetch_array($result))
						{
						?>
                        <li><a href="option.php?id=<?=$line['id']?>"><?=$line['name']?></a></li>
						<?php
						}
						?>
					</ul>
			  </li>
				
				
                <li>
					<a href="#" class="nav-top-item">
						Itemuri
					</a>
					<ul>
						<li><a href="items.php">Management Itemuri</a></li>
						<li></li>
					</ul>
				</li>
                
                <li>
					<a href="#" class="nav-top-item">
						Campuri Custom
					</a>
					<ul>
						<li></li>
						<li><a href="templates.php">Management templateuri</a></li>
					</ul>
				</li>
				
				<li>
					<a href="#" class="nav-top-item">
						Static Content
					</a>
					<ul>
						<li><a href="#">Terms and contirions</a></li>
						<li><a href="#">Citysearch is...</a></li>
						<li><a href="#">Email Templates</a></li>
					</ul>
			  </li>
				
				<li></li>
				<li> </li>      
				
			</ul> <!-- End #main-nav -->
			
			<div id="messages" style="display: none"> <!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->
				
				<h3>3 Messages</h3>
			 
				<p>
					<strong>17th May 2009</strong> by Admin<br />
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>
			 
				<p>
					<strong>2nd May 2009</strong> by Jane Doe<br />
					Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>
			 
				<p>
					<strong>25th April 2009</strong> by Admin<br />
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>
				
				<form action="" method="post">
					
					<h4>New Message</h4>
					
					<fieldset>
						<textarea class="textarea" name="textfield" cols="79" rows="5"></textarea>
					</fieldset>
					
					<fieldset>
					
						<select name="dropdown" class="small-input">
							<option value="option1">Send to...</option>
							<option value="option2">Everyone</option>
							<option value="option3">Admin</option>
							<option value="option4">Jane Doe</option>
						</select>
						
						<input class="button" type="submit" value="Send" />
						
					</fieldset>
					
				</form>
				
			</div> <!-- End #messages -->
			
		</div></div> <!-- End #sidebar -->
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="../../../browsehappy.com/index.htm" title="Upgrade to a better browser">upgrade</a> your browser or <a href="../../../www.google.com/support/bin/answer_2EEFB1D5.py" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<!-- Page Head -->
			<h2>Welcome Andrei</h2>
			<p id="page-intro">What would you like to do?</p>
			
			<ul class="shortcut-buttons-set">
			  <li><a class="shortcut-button" href="#"><span>
				  <img src="resources/images/icons/paper_content_pencil_48.png" alt="icon" /><br />
				  Add a contest</span></a></li>
				
				<li><a class="shortcut-button" href="#"><span>
					<img src="resources/images/icons/image_add_48.png" alt="icon" /><br />
					Manage submissions
				</span></a></li>
				<li><a class="shortcut-button" href="#messages" rel="modal"><span>
					<img src="resources/images/icons/comment_48.png" alt="icon" /><br />
					Send a message</span></a></li>
				
			</ul><!-- End .shortcut-buttons-set -->
			
		  <div class="clear"></div> <!-- End .clear -->
			
	
 <?php
	
	}
	
function add_footer()
	{
	global $dir;
	?>
      <!-- End .content-box --><!-- End .content-box --><!-- End .content-box -->
      <div class="clear"></div>
			
			
			<!-- Start Notifications -->
			<!-- End Notifications -->
			
	  <div id="footer">
				<small> <!-- Remove this notice or replace it with whatever you want -->
						&#169; Copyright 2009 Your Company | Powered by Ovidiu Maghetiu<a href="../../../themeforest.net/item/simpla-admin-flexible-user-friendly-admin-skin/46073/index.htm"></a> | <a href="#">Top</a>
				</small>
			</div><!-- End #footer -->
			
		</div> <!-- End #main-content -->
		
	</div></body>
  
</html>


<?php
	
	}
	
?>