<?php
include ("classes.php");
if(!$_GET['action'])
{		  
add_header();
?>
<script type="text/javascript">
$(document).ready(function(){
						   
						   $("#tab1").load("fields.php?action=load_items");
						  
						   
						   });

</script>
<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>Fields</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">Table</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="fields.php?action=add" rel="modal">Adauga Item</a></li>
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
														$.post("fields.php?action=delete&id="+rel);
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
$sql="SELECT * FROM fields WHERE 1";
$result=mysql_query($sql) or die(mysql_error());
while($line=mysql_fetch_array($result))
{
	
	?>
  <tr id="row<?=$line['id']?>" class="row">

									<td><?php echo $line['id'];?></td>
									<td><?php echo $line['name'];?></td>
									<td>
										<!-- Icons -->
										 <a href="fields.php?action=edit&id=<?=$line['id']?>" rel="modal2"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
										 <a href="#" class="delete" rel="<?=$line['id']?>" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
										
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
$sql="SELECT * FROM fields WHERE id='$id'";
$result=mysql_query($sql);
$item=mysql_fetch_array($result);
?>

<script src="js/jquery.form.js" type="text/javascript"></script>

<script type="text/javascript">

	
$("#form1").ajaxForm(function(){
							 
					
							  $("#tab1").load("fields.php?action=load_items");
							  return false; 
							  });

					

</script>
<div id="form_div">
	<form action="fields.php?action=update_item" method="post" id="form1">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							<input type="hidden" name="id" value="<?=$_GET['id']?>" />	
							  <p>
									<label>Nume</label><input class="text-input large-input" type="text" value="<?=$item['name']?>" id="small-input" name="name" />
								</p>
								
								<p>&nbsp;</p>

								
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
	
	
if($_GET['action']=="add_item")
{
	$name=$_POST['name'];

	$sql="INSERT INTO `fields` (`name`) VALUES ('$name')";
	mysql_query($sql) or die(mysql_error());

	
}

if($_GET['action']=="update_item")
{
	$name=$_POST['name'];

	$sql="UPDATE `fields` SET `name`='$name'  WHERE id='$_POST[id]'";
	mysql_query($sql) or die(mysql_error());

	
}

if($_GET['action']=="delete")
{
	

	$sql="DELETE FROM fields  WHERE id='$_GET[id]'";
	mysql_query($sql) or die(mysql_error());

	
}
if($_GET['action']=="add")
{

?>

<script src="js/jquery.form.js" type="text/javascript"></script>

<script type="text/javascript">

	
$("#form1").ajaxForm(function(){
							 
					
							  $("#tab1").load("fields.php?action=load_items");
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
	<form action="fields.php?action=add_item" method="post" id="form1">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							<input type="hidden" name="id" value="<?=$_GET['id']?>" />	
							  <p>
									<label>Nume</label><input class="text-input large-input" type="text" value="" id="small-input" name="name" />
								</p>
								

								
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
