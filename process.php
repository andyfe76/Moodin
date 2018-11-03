<?php
include ("dbconnect.php");
header('Expires: Fri, 09 Jan 1981 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=', FALSE);
header('Pragma: no-cache');

$action=$_GET['action'];
$action();
?>
<style type="text/css">

.carousel-control { cursor:pointer; } 

</style>
	

<?php
function get_option_text()
{
$option_id=$_GET['option'];
$sql="SELECT * FROM options WHERE id='$option_id'";
$result=mysql_query($sql);
$line=mysql_fetch_array($result);
echo $line['text'];
	
}

function get_question1()
{
	$id=$_GET['option'];
	$sql="SELECT * FROM question1 WHERE option_id='$id'";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);
	echo $line['text'];
}
function get_question2()
{
	$id=$_GET['answer'];
	$sql="SELECT * FROM question2 WHERE answer_id='$id'";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);
	echo $line['text'];
}

function get_question2_answers()
{
?>
<script type="text/javascript">

$(".q2a").click(function(evt)
		{
			
		$(".q2a").removeClass("active");
		$(this).addClass("active");
		var aid=$(this).attr("aid");
		$("#question3").load("process.php?action=get_question3&answer="+aid);
		$("#items").load("process.php?action=get_items&answer="+aid);
		$("#footer").load("process.php?action=get_tag_items&answer="+aid);
			evt.preventDefault();
		return false;
		});


</script>

<?php
	$id=$_GET['answer'];
	$sql="SELECT * FROM question2 WHERE answer_id='$id'";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);

	$s="SELECT * FROM question2_answers WHERE question_id='$line[id]' ORDER BY `index`";
	$r=mysql_query($s);
	echo "<ul>";
	while($l=mysql_fetch_array($r))
		{
			echo "<li aid='$l[id]' class='q2a'><a href='javascript:void(0)' title=''>$l[text]</a></li><br>";
		}
	echo "</ul>";
	
}

function get_question3()
{
	$id=$_GET['answer'];
	$sql="SELECT * FROM question3 WHERE answer_id='$id'";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);
	echo $line['text'];
}
function show_item()
{
?>
<iframe frameborder="0" style="border:none;" src="item.php?id=<?=$_GET['id']?>" width="600" height="300"></iframe>

<?php
}
function get_items()
{
?>
<script type="text/javascript" src="carousel.js"></script>
<style type="text/css">

.disabled
{
	visibility:hidden;
}
</style>
<script type="text/javascript">
$('#mycarousel').carousel( { direction: "vertical", dispItems: 2 });

$(".item_image").click(function(evt){

								var iid=$(this).attr("iid");
								$("#modal_content").load("process.php?action=show_item&id="+iid,
														 
														 
														 
														 function(){
								$("#overlay").fadeIn("slow");
								$("#modal").fadeIn("slow");
																	 });
									evt.preventDefault();
										return false;
								});

</script>

<?php	


echo '<div id="mycarousel"><ul>';
	$id=$_GET['answer'];
	$sql="SELECT * FROM question3 WHERE answer_id='$id'";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);
	$s="SELECT * FROM items WHERE question_id='$line[id]'";
	$r=mysql_query($s);
	while($l=mysql_fetch_array($r))
	{

$s2="SELECT * FROM items WHERE id='$l[parent_id]'";
$r2=mysql_query($s2);
$parent=mysql_fetch_array($r2);
$s3="SELECT * FROM images WHERE item_id='$parent[id]'";
$r3=mysql_query($s3);
$l3=mysql_fetch_array($r3);		
?>
<li>
<table wdith="180" height="180">
  				<tr>
  				  <td valign="top">
  				    <?php
					$s2="SELECT * FROM images WHERE item_id='$l[id]'";
					$r2=mysql_query($s2);
					$l2=mysql_fetch_array($r2);
					?>
  				    <img iid="<?=$l['id']?>" style="cursor:pointer; float:left; margin-right:4px; margin-bottom:2px;"  class="item_image" src="img_edit/<?=$l2['image']?>" width="100">
                    <p><font size="1px">
			        
					<?php
					$s2="SELECT * FROM custom_fields WHERE item_id='$l[id]' AND star='1' ";
					$r2=mysql_query($s2) or die(mysql_error());
					while($l2=mysql_fetch_array($r2))
						{
					?>
  				      
			        <?=$l2['name']?>:<?=$l2['value']?><br>
			        <?php	
						}
					?>
  				      
			        </font> 
  				    <?php
					if(is_file("img_edit/".$l3['image']))
					{
						?>
  				    <img src="img_edit/<?=$l3['image']?>" style="float:right; margin-left:2px;" width="80px">
  				    <?php
					}
					?>  				    <font size="1px"><?=$l['text']?></font>
                    
                    </p>
                    </td>
				  </tr>
  				</table>
</li>
                
<?php                
	}
	
echo "</ul></div><div style='clear:both;'></div>";


}
function get_question1_answers()
{	
?>
<script type="text/javascript">

$(".q1a").click(function(evt)
		{
			
		$(".q1a").removeClass("active");
		$(this).addClass("active");
		var aid=$(this).attr("aid");
		$("#question2").load("process.php?action=get_question2&answer="+aid);
		$("#menu3").load("process.php?action=get_question2_answers&answer="+aid);
				$("#question3").html("");
		$("#items").html("");
		$("#footer").html("");
		evt.preventDefault();
				return false;
		});


</script>

<?php


	$id=$_GET['option'];
	$sql="SELECT * FROM question1 WHERE option_id='$id'";
	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);
	$s="SELECT * FROM question1_answers WHERE question_id='$line[id]' ORDER BY `index`";
	$r=mysql_query($s);
	echo "<ul>";
	while($l=mysql_fetch_array($r))
		{
			echo "<li aid='$l[id]' class='q1a'><a href='javascript:void(0)' title=''>$l[text]</a></li><br>";
		}
	echo "</ul>";
}
  












function get_tag_items()
{
?>
<iframe src="carousel_jos.php?answer=<?=$_GET['answer']?>" width="450"  frameborder="0" marginwidth="0" marginheight="0"  style="border:none; margin:auto;"></iframe>
<?php
}

mysql_close();
?>