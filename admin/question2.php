<?php
include ("classes.php");


if($_GET['action']=="add")
	{
	$sql="SELECT * FROM question2 WHERE answer_id='$_SESSION[question1]'";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);
	$sql="INSERT INTO question2_answers (question_id,`text`) VALUES ('$line[id]','$_GET[text]')";
	mysql_query($sql);
	echo mysql_insert_id();
	}
if($_GET['action']=="delete")
	{

	$sql="DELETE FROM question2_answers WHERE id='$_GET[id]' ";
	mysql_query($sql);
	}
if($_GET['action']=="update")
	{
	$sql="SELECT * FROM question2 WHERE answer_id='$_SESSION[question1]'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result))
		{
			
			$line=mysql_fetch_array($result);
			$id=$line['id'];
			$sql="UPDATE question2 SET `text`='$_GET[question2]' WHERE id='$line[id]'";
			mysql_query($sql);
		}
	else
		{
			$sql="INSERT INTO question2 (answer_id,`text`) VALUES ('$_SESSION[question1]','$_GET[question2]')";
			mysql_query($sql) or die(mysql_error());
			echo $sql;
		}

	}
	
if($_GET['action']=="update_order")
	{
	$order=$_GET['order'];
	$order=explode(",",$order);
	$i=1;
	foreach($order as $key=>$value)
		{
	
			$value=str_replace("row","",$value);
			$sql="UPDATE question2_answers SET `index`='$i' WHERE id='$value'";
			mysql_query($sql);
			$i++;
		}
		
	}	
if($_GET['action']=="update_answer")
{
	$id=$_POST['id'];
	$sql="UPDATE question2_answers SET text='$_POST[text]' WHERE id='$id'";
	echo $sql;
	mysql_query($sql) or die(mysql_error());
}
if($_GET['action']=="edit_answer")
	{
	$sql="SELECT * FROM question2_answers WHERE id='$_GET[id]'";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);
	?>
    <script src="js/jquery.form.js" type="text/javascript"></script>
    <script type="text/javascript">
	$("#form1").ajaxForm(function(){$("#answers").load("question2.php?action=get_answers"); $(".close").trigger("click");});
	</script>
    	<form action="question2.php?action=update_answer" method="post" id="form1">
							
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
if($_GET['action']=="get_answers")
	{
	?>
    <script type="text/javascript" src="js/jquery.ui.js"></script>
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
            $.post("question2.php?action=update_order&order="+order);
      }
}).disableSelection();			
						   
						   
						   
						   
$("#add_answer").click(function()
								{
									var val=$("#answer1").val();
									
									$.post("question2.php?action=add&text="+val,function(data){$('.row:last').before('<tr id="row<?=$l['id']?>"><td>'+val+'</td><td> <a href="question2.php?action=edit_answer&id='+data+'" class="edit" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a><a href="#" idr="'+data+'" class="delete" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a><a href="question3.php?id='+data+'" >Intrebarea 3></a></td></tr>');
									
									
								
								
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
							$.post("question2.php?action=delete&id="+idr);
							$("#row"+idr).fadeOut("slow");
							return false;
							});

$("#update").click(function(){
							

							var question2=$("#question2").val();
							$.post("question2.php?action=update&question2="+question2);
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
								
							</thead>
	 
							<tbody>
                            <tr class="row" style="display:none;"><tD></tD></tr>
								<?php

								$s="SELECT * FROM question2_answers WHERE question_id='$_SESSION[q1]' ORDER BY `index` ASC";
								$r=mysql_query($s);
								while($l=mysql_fetch_array($r))
										{
										?>
                                <tr class="row" id="row<?=$l['id']?>">
									
									<td><?=$l['text']?></td>
									<td>
										<!-- Icons -->
										 <a href="question2.php?action=edit_answer&id=<?=$l['id']?>" rel="modal2" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
										 <a href="#" idr="<?=$l['id']?>" class="delete" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
										 <a href="question3.php?id=<?=$l['id']?>" >Intrebarea 3></a> 										 
									</td>
								</tr>
								<?php
									}
									?>
                               <tr class="row" style="display:none;"><tD></tD></tr>
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
$_SESSION['question1']=$id;

$sql="SELECT * FROM question1_answers WHERE id='$id'";
$result=mysql_query($sql);
$line=mysql_fetch_array($result);
$sql2="SELECT * FROM question1 WHERE id='$line[question_id]'";
$result2=mysql_query($sql2);
$line2=mysql_fetch_array($result2);
$_SESSION['b1']="<a href='option.php?id=$_SESSION[option]'>".$line2['text'].">".$line['text']."</a>";
echo "<a href='option.php?id=$_SESSION[option]'>".$line2['text'].">".$line['text']."</a> <a href='$_SERVER[PHP_SELF]'>Intrebare 2</a>";

$s="SELECT * FROM question2 WHERE answer_id='$line[id]'";
$r=mysql_query($s);
if(!mysql_num_rows($r))
	{
	$sql="INSERT INTO question2 (answer_id) VALUES ('$line[id]')";
	mysql_query($sql);	
	$s="SELECT * FROM question2 WHERE answer_id='$line[id]'";
	$r=mysql_query($s);
	}
$l=mysql_fetch_array($r);
$_SESSION['q1']=$l['id'];
?>



<script type="text/javascript">
$(document).ready(function(){
						
$("#answers").load("question2.php?action=get_answers"); 

						   });
</script>
                   
                          <hr>
                   <form>
                   <fieldset>
                                								<p>
									<label>Intrebare 2</label>
                                   

                                    
									<input class="text-input medium-input datepicker" type="text" id="question2" name="question2" value="<?=$l['text']?>" /> 
									<br>
									<small>Textul celei de a doua intrebari</small>
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
                             <div id="answers"></div>
                                
                                </p>
                                </fieldset>
                                </form>
<?php
add_footer();
}
?>