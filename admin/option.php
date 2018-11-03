<?php
include ("classes.php");


if($_GET['action']=="add")
	{
	$sql="SELECT * FROM question1 WHERE option_id='$_SESSION[option]'";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);
	$sql="INSERT INTO question1_answers (question_id,`text`) VALUES ('$line[id]','$_GET[text]')";
	mysql_query($sql);
	echo mysql_insert_id();
	}
if($_GET['action']=="update_order")
	{
	$order=$_GET['order'];
	$order=explode(",",$order);
	$i=1;
	foreach($order as $key=>$value)
		{
	
			$value=str_replace("row","",$value);
			$sql="UPDATE question1_answers SET `index`='$i' WHERE id='$value'";
			mysql_query($sql);
			$i++;
		}
		
	}
if($_GET['action']=="update_answer")
{
	$id=$_POST['id'];
	$sql="UPDATE question1_answers SET text='$_POST[text]' WHERE id='$id'";
	echo $sql;
	mysql_query($sql) or die(mysql_error());
}
if($_GET['action']=="edit_answer")
	{
	$sql="SELECT * FROM question1_answers WHERE id='$_GET[id]'";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);
	?>
    <script src="js/jquery.form.js" type="text/javascript"></script>
    <script type="text/javascript">
	$("#form1").ajaxForm(function(){$("#answers").load("option.php?action=get_answers");     $(".close").trigger("click");});
	</script>
    	<form action="option.php?action=update_answer" method="post" id="form1">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							<input type="hidden" name="id" value="<?=$_GET['id']?>" />	
							  <p>
									<label>Nume</label><input class="text-input large-input" type="text" value="<?=$line['text']?>" id="small-input" name="text" />
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
if($_GET['action']=="delete")
	{

	$sql="DELETE FROM question1_answers WHERE id='$_GET[id]' ";
	mysql_query($sql);
	}
if($_GET['action']=="update")
	{
$name=$_GET['name'];
$text=$_GET['text'];
$question1=$_GET['question1'];
	$sql="UPDATE options SET `name`='$_GET[name]' , `text`='$_GET[text]' WHERE id='$_SESSION[option]'";
	echo $sql;
	mysql_query($sql) or die(mysql_error());
	$sql="SELECT * FROM question1 WHERE option_id='$_SESSION[option]'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result))
		{
			
			$line=mysql_fetch_array($result);
			$id=$line['id'];
			$sql="UPDATE question1 SET `text`='$question1' WHERE id='$line[id]'";
			mysql_query($sql);
		}
	else
		{
			$sql="INSERT INTO question1 (option_id,`text`) VALUES ('$_SESSION[option]','$text')";
			mysql_query($sql);
		}
	}
if($_GET['action']=="get_answers")
	{
		?>
        
<script type="text/javascript">

 $('a[rel*=modal2]').facebox();
		var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};


var foo=$("#answers tbody").sortable({
	helper: fixHelper,
	
	 update:function(e,ui) {
            var order = foo.sortable("toArray").join();
            $.post("option.php?action=update_order&order="+order);
      }
}).disableSelection();			



$("#add_answer").click(function()
								{
									var val=$("#answer1").val();
									
									$.post("option.php?action=add&text="+val,function(data){$('.row:last').before('<tr id="row<?=$l['id']?>"><td>'+val+'</td><td> <a href="option.php?action=edit_answer&id='+data+'" title="Edit" class="edit"><img src="resources/images/icons/pencil.png"  rel="modal2" alt="Edit" /></a><a href="#" idr="'+data+'" class="delete" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a> <a href="question2.php?id='+data+'" i title="Delete">intrebare 2></a></td></tr>');  
$(".edit").bind("click",function(){
	var href=$(this).attr("href");
jQuery.facebox(function() {
  jQuery.get(href, function(data) {
    jQuery.facebox(data)
  });
});
	 return false;
	});
									});
									
								});

$(".delete").click(function(){
							
							var idr=$(this).attr("idr");
							$.post("option.php?action=delete&id="+idr);
							$("#row"+idr).fadeOut("slow");
							return false;
							});


$("#update").click(function(){
							
							var name=$("#name").val();
							var text=$("#text").val();
							var question1=$("#question1").val();
							$.post("option.php?action=update&name="+name+"&text="+text+"&question1="+question1);
							$("#confirm").fadeIn("slow");
							return false;
							});




			
</script>
		
		

	 <table style="width:80%" id="answers">
							
							<thead>
								<tr>
								   
								   <th>Raspuns</th>
                                   <th>Actiuni</th>
								   
								</tr>
								<tr class="row" style="display:none;"></tr>
							</thead>
	 
							<tbody>
								<?php
								$sql="SELECT * FROM question1 WHERE option_id='$_SESSION[opt]'";
								$result=mysql_query($sql);
								$line=mysql_fetch_array($result);
								$s="SELECT * FROM question1_answers WHERE question_id='$line[id]' ORDER BY `index` ASC";
								$r=mysql_query($s);
								while($l=mysql_fetch_array($r))
										{
										?>
                                <tr class="row" id="row<?=$l['id']?>">
									
									<td><?=$l['text']?></td>
									<td>
										<!-- Icons -->
										 <a href="option.php?action=edit_answer&id=<?=$l['id']?>" idr="" class="edit" rel="modal2" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
										 <a href="#" idr="<?=$l['id']?>" class="delete" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
										  <a href="question2.php?id=<?=$l['id']?>" i title="Delete">intrebare 2></a>
									</td>
								</tr>
								<?php
									}
									?>
                                    <tr class="row" style="display:none;"></tr>
								<tr>
									
									<td><input name="answer1" type="text" class="text-input large-input" id="answer1" value="<?=$line['name']?>" /></td>
									
									<td><input class="button" type="button" id="add_answer" value="Adauga" /></td>
								</tr>
								
								
							</tbody>
							
						</table>
             <?php	
	}
if(!$_GET['action'])
{
	add_header();
	$id=$_GET['id'];

$_SESSION['opt']=$id;
$sql="SELECT * FROM options WHERE id='$_GET[id]'";
$result=mysql_query($sql);
$line=mysql_fetch_array($result);
$s="SELECT * FROM question1 WHERE option_id='$_GET[id]'";
$r=mysql_query($s);
if(!mysql_num_rows($r))
	{
		$sql="INSERT INTO question1 (option_id) VALUES ('$_GET[id]')";
		mysql_query($sql);
		$s="SELECT * FROM question1 WHERE option_id='$_GET[id]'";
		$r=mysql_query($s);
	}
$question1=mysql_fetch_array($r);
$_SESSION['option']=$id;
echo "<a hre='$_SERVER[PHP_SELF]'>$line[text]</a>";
?>
<script type="text/javascript" src="js/jquery.ui.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	
$("#answers").load("option.php?action=get_answers&id=<?=$_GET['id']?>");

	
});
</script>
<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3><?=$line['name']?></h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">Table</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#tab2">Forms</a></li>
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
				<form action="" method="post">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p><label>Name</label>
								  <input name="name" type="text" class="text-input small-input" id="name" value="<?=$line['name']?>" /><!-- Classes for input-notification: success, error, information, attention -->
								  <br />
										<small>Numele optiunii</small>
							  </p>
								
								<p>
									<label>Text</label>
									<input class="text-input medium-input datepicker" type="text" id="text" name="text" value="<?=$line['text']?>" /> 
								  <br>
									<small>Textul optiunii</small>
                                </p>
								
                                <hr>
                                								<p>
									<label>Intrebare 1</label>
									<input class="text-input medium-input datepicker" type="text" id="question1" name="question1" value="<?=$question1['text']?>" /> 
									<br>
									<small>Textul primei intrebari</small>
                                </p>
						
                        <p>
									<input class="button" type="button" id="update" value="Salveaza" />
                                    <div class="notification success png_bg" id="confirm" style="display:none;"> 
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					Datele au fost salvate !
				</div>
			</div>
                                    
								</p>
                        
								<p>
                                Raspunsuri
                               <div id="answers">
                               
                               </div>
                                </p>
                                
                                
                                      
                                
                       
                                
                                
							</fieldset>
                            
                            
							
							<div class="clear"></div><!-- End .clear -->
							
                            
								
						</form>
					</div> 
					<!-- End #tab1 --><!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div>
<?php
add_footer();
}
?>