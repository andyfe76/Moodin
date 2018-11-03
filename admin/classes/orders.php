<?php
class orders
{
 var $mysql;
 
 function orders()
   {
     global $mysql;
	 $this->mysql=$mysql;
   }
 
 function orders_select($id)
   {
     $sql="select * from orders where id='$id'";
     $result=$this->mysql->query($sql);
     $row=$result->fetch();
     return $row;
   }

 function orders_select_cat($cat_id)
   {
     $sql="select * from orders where orders.cat_id='$cat_id'";
     $result=$this->mysql->query($sql);		 
     return $result;
   }
   
   
 function orders_add($orders)
   {
		$part1="";
		$part2="";
			foreach($orders as $key=>$value)
				{
				$part1.="$key,";
				$part2.="'$value',";
				}
		$part1 = substr_replace($part1,"",-1);
		$part2 = substr_replace($part2,"",-1);
    	$sql="INSERT into orders ($part1) VALUES ($part2)";
		
	 
     $result=$this->mysql->query($sql);
    return mysql_insert_id();
	}

 function orders_edit($orders)
   {
   
	 $tbl=$this->table;
	 $id=$orders['id'];
		$part1="";
			foreach($orders as $key=>$value)
			{
			if($key!='id')
				$part1.="`$key`='$value',";
			}
		$part1 = substr_replace($part1,"",-1);
    	$sql="UPDATE orders SET $part1 where id='$id'";
		//echo $sql;
	 
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }
 
 function orders_delete($orders_id)
   {	 
	 $sql="delete from orders where orders.id='$orders_id'";
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
		            <a href="orders.php?page=$page_back" style="color:black"> << </a>
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
	         if($i!=$page) $pages.="&nbsp;<a href=\"orders.php?page=$i\"  style=\"color:black;font-size:13px \">$i</a>";
	         else $pages.="<font color=\"#ff0066\" style=\"font-size:13px\">&nbsp;$i</font>";
       
         if(($page*$nr_per_page)<$_SESSION['total'])
	       {
	         $page_next=$page+1;	   
             $pages.=<<<EOD
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		             <a href="orders.php?page=$page_next" style="color:black"> >>
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
				<font color="black">Order amount</font>
				&nbsp;
				<a href="orders.php?orderby=name"><img src="images/arrow2.png" border="0"></a>
				<a href="orders.php?orderby=name&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>date</b>', 225)"; onMouseout="hideddrivetip()"><font color="black">Date</font>                &nbsp;
				<a href="orders.php?orderby=timestamp"><img src="images/arrow2.png" border="0"></a>
				<a href="orders.php?orderby=timestamp&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				</td>
									
				
                <td width="20" class="listing"></td>
						
		        <td class="listing" align="center"><font color="black">EDIT</font></td>
				
				<td width="5" class="listing"></td>	
					
                <td class="listing" align="center"><font color="black">DELETE</font></td>
				<td width="5" class="listing"></td>	
					
                <td class="listing" align="center"><font color="black">FULFILLED</font></td>
          
		  </tr>
		  
EOD;
	 
	 $limit=($page-1)*$nr_per_page; 
	 $ii=$limit+1;
	 $page++;    
	 	   
	 if(!empty($_SESSION['search']))
	    $search=" where orders.name like '%".$_SESSION['search']."%' or orders.descr like '%".$_SESSION['search']."%' "; 
	    
     $sql="select * from orders $search $_SESSION[orderby] limit $limit,$nr_per_page ";
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
	   $sql="SELECT * FROM ord_products WHERE order_id='{$row['id']}'";
	   $res=mysql_query($sql);
	   while($product=mysql_fetch_array($res))
	   		{
			
			
			}
		if($row['status'])
		$order_status="<td class=\"listing\" align=\"center\"><div id=\"delete$k\" class=\"listing\" onMouseover=\"ddrivetip('Click to mark as unfulfilled <b>$row[name]</b>', 175)\"; onMouseout=\"hideddrivetip()\"><a href=\"orders_status.php?id=$row[id]\"  class=\"edit_links\">YES</div></td>";
		else
		$order_status="<td class=\"listing\" align=\"center\"><div id=\"delete$k\" class=\"listing\" onMouseover=\"ddrivetip('Click to mark as fulfilled <b>$row[name]</b>', 175)\"; onMouseout=\"hideddrivetip()\"><a href=\"orders_status.php?id=$row[id]\"  class=\"edit_links\">NO</div></td>";

		$time=date("M/d/Y h:m:s",$row['timestamp']);
		$content.=<<<EOD
		  <tr>
			    <td  class="listing">				
				  $row[id]				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('<b>$row[title]</b><br>Client: $row[name]<br>Category: $category', 225)"; onMouseout="hideddrivetip()">&nbsp;&nbsp; $row[name] &nbsp;&nbsp;</div>				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing">$time</div>				
				</td>
									
				
                <td width="20" class="listing"></td>
						
		        <td class="listing" align="center">
				<div id="edit$k" class="listing" onMouseover="ddrivetip('Click to edit <b>$row[name]</b>', 175)"; onMouseout="hideddrivetip()"><a href="orders_edit.php?id=$row[id]" class="list_links"><img src="images/edit.gif" border="0"></a></div>
				</td>
				
				
				<td width="5" class="listing"></td>	
					
                <td class="listing" align="center"><div id="delete$k" class="listing" onMouseover="ddrivetip('Click to delete <b>$row[name]</b>', 175)"; onMouseout="hideddrivetip()"><a href="#" onclick="redirect('$row[name]','$row[id]'); return false;" class="edit_links"><img src="images/delete.gif" border="0"></a></div></td>
          <td class="listing" align="center"><font color="black">&nbsp;</font></td>
$order_status		 
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