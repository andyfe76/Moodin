<?php
include ("classes.php");

//VIEW NEW SUBSCRIPTIONS PAGE
//page variables
$page_name="users.php";
$page_title="Users";
$page_table="users";
//end page varaiables
$action=$_GET['action'];
$action();



//start view function
function view()
{
global $page_name;
global $page_title;
global $page_table;
?>
<?php
add_header("");
?>
<table class="adminheading">
  <tbody>
    <tr>
      <th width="58" class="edit"><?=$page_title?></th>
      <th width="70" class="edit"><a href="<?=$page_name?>?action=add"></a></th>
      <th width="347" class="edit"><a href="<?=$page_name?>?action=add"></a></th>
    </tr>
  </tbody>
</table>
<table   class="adminlist"  align="center" cellspacing="0" width="100%">
        <tbody>
    
          <tr>
            <th align="center"  valign="middle" ><span >ID</span></th>
            <th  align="center"  valign="middle" >Name</th>
            <th  align="center" >Contest</th>
            <th  align="center" >Edit</th>
          </tr>
<?php
$sql="SELECT * FROM ".$page_table." WHERE 1";
//echo $sql;
$result=mysql_query($sql);
$i=1;
while($line=mysql_fetch_array($result))
{
$i++;
$i=$i%2;
?>
		  <tr class="row<?=$i?>">
            <td ><div align="center">
              <?=$line['id']?>
            </div></td>
            <td align="center" ><div  id="search_key"  ><a href='user_details.php?id=<?=$line['id']?>' ></a>
              <?=$line['name']?>
            </div></td>
            <td align="center" valign="middle"  ><div  id="search_key2"  ><a href='user_details.php?id=<?=$line['id']?>' ></a>
              <?php
			  $s="SELECT * FROM contests WHERE id='$line[contest_id]'";
			  $r=mysql_query($s);
			  $l=mysql_fetch_array($r);
			  echo $l['name'];
			  ?>
            </div></td>
            <td  ><div align="center" id="search_key"  ><a href="<?=$page_name?>?action=edit&id=<?=$line['id']?>&comp_id=<?=$_GET['comp_id']?>" class="righttext"><img src="images/edit_f2.png" width="32" height="32" border="0"></a></div></td>
          </tr>        
		  
<?php
}
?>		  
        </tbody>
      </table>
<?php
add_footer();
?>
<?php
}
//end function VIEW
// start edit function
function edit()
{
global $page_name;
global $page_title;
global $page_table;
?>
<?php
ini_set(display_errors,1);
$sql="SELECT * FROM settings WHERE id='1'";
$result=mysql_query($sql);
$settings=mysql_fetch_array($result);
$id=$_GET['id'];
$sql="SELECT * FROM ".$page_table." WHERE id='$id'";
$result=mysql_query($sql);
$line=mysql_fetch_array($result);

if(!$_POST['Submit'])
{
add_header("expert");
?>


 
	<form action="<?=$page_name?>?action=edit&id=<?=$id?>" name="form1" method="post" enctype="multipart/form-data" >
	  <table width="100%">
        <tr>
          <td width="200"><table class="adminheading">
              <tr>
                <td style="width:20px;" ><img align="right" src="images/edit_f2.png" />
                    </th>
                </td>
                <td class="edit"><?=$page_title?> : <small> Edit </small>
                </td>
              </tr>
          </table></td>
          <td width="773"><table border="0" align="right" cellpadding="0" cellspacing="0" id="toolbar">
              <tr valign="middle" align="center">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><a class="toolbar" href="#" onClick="document.getElementById('Submit').click();"><img src="images/save_f2.png"  alt="Save" name="save" border="0" align="middle" id="save" title="Save" /><br />
                  Save</a> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><a class="toolbar" href="javascript:submitbutton('cancel');"> <img src="images/cancel_f2.png"  alt="Cancel" name="cancel" border="0" align="middle" id="cancel" title="Cancel" /> <br />
                  Cancel</a> </td>
                <td>&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table
>
	  <table width="500" border="0" cellspacing="10" cellpadding="0" class="adminform">
                          <tr>
                            <td width="159" height="22" align="left" class="heading2">First Name:</td>
                            <td width="311" align="left"><label>
                              <input name="form[fname]" type="text" id="form[fname]" value="<?=$line['fname']?>">
                            </label></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Last Name:</td>
                            <td align="left"><input name="form[lname]" type="text" id="form[lname]" value="<?=$line['lname']?>" /></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Email:</td>
                            <td align="left"><input name="form[email]" type="text" id="form[email]" value="<?=$line['email']?>" /></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Phone:</td>
                            <td align="left"><input name="form[price]" type="text" id="form[price]" value="<?=$line['price']?>" /></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">User:</td>
                            <td align="left"><input name="form[user]" type="text" id="form[user]" value="<?=$line['user']?>" /></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Pass:</td>
                            <td align="left"><input type="text" /></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Admin User</td>
                            <td align="left"><label>
                              <select name="form[admin]" id="form[admin]">
                                <option value="1">YES</option>
                                <option value="0" selected="selected">NO</option>
                              </select>
                            </label></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">&nbsp;</td>
                            <td align="left"><input name="form[comp_id]" type="hidden" id="form[comp_id]" value="<?=$_GET['comp_id']?>" /></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">&nbsp;</td>
                            <td align="left">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" class="heading2">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" class="heading2"><label>
                              <input type="submit" name="Submit" id="Submit" style="visibility:hidden;" value="Submit" />
                              </label>                          </td>
                          </tr>
      </table>
	
	
</form>

<?php
}
else
{
	$id=$_GET['id'];
	$form=$_POST['form'];
	$image=$_FILES['fileField'];
$upload=new upload("../img_edit/");
$thumbs[1]['height']=0;
$thumbs[1]['width']=882;


$image=$upload->upload_image($image,$thumbs);


if($image)
	$form['image']=$image;
	$ovi=new manager;
	$ovi->set_table($page_table);
	$ovi->db_modify($form,$id);
	header("Location: ".$page_name."?id=$id&action=edit&comp_id=$_GET[comp_id]");
	exit();


}

add_footer();
?>


<?php
}
//end edit function
//start add function
function add()
{
global $page_name;
global $page_title;
global $page_table;
?>
<?php
$sql="SELECT * FROM settings WHERE id='1'";
$result=mysql_query($sql);
$settings=mysql_fetch_array($result);
if(!$_POST['Submit'])
{
add_header("expert");
?>
 <link rel="stylesheet" href="http://www.zapatec.com/website/main/../ajax/zpcal/themes/system.css" />
 <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/../utils/zapatec.js"></script>
 <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/src/calendar.js"></script>
 <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/lang/calendar-en.js"></script>
	<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<form action="<?=$page_name?>?action=add&comp_id=<?=$_GET['comp_id']?>" name="form1" method="post" enctype="multipart/form-data" >
	  <table width="100%">
        <tr>
          <td width="200"><table class="adminheading">
              <tr>
                <td style="width:20px;" ><img align="right" src="images/edit_f2.png" />
                    </th>
                </td>
                <td class="edit"><?=$page_title?> 
                  : <small> Add </small>
                    </th>
                </td>
              </tr>
          </table></td>
          <td width="773"><table border="0" align="right" cellpadding="0" cellspacing="0" id="toolbar">
              <tr valign="middle" align="center">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><a class="toolbar" href="#" onClick="document.getElementById('Submit').click();"><img src="images/save_f2.png"  alt="Save" name="save" border="0" align="middle" id="save" title="Save" /><br />
                  Save</a> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><a class="toolbar" href="javascript:submitbutton('cancel');"> <img src="images/cancel_f2.png"  alt="Cancel" name="cancel" border="0" align="middle" id="cancel" title="Cancel" /> <br />
                  Cancel</a> </td>
                <td>&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table
>
	  <table width="500" border="0" cellspacing="10" cellpadding="0" class="adminform">
	    <tr>
	      <td width="159" height="22" align="left" class="heading2">First Name:</td>
	      <td width="311" align="left"><label>
	        <input name="form[fname]" type="text" id="form[fname]" value="<?=$line['fname']?>" />
	        </label></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Last Name:</td>
	      <td align="left"><input name="form[lname]" type="text" id="form[lname]" value="<?=$line['lname']?>" /></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Email:</td>
	      <td align="left"><input name="form[email]" type="text" id="form[email]" value="<?=$line['email']?>" /></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Phone:</td>
	      <td align="left"><input name="form[price]" type="text" id="form[price]" value="<?=$line['price']?>" /></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">User:</td>
	      <td align="left"><input name="form[user]" type="text" id="form[user]" value="<?=$line['user']?>" /></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Pass:</td>
	      <td align="left"><input type="text" /></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Admin User</td>
	      <td align="left"><label>
	        <select name="form[admin]" id="form[admin]">
	          <option value="1" <?php if($line['admin']) echo "selected"; ?>>YES</option>
	          <option value="0" <?php if($line['admin']) echo "selected"; ?>>NO</option>
            </select>
	        </label></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">&nbsp;</td>
	      <td align="left"><input name="form[comp_id]" type="hidden" id="form[comp_id]" value="<?=$_GET['comp_id']?>" /></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">&nbsp;</td>
	      <td align="left">&nbsp;</td>
        </tr>
	    <tr>
	      <td colspan="2" align="left" class="heading2">&nbsp;</td>
        </tr>
	    <tr>
	      <td colspan="2" align="left" class="heading2"><label>
	        <input type="submit" name="Submit" id="Submit" style="visibility:hidden;" value="Submit" />
	        </label></td>
        </tr>
  </table>
</form>

<?php
}
else
{
	$form=$_POST['form'];
	$image=$_FILES['fileField'];
$upload=new upload("../img_edit/");
$thumbs[1]['height']=0;
$thumbs[1]['width']=882;


$image=$upload->upload_image($image,$thumbs);


if($image)
	$form['image']=$image;
	$man= new manager;
	$man->set_table($page_table);
	$man->db_insert($form);
	header("Location: $page_name?action=view");
?>
<?php

}

add_footer();
?>


<?php
}
//end add function 
//start delete function
function delete()
{
global $page_name;
global $page_title;
global $page_table;
?>
<?php

$id=$_GET['id'];
$sql="DELETE FROM $page_table WHERE id='$id'";
mysql_query($sql);

mysql_query($sql);
header ("Location: $page_name?action=view&comp_id=$_GET[comp_id]");


}

?>