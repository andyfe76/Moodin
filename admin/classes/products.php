<?php
class products
{
 var $mysql;
 
 function products()
   {
     global $mysql;
	 $this->mysql=$mysql;
   }
 
 function products_select($id)
   {
     $sql="select * from products where id='$id'";
     $result=$this->mysql->query($sql);
     $row=$result->fetch();
     return $row;
   }

 function products_select_cat($cat_id)
   {
     $sql="select * from products where products.cat_id='$cat_id'";
     $result=$this->mysql->query($sql);		 
     return $result;
   }
   
   
 function products_add($products)
   {
		$part1="";
		$part2="";
			foreach($products as $key=>$value)
				{
				$part1.="$key,";
				$part2.="'$value',";
				}
		$part1 = substr_replace($part1,"",-1);
		$part2 = substr_replace($part2,"",-1);
    	$sql="INSERT into products ($part1) VALUES ($part2)";
		
	 
     $result=$this->mysql->query($sql);
    return mysql_insert_id();
	}

 function products_edit($products)
   {
   
	 $tbl=$this->table;
	 $id=$products['id'];
		$part1="";
			foreach($products as $key=>$value)
			{
			if($key!='id')
				$part1.="`$key`='$value',";
			}
		$part1 = substr_replace($part1,"",-1);
    	$sql="UPDATE products SET $part1 where id='$id'";
		//echo $sql;
	 
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }
 
 function products_delete($products_id)
   {	 
	 $sql="delete from products where products.id='$products_id'";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;	
   }  
   
function print_page($page=1,$nr_per_page=30)
   {
     global $mysql;
	 
	 $content="";
	 
	 
	 if($_SESSION['total']>$nr_per_page)
	   {
         $pages=<<<EOD
          <tr> 
	        <td align="center" colspan="5">  		      
EOD;
         if($page>=2)
	       { 
	         $page_back=$page-1;
		     $pages.=<<<EOD
		            <a href="products.php?page=$page_back" style="color:black"> << </a>
			        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
EOD;
            }
       
	     $start=$page-9;
	     $end=$page+9;
	     $total_pages=((int)($_SESSION['total']/$nr_per_page)+1);  
		 if($_SESSION['total']%$nr_per_page==0) $total_pages--;  //k sa nu apara de ex pag 3 fara agentii
	     if(($total_pages-$page)<9)
	       {
	         $start=$total_pages-18;
			 if($start<1) $start=1;
		     $end=$total_pages;
	       } 
	   
	     if($page<10)
	       { 
	         $start=1;
		     $end=9+$page;		
	       } 	 
	 	
         for($i=$start;$i<=$total_pages&&$i<=$end;$i++)
	         if($i!=$page) $pages.="&nbsp;<a href=\"products.php?page=$i\"  style=\"color:black;font-size:13px \">$i</a>";
	         else $pages.="<font color=\"#ff0066\" style=\"font-size:13px\">&nbsp;$i</font>";
       
         if(($page*$nr_per_page)<$_SESSION['total'])
	       {
	         $page_next=$page+1;	   
             $pages.=<<<EOD
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		             <a href="products.php?page=$page_next" style="color:black"> >>
EOD;
           }
         $pages.=<<<EOD

			</td>
	      </tr>
		  
EOD;
       }
	 else
	   {
	      $pages="";
	   }  
	 $content.=$pages; //pun continutul in var $pages pt a o putea reavea la end
	 
     $content.=<<<EOD
		  <tr height="20"><td></td></tr>
		  
		  <tr>
			    <td  class="listing" valign="middle" width="10">
				  <font color="black">ID</font>
				</td>
				<td  class="listing" valign="middle" width="250">
				  <div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>title</b>', 225)"; onMouseout="hideddrivetip()">&nbsp;
				<font color="black">products</font>
				&nbsp;
				<a href="products.php?orderby=name"><img src="images/arrow2.png" border="0"></a>
				<a href="products.php?orderby=name&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>category</b>', 225)"; onMouseout="hideddrivetip()"><font color="black">Category</font>                &nbsp;
				<a href="products.php?orderby=cat_id"><img src="images/arrow2.png" border="0"></a>
				<a href="products.php?orderby=cat_id&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				</td>
									
				
                <td width="20" class="listing"></td>
						
		        <td class="listing" align="center"><font color="black">EDIT</font></td>
				
				<td width="5" class="listing"></td>	
					
                <td class="listing" align="center"><font color="black">DELETE</font></td>
          </tr>
		  
EOD;
	 
	 $limit=($page-1)*$nr_per_page; 
	 $ii=$limit+1;
	 $page++;    
	 	   
	 if(!empty($_SESSION['search']))
	 {
	    $search=" where (products.name like '%".$_SESSION['search']."%' or products.descr like '%".$_SESSION['search']."%') "; 
if($_GET['cat_id'])
{
$s="SELECT * FROM cat_prod WHERE cat_id='$_GET[cat_id]'";
$r=mysql_query($s);
$ids="(";
while($cat=mysql_fetch_array($r))
	{
	$id=$cat['prod_id'];
	$ids.=$id.",";	
	
	}
$length=strlen($ids);
$ids=substr($ids,0,$length-1);
$ids.=")";
//echo $ids;
$s="SELECT * FROM categories WHERE id='$_GET[cat_id]'";
$r=mysql_query($s);
$l=mysql_fetch_array($r);
$cat=$l['category'];
$search.=" AND id in $ids ";

}

else if($_GET['des_id'])
{
$s="SELECT * FROM des_prod WHERE des_id='$_GET[des_id]'";
$r=mysql_query($s);
$ids="(";
while($cat=mysql_fetch_array($r))
	{
	$id=$cat['prod_id'];
	$ids.=$id.",";	
	
	}
$length=strlen($ids);
$ids=substr($ids,0,$length-1);
$ids.=")";
//echo $ids;
$s="SELECT * FROM designers WHERE id='$_GET[designer_id]'";
$r=mysql_query($s);
$l=mysql_fetch_array($r);
$cat=$l['designer'];
$search.=" AND id in $ids ";
}

else if($_GET['trend_id'])
{
$s="SELECT * FROM trend_prod WHERE trend_id='$_GET[trend_id]'";
$r=mysql_query($s);
$ids="(";
while($cat=mysql_fetch_array($r))
	{
	$id=$cat['prod_id'];
	$ids.=$id.",";	
	
	}
$length=strlen($ids);
$ids=substr($ids,0,$length-1);
$ids.=")";
//echo $ids;
$s="SELECT * FROM trends WHERE id='$_GET[trend_id]'";
$r=mysql_query($s);
$l=mysql_fetch_array($r);
$cat=$l['trend'];
$search.=" AND id in $ids ";
}
//echo $sql;

	 }
	 else
	 	{
		$search =" WHERE 1 ";
 	if($_GET['cat_id'])
{
$s="SELECT * FROM cat_prod WHERE cat_id='$_GET[cat_id]'";
$r=mysql_query($s);
$ids="(";
while($cat=mysql_fetch_array($r))
	{
	$id=$cat['prod_id'];
	$ids.=$id.",";	
	
	}
$length=strlen($ids);
$ids=substr($ids,0,$length-1);
$ids.=")";
//echo $ids;
$s="SELECT * FROM categories WHERE id='$_GET[cat_id]'";
$r=mysql_query($s);
$l=mysql_fetch_array($r);
$cat=$l['category'];
$search.=" AND id in $ids";

}

else if($_GET['des_id'])
{
$s="SELECT * FROM des_prod WHERE des_id='$_GET[des_id]'";
$r=mysql_query($s);
$ids="(";
while($cat=mysql_fetch_array($r))
	{
	$id=$cat['prod_id'];
	$ids.=$id.",";	
	
	}
$length=strlen($ids);
$ids=substr($ids,0,$length-1);
$ids.=")";
//echo $ids;
$s="SELECT * FROM designers WHERE id='$_GET[designer_id]'";
$r=mysql_query($s);
$l=mysql_fetch_array($r);
$cat=$l['designer'];
$search.=" AND id in $ids ";
}

else if($_GET['trend_id'])
{
$s="SELECT * FROM trend_prod WHERE trend_id='$_GET[trend_id]'";
$r=mysql_query($s);
$ids="(";
while($cat=mysql_fetch_array($r))
	{
	$id=$cat['prod_id'];
	$ids.=$id.",";	
	
	}
$length=strlen($ids);
$ids=substr($ids,0,$length-1);
$ids.=")";
//echo $ids;
$s="SELECT * FROM trends WHERE id='$_GET[trend_id]'";
$r=mysql_query($s);
$l=mysql_fetch_array($r);
$cat=$l['trend'];
$search.=" AND id in $ids ";
}
//echo $sql;

		
		}
	
     $sql="select * from products $search $_SESSION[orderby] limit $limit,$nr_per_page ";
   // echo $sql;
	 $result=$this->mysql->query($sql);
	  if(!$result->size()) 
	   { $content=<<<EOD
	      <tr>
		    <td class="listing" style="font-size:15px" align="center" valign="middle" height="200">
			  No results.
			</td>
	      </tr>
EOD;
	     return $content;
	   }
	   $k=1;
     while($row=$result->fetch())
	 {
	    $sql="select * from categories where id='$row[cat_id]'";
		$cat_result=$this->mysql->query($sql);
		$category=$cat_result->fetch();
		$category=$category['category'];
		
		$content.=<<<EOD
		  <tr>
			    <td  class="listing">				
				  $row[id]				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('<b>$row[title]</b><br>Client: $row[name]<br>Category: $category', 225)"; onMouseout="hideddrivetip()">&nbsp;&nbsp; $row[name] &nbsp;&nbsp;</div>				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing">$category</div>				
				</td>
									
				
                <td width="20" class="listing"></td>
						
		        <td class="listing" align="center">
				<div id="edit$k" class="listing" onMouseover="ddrivetip('Click to edit <b>$row[name]</b>', 175)"; onMouseout="hideddrivetip()"><a href="products_edit.php?id=$row[id]" class="list_links"><img src="images/edit.gif" border="0"></a></div>
				</td>
				
				<td width="5" class="listing"></td>	
					
                <td class="listing" align="center"><div id="delete$k" class="listing" onMouseover="ddrivetip('Click to delete <b>$row[name]</b>', 175)"; onMouseout="hideddrivetip()"><a href="#" onclick="redirect('$row[name]','$row[id]'); return false;" class="edit_links"><img src="images/delete.gif" border="0"></a></div></td>
          </tr>
EOD;
       $ii++;$k++;
	 }

	 $content.=$pages; 
	 $content.=<<<EOD
			</td>
	      </tr>
EOD;
	 return $content;
   }  
    
      
} 
?>