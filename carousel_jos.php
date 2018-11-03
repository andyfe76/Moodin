<?php
include ("dbconnect.php");
?><link rel="stylesheet" type="text/css" href="carousel/skins/tango/skin.css">
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="carousel/lib/jquery.jcarousel.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    jQuery('#mycarousel').jcarousel();
	
	$(".item_image").click(function(){
								var iid=$(this).attr("iid");
								$("#modal_content",top.document).load("process.php?action=show_item&id="+iid,
														 
														 
														 
														 function(){
								$("#overlay",window.parent.document).fadeIn("slow");
								$("#modal",window.parent.document).fadeIn("slow");
																	 });
								
								
								});

});

</script>

<?php	


echo '  <ul id="mycarousel" class="jcarousel-skin-tango">';
	$id=$_GET['answer'];
	$tags=array();
	$sql="SELECT * FROM question3 WHERE answer_id='$id'";

	$result=mysql_query($sql);
	$line=mysql_fetch_array($result);	
	$qid=$line['id'];
	$sql="SELECT * FROM items WHERE question_id='$line[id]'";
	
	$result=mysql_query($sql);
	while($line=mysql_fetch_array($result))	
		{
			$tags23=$line['tags'];
			$arr=explode(",",$tags23);
			$tags=array_merge($tags,$arr);
		}
$arr="";

foreach ($tags as $key=>$value)
	{
		$arr.=" tags LIKE '%$value%' OR ";	
	}
	
$arr=substr_replace($arr ,"",-3);
	$s="SELECT * FROM items WHERE 1 AND ($arr) AND question_id!='$qid' ";

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
    				<td rowspan="2" valign="top">
                    <?php
					$s2="SELECT * FROM images WHERE item_id='$l[id]'";
					$r2=mysql_query($s2) or die(mysql_error());
					$l2=mysql_fetch_array($r2);
					?>
                    <img iid="<?=$l['id']?>" style="cursor:pointer;"  class="item_image" src="img_edit/<?=$l2['image']?>" width="100"></td>
    				<td><font size="1px">
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
                    
                    </font></td>
    				<td> 
					<?php
					if($l3['image'])
					{
						?>
                    <img src="img_edit/<?=$l3['image']?>" width="80px">
                    <?php
					}
					?>
                    </td>
  					</tr>
  				<tr>
    				<td colspan="2"><font size="1px"><?=$l['text']?></font></td>
  				</tr>
                
                </table>
</li>
                
<?php                
	}
	
echo "</ul>";


