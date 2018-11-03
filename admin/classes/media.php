<?php
class media
{
 var $mysql;
 
 function media()
   {
     global $mysql;
	 $this->mysql=$mysql;
   }
 
 function media_select($id)
   {
     $sql="select * from media where id='$id'";
     $result=$this->mysql->query($sql);
     $row=$result->fetch();
     return $row;
   }

 function media_select_cat($cat_id)
   {
     $sql="select * from media where media.category_id='$cat_id'";
     $result=$this->mysql->query($sql);		 
     return $result;
   }
   
   
 function media_add($media)
   {
	 $media['body']=addslashes($media['body']);
	 $media['title']=addslashes($media['title']);
	 $sql="insert into media(category_id,client_id, post_date, title, body, status, pdf, html) values('$media[category_id]','$media[client_id]','$media[post_date]','$media[title]','$media[body]','$media[status]','$media[pdf]','$media[html]')";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }

 function media_edit($media)
   {
	 $media2=$this->media_select($media['id']);
	 if(file_exists("./../pdfs/$media2[pdf]") && !empty($media2['pdf']))
	   unlink("./../pdfs/$media2[pdf]");
	   
	 if(file_exists("./../html/$media2[html]") && !empty($media2['html']))
	   unlink("./../html/$media2[html]");  
	   
	 $media['body']=addslashes($media['body']);  
	 $media['title']=addslashes($media['title']);  
	 
	 $sql="update media set category_id='$media[category_id]', media.client_id='$media[client_id]', post_date='$media[post_date]', title='$media[title]', body='$media[body]', status='$media[status]', pdf='$media[pdf]', html='$media[html]' where media.id='$media[id]'";
	 
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }
 
 function media_delete($media_id)
   {
     $media=$this->media_select($media_id);
	 if(file_exists("./../pdfs/$media[pdf]") && !empty($media['pdf']))
	   unlink("./../pdfs/$media[pdf]");
	   
	 if(file_exists("./../html/$media[html]") && !empty($media['html']))
	   unlink("./../html/$media[html]");  
	 
	 $sql="delete from media where media.id='$media_id'";
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
		            <a href="media.php?page=$page_back" style="color:black"> << </a>
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
	         if($i!=$page) $pages.="&nbsp;<a href=\"media.php?page=$i\"  style=\"color:black;font-size:13px \">$i</a>";
	         else $pages.="<font color=\"#FFFFFF\" style=\"font-size:13px\">&nbsp;$i</font>";
       
         if(($page*$nr_per_page)<$_SESSION['total'])
	       {
	         $page_next=$page+1;	   
             $pages.=<<<EOD
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		             <a href="media.php?page=$page_next" style="color:black"> >>
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
				<a href="media.php?orderby=title"><img src="images/arrow2.png" border="0"></a>
				<a href="media.php?orderby=title&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>category</b>', 225)"; onMouseout="hideddrivetip()"><font color="black">Category</font>                &nbsp;
				<a href="media.php?orderby=category_id"><img src="images/arrow2.png" border="0"></a>
				<a href="media.php?orderby=category_id&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				</td>
				
				
				<td  class="listing" width="100">				
				<div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>date</b>', 225)"; onMouseout="hideddrivetip()"><font color="black">Post Date</font>
				&nbsp;
				<a href="media.php?orderby=post_date"><img src="images/arrow2.png" border="0"></a>
				<a href="media.php?orderby=post_date&dir=desc"><img src="images/arrow1.png" border="0"></a>
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
	    $search=" where media.title like '%".$_SESSION['search']."%' or media.body like '%".$_SESSION['search']."%' "; 
	    
     $sql="select * from media $search $_SESSION[orderby] limit $limit,$nr_per_page ";
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
	    $sql="select * from media_categories where id='$row[category_id]'";
		$cat_result=$mysql->query($sql);
		$category=$cat_result->fetch();
		$category=$category['category'];
		
		$sql="select * from clients where id='$row[client_id]'";
        $client_result=$mysql->query($sql);
        $client_row=$client_result->fetch();
	
		
		$content.=<<<EOD
		  <tr>
			    <td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('<b>$row[title]</b><br>Client: $client_row[name]<br>Post Date: $row[post_date]', 225)"; onMouseout="hideddrivetip()">&nbsp;&nbsp; $row[title] &nbsp;&nbsp;</div>				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing">$category</div>				
				</td>
				
				<td  class="listing">				
				<div id="$k" class="listing">$row[post_date]</div>				
				</td>
				
				
                <td width="20" class="listing"></td>
						
		        <td class="listing" align="center">
				<div id="edit$k" class="listing" onMouseover="ddrivetip('Click to edit <b>$row[title]</b>', 175)"; onMouseout="hideddrivetip()"><a href="media_edit.php?id=$row[id]" class="list_links"><img src="images/edit.gif" border="0"></a></div>
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