<?php
include ("classes.php");
if(!$_GET['action'])
{		  
add_header();
?>
<script type="text/javascript">
$(document).ready(function(){
						   
						   $("#tab1").load("templates.php?action=load_items");
						  
						   
						   });

</script>
<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>Templates</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">Table</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="templates.php?action=add" rel="modal">Adauga Item</a></li>
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
					 
					</div> 
					<!-- End #tab1 --><!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div>
<?php
add_footer();
}
if($_GET['action']=="load_items")
	{
	?>	
<script type="text/javascript">
 $(".delete").click(function()
													   	{
														var rel=$(this).attr("rel");
														$.post("templates.php?action=delete&id="+rel);
														$("#row"+rel).fadeOut("slow");
															return false;
														});
 $('a[rel*=modal2]').facebox(); 

</script>
      <table>
							
			  <thead>
								<tr>
							
								   <th>Id</th>
								   <th>Nume</th>
								   <th>Actions</th>
								</tr>
								
							</thead>
			  <tbody>
              
<?php
$sql="SELECT * FROM templates WHERE 1 GROUP BY `template`";
$result=mysql_query($sql) or die(mysql_error());
while($line=mysql_fetch_array($result))
{
	
	?>
  <tr id="row<?=$line['id']?>" class="row">

									<td><?php echo $line['id'];?></td>
									<td><?php echo $line['template'];?></td>
									<td>
										<!-- Icons -->
										 <a href="templates.php?action=edit&id=<?=$line['template']?>" rel="modal2"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
										 <a href="#" class="delete" rel="<?=$line['template']?>" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
										
									</td>
								</tr>
                                
<?php
}
?>
							</tbody>
							
						</table>
						   
        
	
    <?php	
	}

if($_GET['action']=="edit")
{
$id=$_GET['id'];
$sql="SELECT * FROM templates WHERE template='$id'";
$result=mysql_query($sql);
$item=mysql_fetch_array($result);
?>

<script src="js/jquery.form.js" type="text/javascript"></script>

<script type="text/javascript">
  $('.remove_field').bind('click', function() {
																	   
  											
											 $(this).parent("p").remove();
											 return false;
										});
	
$("#form1").ajaxForm(function(){
							 
					
							  $("#tab1").load("templates.php?action=load_items");
							  return false; 
							  });
$("#add_field").click(function(){
							   
							   $(".custom:last").after('<p>Nume field: <input type="text" name="names[]"/> <a href="#" class="remove_field">X</a></p>');
							   $(".remove_field").bind("click",function(){
																		$(this).parent().fadeOut("medium",function(){$(this).parent("p").remove();});
																		
																		});
							   });

</script>
<div id="form_div">
	<form action="templates.php?action=update_item" method="post" id="form1">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							<input type="hidden" name="id" value="<?=$_GET['id']?>" />	
							  <p>
									<label>Nume</label><input class="text-input large-input" type="text" value="<?=$item['template']?>" id="small-input" name="template" />
								</p>
								
								<p>&nbsp;</p>
<p>Fielduri:</p>
<p class="custom"></p>
<?php
$sql="SELECT * FROM templates WHERE template='$item[template]'";
$result=mysql_query($sql);
while($line=mysql_fetch_array($result))
{
	?>
<p>Nume field: <input type="text" name="names[]" value="<?=$line['field']?>"/> <a href="#" class="remove_field">X</a></p>
<?php
}
?>
<p><a href="#" id="add_field">Adauga Field</a></p>
								
								<p>
									<input class="button" type="submit" value="Submit" />
							  </p>
								
	  </fieldset>
      </form>
      </div>
      <p>

  
      
      
							
							<div class="clear"></div><!-- End .clear -->
							
</form>
<?php

	}
	
	
if($_GET['action']=="update_item")
{
	$template=$_POST['template'];
	$names=$_POST['names'];
	$sql="DELETE FROM templates WHERE template='$_POST[id]'";
	echo $sql;
	mysql_query($sql) or die(mysql_error());
	foreach($names as $key=>$value)
	{
	$sql="INSERT INTO `templates` (`template`,`field`) VALUES ('$template','$value')";
	mysql_query($sql) or die(mysql_error());
	}

}
	
if($_GET['action']=="add_item")
{
	$template=$_POST['template'];
	$names=$_POST['names'];
	foreach($names as $key=>$value)
	{
	$sql="INSERT INTO `templates` (`template`,`field`) VALUES ('$template','$value')";
	mysql_query($sql) or die(mysql_error());
	}
	
	
}
if($_GET['action']=="delete")
{
	$template=$_GET['template'];
	
	$sql="DELETE FROM templates WHERE template='$template'";
	mysql_query($sql) or die(mysql_error());

	
}
if($_GET['action']=="add")
{

?>

<script src="js/jquery.form.js" type="text/javascript"></script>

<script type="text/javascript">
  $('.remove_field').bind('click', function() {
																	   
  											// $(this).parent("p").fadeOut('slow',function(){$(this).parent("p").remove();});
											 $(this).parent("p").remove();
											 return false;
										});
	
$("#form1").ajaxForm(function(){
							 
					
							  $("#tab1").load("templates.php?action=load_items");
							  return false; 
							  });
$("#add_field").click(function(){
							   
							   $(".custom:last").after('<p>Nume field: <input type="text" name="names[]"/> <a href="#" class="remove_field">X</a></p>');
							   $(".remove_field").bind("click",function(){
																		$(this).parent().fadeOut("medium",function(){$(this).parent("p").remove();});
																		
																		});
							   });

</script>
<div id="form_div">
	<form action="templates.php?action=add_item" method="post" id="form1">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							<input type="hidden" name="id" value="<?=$_GET['id']?>" />	
							  <p>
									<label>Nume</label><input class="text-input large-input" type="text" value="" id="small-input" name="template" />
								</p>
								
								<p>&nbsp;</p>
<p>Fielduri:</p>
<p class="custom"></p>
<p><a href="#" id="add_field">Adauga Field</a></p>
								
								<p>
									<input class="button" type="submit" value="Submit" />
							  </p>
								
	  </fieldset>
      </form>
      </div>
      <p>

  
      
      
							
							<div class="clear"></div><!-- End .clear -->
							
</form>
<?php

	}
	?>
