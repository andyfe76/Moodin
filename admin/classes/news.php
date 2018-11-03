<?php
class news
{
 var $mysql;
 
 function news()
   {
     global $mysql;
	 $this->mysql=$mysql;
   }
 
 function news_select($id)
   {
     $sql="select * from news where id='$id'";
     $result=$this->mysql->query($sql);
     $row=$result->fetch();
     return $row;
   }

 function news_select_cat($cat_id)
   {
     $sql="select * from news where news.category_id='$cat_id'";
     $result=$this->mysql->query($sql);		 
     return $result;
   }
   
   
 function news_add($news)
   {
	 $news['body']=addslashes($news['body']);
	 $news['title']=addslashes($news['title']);
	 $sql="insert into news(category_id,client_id, post_date, title, body, status, pdf, html) values('$news[category_id]','$news[client_id]','$news[post_date]','$news[title]','$news[body]','$news[status]','$news[pdf]','$news[html]')";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }

 function news_edit($news)
   {
	 $news2=$this->news_select($news['id']);
	 if(file_exists("./../pdfs/$news2[pdf]") && !empty($news2['pdf']))
	   unlink("./../pdfs/$news2[pdf]");
	   
	 if(file_exists("./../html/$news2[html]") && !empty($news2['html']))
	   unlink("./../html/$news2[html]");  
	   
	 $news['body']=addslashes($news['body']);  
	 $news['title']=addslashes($news['title']);  
	 
	 $sql="update news set category_id='$news[category_id]', news.client_id='$news[client_id]', post_date='$news[post_date]', title='$news[title]', body='$news[body]', status='$news[status]', pdf='$news[pdf]', html='$news[html]' where news.id='$news[id]'";
	 
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }
 
 function news_delete($news_id)
   {
     $news=$this->news_select($news_id);
	 if(file_exists("./../pdfs/$news[pdf]") && !empty($news['pdf']))
	   unlink("./../pdfs/$news[pdf]");
	   
	 if(file_exists("./../html/$news[html]") && !empty($news['html']))
	   unlink("./../html/$news[html]");  
	 
	 $sql="delete from news where news.id='$news_id'";
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
		            <a href="news.php?page=$page_back" style="color:black"> << </a>
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
	         if($i!=$page) $pages.="&nbsp;<a href=\"news.php?page=$i\"  style=\"color:black;font-size:13px \">$i</a>";
	         else $pages.="<font color=\"#FFFFFF\" style=\"font-size:13px\">&nbsp;$i</font>";
       
         if(($page*$nr_per_page)<$_SESSION['total'])
	       {
	         $page_next=$page+1;	   
             $pages.=<<<EOD
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		             <a href="news.php?page=$page_next" style="color:black"> >>
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
				<a href="news.php?orderby=title"><img src="images/arrow2.png" border="0"></a>
				<a href="news.php?orderby=title&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				
				</td>
				<td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>category</b>', 225)"; onMouseout="hideddrivetip()"><font color="black">Category</font>                &nbsp;
				<a href="news.php?orderby=category_id"><img src="images/arrow2.png" border="0"></a>
				<a href="news.php?orderby=category_id&dir=desc"><img src="images/arrow1.png" border="0"></a>
				</div>				
				</td>
				
				
				<td  class="listing" width="100">				
				<div id="$k" class="listing" onMouseover="ddrivetip('Order by <b>date</b>', 225)"; onMouseout="hideddrivetip()"><font color="black">Post Date</font>
				&nbsp;
				<a href="news.php?orderby=post_date"><img src="images/arrow2.png" border="0"></a>
				<a href="news.php?orderby=post_date&dir=desc"><img src="images/arrow1.png" border="0"></a>
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
	    $search=" where news.title like '%".$_SESSION['search']."%' or news.body like '%".$_SESSION['search']."%' "; 
	    
     $sql="select * from news $search $_SESSION[orderby] limit $limit,$nr_per_page ";
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
	    $sql="select * from news_categories where id='$row[category_id]'";
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
				<div id="edit$k" class="listing" onMouseover="ddrivetip('Click to edit <b>$row[title]</b>', 175)"; onMouseout="hideddrivetip()"><a href="news_edit.php?id=$row[id]" class="list_links"><img src="images/edit.gif" border="0"></a></div>
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