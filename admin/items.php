<?php
include ("classes.php");

if($_GET['action']=="update_item")
	{
	$form=$_POST['form'];
	$id=$_POST['id'];
	$man=new manager;
	$man->set_table("items");
	$man->db_modify($form,$id);
	$sql="DELETE  FROM custom_fields WHERE item_id='$id'";
	mysql_query($sql);
	$names=$_POST['names'];
	$values=$_POST['values'];
	$star=$_POST['star'];
		$i=1;
	if($names)
	foreach($names as $key=>$value)
		{
			$sql="INSERT INTO custom_fields (item_id,`name`,`value`,`index`,`star`) VALUES ('$id','$value','$values[$key]','$i','$star[$key]')";
			echo $sql;
			mysql_query($sql) or die(mysql_error());
			$i++;
		}
	}
	
if($_GET['action']=="image_delete")
{	
	$id=$_GET['id'];
	$sql="DELETE FROM images WHERE id='$id'";
	mysql_query($sql);

}

if($_GET['action']=="get_images")
{
?>	
<script type="text/javascript">
$(".image").click(function(){
						    if(confirm("Esti sigur ca vrei sa stergi poza ?"))
{
						   var rel=$(this).attr("rel");
						   $.post("items.php?action=image_delete&id="+rel);
						   $(this).fadeOut("slow");
						   
}
						   });
</script>
 <p>
      	  Imagini: (click pe imagine pentru stergere)<br style="clear:both" />
      <?php
if(!$_GET['id'])
	{
	$sql="SELECT * FROM items WHERE 1 ORDER BY `id` desc";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);
	$item_id=$line['id'];	
	}
else $item_id=$_GET['id'];
	  $sql="SELECT * FROM images WHERE item_id='$item_id'";
	  $result=mysql_query($sql);
	  while($line=mysql_fetch_array($result))
	  	{
			
			?>
            <img style="cursor:pointer;" class="image" rel="<?=$line['id']?>" width="100" src="../img_edit/<?=$line['image']?>" />
            
            <?php
		}
		?>
      
      </p>	
      
<?php
}
if($_GET['action']=="edit")
{
$id=$_GET['id'];
$sql="SELECT * FROM items WHERE id='$id'";
$result=mysql_query($sql);
$item=mysql_fetch_array($result);
?>


<script type="text/javascript" src="uploadify/example/scripts/swfobject.js"></script>
<script type="text/javascript" src="uploadify/example/scripts/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.js"></script>

<script src="js/jquery.form.js" type="text/javascript"></script>
<link href="uploadify/example/css/default.css" rel="stylesheet" type="text/css" />

<link href="uploadify/example/css/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	
	$("#images").load("items.php?action=get_images&id=<?=$_GET['id']?>");
	  $('.delete_field').bind('click', function() {
												$(this).parent("p").remove();					   
  											 //$(this).parent("p").fadeOut('slow',function(){$(this).parent("p").remove();});
											 
											 return false;
										});
	$("#uploadify").uploadify({
		'uploader'       : 'uploadify/uploadify.swf',
		'script'         : 'uploadify/uploadify.php?id=<?=$_GET['id']?>',
		'cancelImg'      : 'uploadify/cancel.png',
		'folder'         : '../img_edit/',
		'queueID'        : 'fileQueue',
		'auto'           : true,
		'multi'          : true,
		'onAllComplete'  : function(){	$("#images").load("items.php?action=get_images&id=<?=$_GET['id']?>");}
	});
	
$("#form1").ajaxForm(function(){
							 
					
							  $("#tab1").load("items.php?action=load_items");
							  return false; 
							  });



$("#add_custom_field").click(function(){
									  
									  
									  $(".custom:last").after("<p><input type='text' name='names[]' style='width:100px;' / > -&gt; <input type='text' name='values[]'  style='width:100px;' /> <input type='checkbox' name='star[]' value='1' /> <a href='#' class='delete_field'>X</a></p>");
									  $('.delete_field').bind('click', function() {
																	   
  											 $(this).parent("p").fadeOut('slow',function(){$(this).parent("p").remove();});
											 
											 return false;
										});
									 return false;
									  });
$(".template_add").click(function(){
									  
									  var rel=$(this).attr("rel");
									  $(".custom:last").after(rel);
									    $('.delete_field').bind('click', function() {
																	   
  											 $(this).parent("p").fadeOut('slow',function(){ $(this).parent("p").remove();});
											
										});
										return false;
									  });
									  
var foo=$("#custom_container2").sortable({
	
	 update:function(e,ui) {
            var order = foo.sortable("toArray").join();
           // $.post("option.php?action=update_order&order="+order);
      }
}).disableSelection();	

</script>

<div style="width:900px;">
<form action="items.php?action=update_item" method="post" id="form1">
<br style="clear:both" />
<div style="float:left;">
<div id="form_div">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p>
                                <input type="hidden" name="id" value="<?=$_GET['id']?>" />
									<label>Nume</label><input class="text-input large-input" type="text" id="small-input" name="form[name]" value="<?=$item['name']?>" />
								</p>
								
								<p>
								  <label>Item Parinte</label>
								  <select name="form[parent_id]" id="select">
                                  <option value="0">(None)</option>
                                  	<?php
									$sql="SELECT * FROM items WHERE 1";
									$result=mysql_query($sql);
									while($line=mysql_fetch_array($result))
										{
											?>
                                            <option <?php if($item['parent_id']==$line['id']) echo "selected"; ?> value="<?=$line['id']?>"><?=$line['name']?></option>
                                            <?php
										}
										?>
							      </select>
								</p>
                                <p>
								  <label>Intrebarea 3</label>
								  <select name="form[question_id]" id="select">
                                  <option value="0">(None)</option>
                                  	<?php
									$sql="SELECT * FROM question3 WHERE 1";
									$result=mysql_query($sql);
									while($line=mysql_fetch_array($result))
										{
											?>
                                            <option  <?php if($item['question_id']==$line['id']) echo "selected"; ?>  value="<?=$line['id']?>"><?=$line['text']?></option>
                                            <?php
										}
										?>
							      </select>
								</p>
								
								<p>&nbsp;</p>
								
								<p>
								  <label>Text</label>
									<textarea class="text-input textarea wysiwyg" id="textarea" name="form[text]" cols="79" rows="15"><?=$item['text']?></textarea>
							  </p>
                              
                              	<p>
								  <label>Taguri (tag1,tag2)</label>
									<textarea class="text-input textarea wysiwyg" id="textarea" name="form[tags]" cols="50" rows="10"><?=$item['tags']?></textarea>
							  </p>
								
								<p>
									<input class="button" type="submit" value="Submit" />
								</p>
								
	  </fieldset>

      </div>
      <p>
     
      </p>
      
      
							
							<div class="clear"></div><!-- End .clear -->
							

</div> 
<div style="float:left; margin-left:20px;">
<div id="custom_fields">
<p>

Fielduri custom:
<div id="custom_container2">
<div class="custom"></div>
<?php
$sql="SELECT * FROM custom_fields WHERE item_id='$id' ORDER BY `index`";
$result=mysql_query($sql);
while($line=mysql_fetch_array($result))
	{
		?>
        <p><input type='text' value='<?=$line['name']?>' name='names[]'  style='width:100px;' / > -&gt; <input type='text'  style='width:100px;' name='values[]' value="<?=$line['value']?>" /> <input type="checkbox" <?php if($line['star']) echo "checked"; ?> name="star[]" value="1" /> <a href='#' class='delete_field'>X</a> </p>
        <?php
	}
	?>
 </div>
<a hreg="#" id="add_custom_field">adauga field custom</a>
</p>

<p>
Campuri custom:<br />
<?php
$s="SELECT * FROM fields WHERE 1 ";
$r=mysql_query($s);
while($l=mysql_fetch_array($r))
	{	$fields="";
		
				$fields="<p><input type='text' value='$l[name]' name='names[]'  style='width:100px;' / > -&gt; <input  style='width:100px;' type='text' name=values[] />  <input type='checkbox' name='star[]' value='1' />  <a href='#' class='delete_field'>X</a></p>";
		
		?>
        <a href="#" rel="<?=$fields?>" class="template_add"><?=$l['name']?></a><br />
        
        <?php
	}
	?>
</p>

<p>
Templateuri:<br />
<?php
$s="SELECT * FROM templates WHERE 1 GROUP BY `template`";
$r=mysql_query($s);
while($l=mysql_fetch_array($r))
	{	$fields="";
		$s2="SELECT * FROM templates WHERE template='$l[template]'";
		$r2=mysql_query($s2);
		while($l2=mysql_fetch_array($r2))
			{
				$fields.="<p><input type='text' value='$l2[field]' name='names[]'  style='width:100px;' / > -&gt; <input type='text' name=values[]  style='width:100px;' />  <input type='checkbox' name='star[]' value='1' /> <a href='#' class='delete_field'>X</a></p>";
			}
		?>
        <a href="#" rel="<?=$fields?>" class="template_add"><?=$l['template']?></a><br />
        
        <?php
	}
	?>
</p>
</div>
</div>
<div class="clear"></div>
</form>
 <div >
 
<div id="images"></div>
 
      <div id="fileQueue" style="height:200px;"></div>
<input type="file" name="uploadify" id="uploadify" />
<p><a href="javascript:jQuery('#uploadify').uploadifyClearQueue()">Cancel All Uploads</a></p>
</div>
</div>

<?php

	}
if($_GET['action']=="load_items")
	{
	?>	
<script type="text/javascript">
 $(".delete").click(function()
													   	{
														var rel=$(this).attr("rel");
														$.post("items.php?action=delete&id="+rel);
														$("#row"+rel).fadeOut("slow");
															return false;
														});
 $('a[rel*=modal2]').facebox(); 

</script>
      <table>
							
			  <thead>
								<tr>
							
								   <th>Id</th>
								   <th>Name</th>
								   <th>Description</th>
								   <th>Actions</th>
								</tr>
								
							</thead>
			  <tbody>
              
<?php
$sql="SELECT * FROM items WHERE 1";
$result=mysql_query($sql) or die(mysql_error());
while($line=mysql_fetch_array($result))
{
	
	?>
  <tr id="row<?=$line['id']?>" class="row">

									<td><?php echo $line['id'];?></td>
									<td><?php echo $line['name'];?></td>
									<td><?php echo $line['text'];?></td>
									<td>
										<!-- Icons -->
										 <a href="items.php?action=edit&id=<?=$line['id']?>" rel="modal2"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
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

if($_GET['action']=="add_item")
	{
	$form=$_POST['form'];
	$man=new manager;
	$man->set_table("items");
	$id=$man->db_insert($form);
	$_SESSION['last_item']=$id;
	$names=$_POST['names'];
	$values=$_POST['values'];
	$star=$_POST['star'];
	$i=1;
	foreach($names as $key=>$value)
		{
			$sql="INSERT INTO custom_fields (item_id,`name`,`value`,`index`,`star`) VALUES ('$id','$value','$values[$key]','$i','$star[$key]')";
			echo $sql;
			mysql_query($sql) or die(mysql_error());
		}

	}
if($_GET['action']=="delete")
	{
	$id=$_GET['id'];
	$sql="DELETE FROM items WHERE id='$_GET[id]'";
	mysql_query($sql);
		
	}
if($_GET['action']=="add")
	{
		
		?>
<script type="text/javascript" src="uploadify/example/scripts/swfobject.js"></script>
<script type="text/javascript" src="uploadify/example/scripts/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.js"></script>
<script src="js/jquery.form.js" type="text/javascript"></script>
<link href="uploadify/example/css/default.css" rel="stylesheet" type="text/css" />

<link href="uploadify/example/css/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	$("#uploadify").uploadify({
		'uploader'       : 'uploadify/uploadify.swf',
		'script'         : 'uploadify/uploadify.php',
		'cancelImg'      : 'uploadify/cancel.png',
		'folder'         : '../img_edit/',
		'queueID'        : 'fileQueue',
		'auto'           : true,
		'multi'          : true,
		'onAllComplete'  : function(){	$("#images").load("items.php?action=get_images");}
	});
	  $('.delete_field').bind('click', function() {
																	   
  											// $(this).parent("p").fadeOut('slow',function(){$(this).parent("p").remove();});
											 $(this).parent("p").remove();
											 return false;
										});
$("#form1").ajaxForm(function(){
							  $("#custom_fields").fadeOut(); 
							  $("#upload_div").slideDown(); 
							  
							  $("#form_div").html("Itemul a fost adaugat <br /> Uploadati imagini:"); 
							  $("#tab1").load("items.php?action=load_items");
						
							  });


$("#add_custom_field").click(function(){
									  
									  
									  $(".custom:last").after("<p><input type='text' name='names[]'  style='width:100px;' / > -&gt; <input type='text' name='values[]'  style='width:100px;' />  <input type='checkbox' name='star[]' value='1' /> <a href='#' class='delete_field'>X</a></p>");
									  $('.delete_field').bind('click', function() {
																	   
  											 $(this).parent("p").fadeOut('slow');
											 $(this).parent("p").remove();
										});
									  });
$(".template_add").click(function(){
									  
									  var rel=$(this).attr("rel");
									  $(".custom:last").after(rel);
									    $('.delete_field').bind('click', function() {
																	   
  											 $(this).parent("p").fadeOut('slow',function(){ $(this).parent("p").remove();});
											
										});
										
										return false;
									  });

var foo=$("#custom_container").sortable({
	
	 update:function(e,ui) {
            var order = foo.sortable("toArray").join();
           // $.post("option.php?action=update_order&order="+order);
      }
}).disableSelection();	

</script>


<div style="width:900px;">
<form action="items.php?action=add_item" method="post" id="form1">
<br style="clear:both" />
<div style="float:left;">
<div id="form_div">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p>
									<label>Nume</label><input class="text-input large-input" type="text" id="small-input" name="form[name]" />
								</p>
								
								<p>
								  <label>Item Parinte</label>
								  <select name="form[parent_id]" id="select">
                                  <option value="0">(None)</option>
                                  	<?php
									$sql="SELECT * FROM items WHERE 1";
									$result=mysql_query($sql);
									while($line=mysql_fetch_array($result))
										{
											?>
                                            <option value="<?=$line['id']?>"><?=$line['name']?></option>
                                            <?php
										}
										?>
							      </select>
								</p>
                                <p>
								  <label>Intrebarea 3</label>
								  <select name="form[question_id]" id="select">
                                  <option value="0">(None)</option>
                                  	<?php
									$sql="SELECT * FROM question3 WHERE 1";
									$result=mysql_query($sql);
									while($line=mysql_fetch_array($result))
										{
											?>
                                            <option value="<?=$line['id']?>"><?=$line['text']?></option>
                                            <?php
										}
										?>
							      </select>
								</p>
								
								<p>&nbsp;</p>
								
								<p>
								  <label>Text</label>
									<textarea class="text-input textarea wysiwyg" id="textarea" name="form[text]" cols="79" rows="15"></textarea>
							  </p>
								
                                
                                 	<p>
								  <label>Taguri (tag1,tag2)</label>
									<textarea class="text-input textarea wysiwyg" id="textarea" name="form[tags]" cols="50" rows="10"><?=$line['tags']?></textarea>
							  </p>
                                
                                
								<p>
									<input class="button" type="submit" value="Submit" />
								</p>
								
	  </fieldset>

      </div>
      <p>
     
      </p>
      
      
							
							<div class="clear"></div><!-- End .clear -->
							

</div> 
<div style="float:left; margin-left:20px;">
<div id="custom_fields">
<p>

Fielduri custom:
<div id="custom_container">
<div class="custom"></div>
</div>
<a hreg="#" id="add_custom_field">adauga field custom</a>
</p>

<p>
<?php
$s="SELECT * FROM fields WHERE 1 ";
$r=mysql_query($s);
while($l=mysql_fetch_array($r))
	{	$fields="";
		
				$fields="<p><input type='text' value='$l[name]' name='names[]'  style='width:100px;' / > -&gt; <input type='text'  style='width:100px;' name=values[] /> <input type='checkbox' name='star[]' value='1' /> <a href='#' class='delete_field'>X</a></p>";
		
		?>
        <a href="#" rel="<?=$fields?>" class="template_add"><?=$l['name']?></a><br />
        
        <?php
	}
	?>
<p>
Templateuri:<br />
<?php
$s="SELECT * FROM templates WHERE 1 GROUP BY `template`";
$r=mysql_query($s);
while($l=mysql_fetch_array($r))
	{	$fields="";
		$s2="SELECT * FROM templates WHERE template='$l[template]'";
		$r2=mysql_query($s2);
		while($l2=mysql_fetch_array($r2))
			{
				$fields.="<p><input type='text' value='$l2[field]' name='names[]'  style='width:100px;' / > -&gt; <input type='text' name='values[]' style='width:100px;' /> <input type='checkbox'   name='star[]' value='1' /> <a href='#' class='delete_field'>X</a></p>";
			}
		?>
        <a href="#" rel="<?=$fields?>" class="template_add"><?=$l['template']?></a><br />
        
        <?php
	}
	?>
</p>
</div>
</div>
<div class="clear"></div>
</form>
 <div style="display:none;" id="upload_div">
 
 <div id="images"></div>
      <div id="fileQueue" style="height:200px;"></div>
<input type="file" name="uploadify" id="uploadify" />
<p><a href="javascript:jQuery('#uploadify').uploadifyClearQueue()">Cancel All Uploads</a></p>
</div>
</div>

        <?php
	}
if(!$_GET['action'])
{		  
add_header();
?>
<script type="text/javascript">
$(document).ready(function(){
						   
						   $("#tab1").load("items.php?action=load_items");
						  
						   
						   });

</script>
<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>Itemuri</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">Table</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="items.php?action=add" rel="modal">Adauga Item</a></li>
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
?>