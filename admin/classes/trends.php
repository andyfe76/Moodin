<?php
class trends
{
 var $mysql;
 
 function trends()
   {
     global $mysql;
	 $this->mysql=$mysql;
   }
 
 function trends_select($id)
   {
     $sql="select * from trends where id='$id'";
     $result=$this->mysql->query($sql);
     $row=$result->fetch();
     return $row;
   }

  
 function trends_add($trends)
   {
	 
	 $sql="insert into trends(trend,meta) values('$trends[trend]','$trends[meta]')";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }

 function trends_edit($trends)
   {
   $id=$trends['id'];
		$part1="";
			foreach($trends as $key=>$value)
			{
			if($key!='id')
				$part1.="`$key`='$value',";
			}
		$part1 = substr_replace($part1,"",-1);
    	$sql="UPDATE trends SET $part1 where id='$id'";
		//echo $sql;
	 
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }
 
 function trends_delete($trends_id)
   {
     $sql="delete from trends where trends.id='$trends_id'";
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
		            <a href="trends.php?page=$page_back" style="color:black"> << </a>
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
	         if($i!=$page) $pages.="&nbsp;<a href=\"trends.php?page=$i\"  style=\"color:black;font-size:13px \">$i</a>";
	         else $pages.="<font color=\"#FFFFFF\" style=\"font-size:13px\">&nbsp;$i</font>";
       
         if(($page*$nr_per_page)<$_SESSION['total'])
	       {
	         $page_next=$page+1;	   
             $pages.=<<<EOD
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		             <a href="trends.php?page=$page_next" style="color:black"> >>
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
	    $search=" where trends.trend like '%".$_SESSION['search']."%' "; 
	    
     $sql="select * from trends $search limit $limit,$nr_per_page";
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
				<div id="$k" class="listing" onMouseover="ddrivetip('<b>$row[trend]</b>', 225)"; onMouseout="hideddrivetip()">&nbsp;&nbsp; $row[trend] &nbsp;&nbsp;</div>				
				</td>
				
				
				
                <td width="20" class="listing"></td>
						
		        <td class="listing" align="center">
				<div id="edit$k" class="listing" onMouseover="ddrivetip('Click to edit <b>$row[trend]</b>', 175)"; onMouseout="hideddrivetip()"><a href="trends_edit.php?id=$row[id]" class="list_links"><img src="images/edit.gif" border="0"></a></div>
				</td>
				
				<td width="5" class="listing"></td>	
					
                <td class="listing" align="center"><div id="delete$k" class="listing" onMouseover="ddrivetip('Click to delete <b>$row[trend]</b>', 175)"; onMouseout="hideddrivetip()"><a href="#" onclick="redirect('$row[trend]','$row[id]'); return false;" class="edit_links"><img src="images/delete.gif" border="0"></a></div></td>
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