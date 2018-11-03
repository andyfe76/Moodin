<?php
class state_taxes
{
 var $mysql;
 
 function state_taxes()
   {
     global $mysql;
	 $this->mysql=$mysql;
   }
 
 function state_taxes_select_all()
   {
   
     $sql="select * from state_taxes order by state";
     $result=$this->mysql->query($sql);

     return $result;
   } 
 
 
 function state_taxes_select($id)
   {
     $sql="select * from state_taxes where id='$id'";
     $result=$this->mysql->query($sql);
     $row=$result->fetch();
     return $row;
   }

  
 function state_taxes_add($state_taxes)
   {
	 
	 $sql="insert into state_taxes(state,tax) values('$state_taxes[state]','$state_taxes[tax]')";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }

 function state_taxes_edit($state_taxes)
   {
     if(empty($state_taxes['parent_id']))
	   $state_taxes['parent_id']=0;
   
	 $sql="update state_taxes set state_taxes.state='$state_taxes[state]',state_taxes.tax='$state_taxes[tax]' where state_taxes.id='$state_taxes[id]'";
	 
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }
 
 function state_taxes_delete($state_taxes_id)
   {
     $sql="delete from state_taxes where state_taxes.id='$state_taxes_id'";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;	
   }  
   
function print_page($page=1,$nr_per_page=30,$parent_id)
   {
     global $mysql;
	 
	 if(empty($parent_id))
	   $parent_id=0;
	 
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
		            <a href="state_taxes.php?page=$page_back" style="color:black"> << </a>
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
	         if($i!=$page) $pages.="&nbsp;<a href=\"state_taxes.php?page=$i\"  style=\"color:black;font-size:13px \">$i</a>";
	         else $pages.="<font color=\"#FFFFFF\" style=\"font-size:13px\">&nbsp;$i</font>";
       
         if(($page*$nr_per_page)<$_SESSION['total'])
	       {
	         $page_next=$page+1;	   
             $pages.=<<<EOD
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		             <a href="state_taxes.php?page=$page_next" style="color:black"> >>
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
		  
EOD;
	 
	 $limit=($page-1)*$nr_per_page; 
	 $ii=$limit+1;
	 $page++;    
	 	   
	 if(!empty($_SESSION['search']))
	    $search=" where state_taxes.state like '%".$_SESSION['search']."%' "; 
	  

	    
     $sql="select * from state_taxes $search limit $limit,$nr_per_page";
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

	 
	    $content.=<<<EOD
		  <tr>
			    <td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('<b>$row[state]</b>', 225)"; onMouseout="hideddrivetip()">&nbsp;&nbsp; $row[state] &nbsp;&nbsp;</div>					
				</td>			
                <td width="20" class="listing"></td>
				
				<td  class="listing">				
				  &nbsp;&nbsp; $row[tax] &nbsp;&nbsp;					
				</td>			
                <td width="20" class="listing"></td>
						
		        <td class="listing" align="center">
				<div id="edit$k" class="listing" onMouseover="ddrivetip('Click to edit <b>$row[tax]</b>', 175)"; onMouseout="hideddrivetip()"><a href="state_taxes_edit.php?id=$row[id]" class="list_links"><img src="images/edit.gif" border="0"></a></div>
				</td>
				
				<td width="5" class="listing"></td>	
					
                <td class="listing" align="center"><div id="delete$k" class="listing" onMouseover="ddrivetip('Click to delete <b>$row[state]</b>', 175)"; onMouseout="hideddrivetip()"><a href="#" onclick="redirect('$row[state]','$row[id]'); return false;" class="edit_links"><img src="images/delete.gif" border="0"></a></div></td>
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