<?php
class events
{
 var $mysql;
 
 function events()
   {
     global $mysql;
	 $this->mysql=$mysql;
   }
 
 function events_select($id)
   {
     $sql="select * from events where id='$id'";
     $result=$this->mysql->query($sql);
     $row=$result->fetch();
     return $row;
   }

 function events_select_cat($cat_id)
   {
     $sql="select * from events where events.category_id='$cat_id'";
     $result=$this->mysql->query($sql);		 
     return $result;
   }
   
   
 function events_add($events)
   {
	 $events['description']=addslashes($events['description']);
	 $events['title']=addslashes($events['title']);
	 $sql="insert into events(category_id,client_id, start_date, start_time, end_date, end_time, title, location, description, pdf, html,quicklink) values('$events[category_id]','$events[client_id]','$events[start_date]','$events[start_time]','$events[end_date]','$events[end_time]','$events[title]','$events[location]','$events[description]','$events[pdf]','$events[html]','$events[quicklink]')";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }

 function events_edit($events)
   {
	 $events2=$this->events_select($events['id']);
	 if(file_exists("./../pdfs/$events2[pdf]") && !empty($events2['pdf']))
	   unlink("./../pdfs/$events2[pdf]");
	   
	 if(file_exists("./../html/$events2[html]") && !empty($events2['html']))
	   unlink("./../html/$events2[html]");  
	   
	 $events['description']=addslashes($events['description']);
	 $events['title']=addslashes($events['title']);
	 
	 $sql="update events set category_id='$events[category_id]', events.client_id='$events[client_id]', start_date='$events[start_date]', start_time='$events[start_time]', end_date='$events[end_date]', end_time='$events[end_time]', title='$events[title]', location='$events[location]', description='$events[description]', pdf='$events[pdf]', html='$events[quicklink]', quicklink='$events[quicklink]' where events.id='$events[id]'";
	 
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }
 
 function events_delete($events_id)
   {
     $events=$this->events_select($events_id);
	 if(file_exists("./../pdfs/$events[pdf]") && !empty($events['pdf']))
	   unlink("./../pdfs/$events[pdf]");
	   
	 if(file_exists("./../html/$events[html]") && !empty($events['html']))
	   unlink("./../html/$events[html]");  
	 
	 $sql="delete from events where events.id='$events_id'";
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
		            <a href="events.php?page=$page_back" style="color:black"> << </a>
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
	         if($i!=$page) $pages.="&nbsp;<a href=\"events.php?page=$i\"  style=\"color:black;font-size:13px \">$i</a>";
	         else $pages.="<font color=\"#FFFFFF\" style=\"font-size:13px\">&nbsp;$i</font>";
       
         if(($page*$nr_per_page)<$_SESSION['total'])
	       {
	         $page_next=$page+1;	   
             $pages.=<<<EOD
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		             <a href="events.php?page=$page_next" style="color:black"> >>
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
			    <td  class="listing" valign="middle" width="250">				
				<div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>title</b>', 225)"; onMouseout="hideddrivetip()">&nbsp;
				<font color="black">Title</font>
				&nbsp;
				<a href="events.php?orderby=title"><img src="images/arrow2.png" border="0"></a>
				<a href="events.php?orderby=title&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>category</b>', 225)"; onMouseout="hideddrivetip()"><font color="black">Category</font>                &nbsp;
				<a href="events.php?orderby=category_id"><img src="images/arrow2.png" border="0"></a>
				<a href="events.php?orderby=category_id&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				</td>
				
				
				<td  class="listing" width="100">				
				<div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>date</b>', 225)"; onMouseout="hideddrivetip()"><font color="black">Start Date</font>
				&nbsp;
				<a href="events.php?orderby=start_date"><img src="images/arrow2.png" border="0"></a>
				<a href="events.php?orderby=start_date&dir=desc"><img src="images/arrow1.png" border="0"></a>
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
	    $search=" where events.title like '%".$_SESSION['search']."%' or events.description like '%".$_SESSION['search']."%' "; 
	    
     $sql="select * from events $search $_SESSION[orderby] limit $limit,$nr_per_page ";
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
	    $sql="select * from events_categories where id='$row[category_id]'";
		$cat_result=$mysql->query($sql);
		$category=$cat_result->fetch();
		$category=$category['category'];
		
		$sql="select * from clients where id='$row[client_id]'";
		$client_result=$mysql->query($sql);
		$client=$client_result->fetch();
		$client=$client['name'];
		
		$content.=<<<EOD
		  <tr>
			    <td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('<b>$row[title]</b><br>Client: $client<br>Start Date: $row[start_date]', 225)"; onMouseout="hideddrivetip()">&nbsp;&nbsp; $row[title] &nbsp;&nbsp;</div>				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing">$category</div>				
				</td>
				
				<td  class="listing">				
				<div id="$k" class="listing">$row[start_date]</div>				
				</td>
				
				
                <td width="20" class="listing"></td>
						
		        <td class="listing" align="center">
				<div id="edit$k" class="listing" onMouseover="ddrivetip('Click to edit <b>$row[title]</b>', 175)"; onMouseout="hideddrivetip()"><a href="events_edit.php?id=$row[id]" class="list_links"><img src="images/edit.gif" border="0"></a></div>
				</td>
				
				<td width="5" class="listing"></td>	
					
                <td class="listing" align="center"><div id="delete$k" class="listing" onMouseover="ddrivetip('Click to delete <b>$row[title]</b>', 175)"; onMouseout="hideddrivetip()"><a href="#" onclick="redirect('$row[title]','$row[id]'); return false;" class="edit_links"><img src="images/delete.gif" border="0"></a></div></td>
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