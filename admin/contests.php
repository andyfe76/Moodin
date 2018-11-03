<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

include ("classes.php");

//VIEW NEW SUBSCRIPTIONS PAGE
//page variables
$page_name="contests.php";
$page_title="Cotnests";
$page_table="contests";
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
<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>Contests</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">Table</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#tab2">Forms</a></li>
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
					  <table>
							
			  <thead>
								<tr>
								   <th><input class="check-all" type="checkbox" /></th>
								   <th>Id</th>
								   <th>Name</th>
								   <th>Prize</th>
								   <th>Description</th>
								   <th>Actions</th>
								</tr>
								
							</thead>
			  <tbody>
              
<?php
$sql="SELECT * FROM contests WHERE 1";
$result=mysql_query($sql) or die(mysql_error());
while($line=mysql_fetch_array($result))
{
	
	?>
  <tr>
									<td><input type="checkbox" /></td>
									<td><?php echo $line['id'];?></td>
									<td><?php echo $line['name'];?></td>
									<td><?php echo $line['prize'];?></td>
									<td><?php echo $line['descr'];?></td>
									<td>
										<!-- Icons -->
										 <a href="#" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
										 <a href="#" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
										 <a href="#" title="Edit Meta"><img src="resources/images/icons/hammer_screwdriver.png" alt="Edit Meta" /></a>
									</td>
								</tr>
                                
<?php
}
?>
							</tbody>
							
						</table>
						
					</div> 
					<!-- End #tab1 --><!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div>
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
                            <td width="159" height="22" align="left" class="heading2">Name</td>
                            <td width="311" align="left"><label>
                              <input name="form[name]" type="text" id="form[name]" value="<?=$line['name']?>">
                            </label></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Description</td>
                            <td align="left"><textarea name="form[descr]" id="form[descr]"><?=$line['descr']?></textarea></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">The task</td>
                            <td align="left"><textarea name="form[task]" id="form[task]"><?=$line['task']?></textarea></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Prize</td>
                            <td align="left"><textarea name="form[prize]" id="form[prize]"><?=$line['prize']?></textarea></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Merchant:</td>
                            <td align="left"><input name="form[merch]" type="text" id="form[merch]" value="<?=$line['merch']?>" /></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Facebook URL</td>
                            <td align="left"><input name="form[fb_url]" type="text" id="form[fb_url]" value="<?=$line['fb_url']?>" /></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Twitter Url</td>
                            <td align="left"><input name="form[twt_url]" type="text" id="form[twt_url]" value="<?=$line['twt_url']?>" /></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Image</td>
                            <td align="left"><label>
                              <input type="file" name="fileField" id="fileField" />
                            </label></td>
                          </tr>
                          <tr>
                            <td align="left" class="heading2">Submission Type:</td>
                            <td align="left"><label>
                              <select name="form[type]" id="form[type]">
                                <option value="text">Text</option>
                                <option value="link">Link</option>
                                <option value="image">Image</option>
                              </select>
                            </label></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" class="heading2">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" class="heading2"><label>
                              <input type="submit" name="Submit" id="Submit" value="Submit" />
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
	header("Location: ".$page_name."?action=view");
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

if(!$_POST['Submit'])
{
add_header("expert");
?>
 <link rel="stylesheet" href="http://www.zapatec.com/website/main/../ajax/zpcal/themes/system.css" />
 <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/../utils/zapatec.js"></script>
 <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/src/calendar.js"></script>
 <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/lang/calendar-en.js"></script>
	<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<form action="<?=$page_name?>?action=add" name="form1" method="post" enctype="multipart/form-data" >
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
	      <td width="159" height="22" align="left" class="heading2">Name</td>
	      <td width="311" align="left"><label>
	        <input name="form[name]" type="text" id="form[name]" value="<?=$line['name']?>" />
          </label></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Description</td>
	      <td align="left"><textarea name="form[descr]" id="form[descr]2"><?=$line['descr']?></textarea></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">The task</td>
	      <td align="left"><textarea name="form[task]" id="form[price]2"><?=$line['task']?></textarea></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Prize</td>
	      <td align="left"><textarea name="form[prize]" id="form[prize]2"><?=$line['prize']?></textarea></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Merchant:</td>
	      <td align="left"><input name="form[merch]" type="text" id="form[merch]2" value="<?=$line['merch']?>" /></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Facebook URL</td>
	      <td align="left"><input name="form[fb_url]" type="text" id="form[fb_url]2" value="<?=$line['fb_url']?>" /></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Twitter Url</td>
	      <td align="left"><input name="form[twt_url]" type="text" id="form[twt_url]2" value="<?=$line['twt_url']?>" /></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Prize Image</td>
	      <td align="left"><label>
	        <input type="file" name="fileField" id="fileField2" />
	        </label></td>
        </tr>
	    <tr>
	      <td align="left" class="heading2">Submission Type:</td>
	      <td align="left"><label>
	        <select name="form[type]" id="form[type]">
	          <option value="text">Text</option>
	          <option value="link">Link</option>
	          <option value="image">Image</option>
            </select>
          </label></td>
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
	        <input type="submit" name="Submit" id="Submit2" value="Submit" />
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
$thumbs[1]['width']=300;


$image=$upload->upload_image($image,$thumbs);


if($image)
	$form['image']=$image;
	$man= new manager;
	$man->set_table($page_table);
	$man->db_insert($form);
	?>
    <script type="text/javascript">
	document.location="contests.php?action=view";
	</script>
<?php
	exit(0);
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