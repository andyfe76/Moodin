<?php
include ("classes.php");

$id=$_GET['id'];
if($_GET['action']=="update")
	{
	$sql="SELECT * FROM question3 WHERE answer_id='$_SESSION[question2]'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result))
		{
			
			$line=mysql_fetch_array($result);
			$id=$line['id'];
			$sql="UPDATE question3 SET `text`='$_GET[question3]' WHERE id='$line[id]'";
			mysql_query($sql);
		}
	else
		{
			$sql="INSERT INTO question3 (answer_id,`text`) VALUES ('$_SESSION[question2]','$_GET[question3]')";
			echo $sql;
			mysql_query($sql);
		}

	}
	
if($id)
$_SESSION['question2']=$id;
if(!$_GET['action'])
{
add_header();
$sql="SELECT * FROM question2_answers WHERE id='$id'";
$result=mysql_query($sql);
$line=mysql_fetch_array($result);
$sql2="SELECT * FROM question2 WHERE id='$line[question_id]'";
$result2=mysql_query($sql2);
$line2=mysql_fetch_array($result2);
echo $_SESSION['b1'].">"."<a href='question2.php?id=$_SESSION[question1]'>".$line2['text'].">".$line['text']."</a> <a href='$_SERVER[PHP_SELF]'>Intrebare 3</a>";
$s="SELECT * FROM question3 WHERE answer_id='$line[id]'";
$r=mysql_query($s);
if(!mysql_num_rows($r))
	{
	$sql="INSERT INTO question3 (answer_id) VALUES ('$line[id]')";
	mysql_query($sql);	
	$s="SELECT * FROM question3 WHERE answer_id='$line[id]'";
	$r=mysql_query($s);
	}
$l=mysql_fetch_array($r);
?>
<script type="text/javascript">
$(document).ready(function(){
$("#add_answer").click(function()
								{
									var val=$("#answer1").val();
									
									$.post("question2.php?action=add&text="+val,function(){$('.row:last').after('<tr id="row<?=$l['id']?>"><td>'+val+'</td><td>refresh pt editare</td></tr>');
									});
									
								});

$(".delete").click(function(){
							
							var idr=$(this).attr("idr");
							$.post("question2.php?action=delete&id="+idr);
							$("#row"+idr).fadeOut("slow");
							return false;
							});

$("#update").click(function(){
							

							var question3=$("#question3").val();
							$.post("question3.php?action=update&question3="+question3);
							$("#confirm").fadeIn("slow");
							return false;
							
							});


						   });
</script>
                   
                          <hr>
                   <form>
                   <fieldset>
                                								<p>
									<label>Intrebare 3</label>
                                   

                                    
									<input class="text-input medium-input datepicker" type="text" id="question3" name="question3" value="<?=$l['text']?>" /> 
									<br>
									<small>Textul celei de a 3-a intrebari</small>
                                </p>
						
								<p><input class="button" type="button" id="update" value="Salveaza" />
                               
                                    <div class="notification success png_bg" id="confirm" style="display:none;"> 
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					Datele au fost salvate !
				</div>
			</div>
                                
                                </p>
                                </fieldset>
                        </form>
<?php
add_footer();
}
?>