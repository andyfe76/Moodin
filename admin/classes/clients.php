<?php
class clients
{
 var $mysql;
 
 function clients()
   {
     global $mysql;
	 $this->mysql=$mysql;
   }
 
 function clients_select($id)
   {
     $sql="select * from clients where id='$id'";
     $result=$this->mysql->query($sql);
     $row=$result->fetch();
     return $row;
   }

 function clients_select_cat($cat_id)
   {
     $sql="select * from clients where clients.category_id='$cat_id'";
     $result=$this->mysql->query($sql);		 
     return $result;
   }
   
   
 function clients_add($clients)
   {
	 
	 $sql="insert into clients(category_id,name, image, description, address, notes) values('$clients[category_id]','$clients[name]','$clients[image]','$clients[description]','$clients[address]','$clients[notes]')";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }

 function clients_edit($clients)
   {
	 if(!empty($clients['image']))	 
	   $sql="update clients set category_id='$clients[category_id]', clients.name='$clients[name]', image='$clients[image]', description='$clients[description]', address='$clients[address]', notes='$clients[notes]' where clients.id='$clients[id]'";
	 
	 else
	   $sql="update clients set category_id='$clients[category_id]', clients.name='$clients[name]', description='$clients[description]', address='$clients[address]', notes='$clients[notes]' where clients.id='$clients[id]'";  
	 
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }
 
 function clients_delete($clients_id)
   {
     $sql="delete from clients where clients.id='$clients_id'";
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
		            <a href="clients.php?page=$page_back" style="color:black"> << </a>
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
	         if($i!=$page) $pages.="&nbsp;<a href=\"clients.php?page=$i\"  style=\"color:black;font-size:13px \">$i</a>";
	         else $pages.="<font color=\"#FFFFFF\" style=\"font-size:13px\">&nbsp;$i</font>";
       
         if(($page*$nr_per_page)<$_SESSION['total'])
	       {
	         $page_next=$page+1;	   
             $pages.=<<<EOD
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		             <a href="clients.php?page=$page_next" style="color:black"> >>
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
				<font color="black">Clients</font>
				&nbsp;
				<a href="clients.php?orderby=name"><img src="images/arrow2.png" border="0"></a>
				<a href="clients.php?orderby=name&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>category</b>', 225)"; onMouseout="hideddrivetip()"><font color="black">Category</font>                &nbsp;
				<a href="clients.php?orderby=category_id"><img src="images/arrow2.png" border="0"></a>
				<a href="clients.php?orderby=category_id&dir=desc"><img src="images/arrow1.png" border="0"></a>
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
	    $search=" where clients.name like '%".$_SESSION['search']."%' or clients.description like '%".$_SESSION['search']."%' "; 
	    
     $sql="select * from clients $search $_SESSION[orderby] limit $limit,$nr_per_page ";
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
	    $sql="select * from clients_categories where id='$row[category_id]'";
		$cat_result=$mysql->query($sql);
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
				<div id="edit$k" class="listing" onMouseover="ddrivetip('Click to edit <b>$row[name]</b>', 175)"; onMouseout="hideddrivetip()"><a href="clients_edit.php?id=$row[id]" class="list_links"><img src="images/edit.gif" border="0"></a></div>
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