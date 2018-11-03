<?php
include ("dbconnect.php");

$sql="SELECT * FROM items WHERE id='$_GET[id]'";

$result=mysql_query($sql);
$line=mysql_fetch_array($result);
$text=$line['text'];
$parent_id=$line['parent_id'];
$s2="SELECT * FROM items WHERE id='$parent_id'";
$r2=mysql_query($s2);
$parent=mysql_fetch_array($r2);
?>
<link href="default.css" rel="stylesheet" type="text/css" />
<style type="text/css">

.carousel-control { cursor:pointer; } 
body,html
{border:0px;
margin:0px;
}

.disabled
	{
		visibility:hidden;
	}

</style>
<script src="jquery.js" type="text/javascript">

</script>
<script type="text/javascript" src="carousel.js"></script>

<script type="text/javascript">
$(document).ready(function(){
$('.mycarousel23').carousel({direction:"vertical"});
$('.mycarousel234').carousel({direction:"vertical"});
});
</script>
<table width="600" border="0">
  <tr>
    <td colspan="4"><strong><?=$line['name']?></strong>&nbsp;</td>
  </tr>
  <tr>
    <td width="127" rowspan="2"><?php
    echo '<div class="mycarousel23"><ul style="list-style:none;">';
    $s2="SELECT * FROM images WHERE item_id='$_GET[id]'";

					$r2=mysql_query($s2) or die(mysql_error());
					while($l2=mysql_fetch_array($r2))
					{
                    ?>
      <ul>
        <li> <img width="80" src="img_edit/<?=$l2['image']?>" /> </li>
      </ul>
    <?php
					}
                    
     echo '</ul></div>';
    ?></td>
    <td width="103"><?=$text?></td>
    <td width="173"><?php
    echo '<div class="mycarousel234"  ><ul>';
    $s2="SELECT * FROM images WHERE item_id='$parent[id]'";
					$r2=mysql_query($s2);
					while($l2=mysql_fetch_array($r2))
					{
                    ?>
      <ul>
        <li > <img width="80" src="img_edit/<?=$l2['image']?>" /> </li>
      </ul>
    <?php
					}
                    
     echo '</ul></div>';
    ?></td>
    <td width="173">&nbsp;
      <?php
	 //campuri custom item
					$s2="SELECT * FROM custom_fields WHERE item_id='$parent[id]' ";
					$r2=mysql_query($s2) or die(mysql_error());
					while($l2=mysql_fetch_array($r2))
						{
					?>
      <?=$l2['name']?>
      :
      <?=$l2['value']?>
      <br />
    <?php	
						}
					?></td>
  </tr>
  <tr>
    <td colspan="3">
      <?php
	 //campuri custom item
					$s2="SELECT * FROM custom_fields WHERE item_id='$_GET[id]' ";
					$r2=mysql_query($s2) or die(mysql_error());
					while($l2=mysql_fetch_array($r2))
						{
					?>
      
      <?=$l2['name']?>:<?=$l2['value']?><br>
      <?php	
						}
					?>
      
    </td>
  </tr>
</table>

<?php

mysql_close();
?>


