<?php
class categories
{
 var $mysql;
 
 function categories()
   {
     global $mysql;
	 $this->mysql=$mysql;
   }
 
 function categories_select_all($parent_id)
   {
     if(empty($parent_id))
	   $parent_id=0;
   
     $sql="select * from categories where parent_id='$parent_id'";
     $result=$this->mysql->query($sql);

     return $result;
   } 
 
 
 function categories_select($id)
   {
     $sql="select * from categories where id='$id'";
     $result=$this->mysql->query($sql);
     $row=$result->fetch();
     return $row;
   }

  
 function categories_add($categories)
   {
	 
	 $sql="insert into categories(category,parent_id,meta_tags,`index`) values('$categories[category]','$categories[parent_id]','$categories[meta_tags]','$categories[index]')";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }

 function categories_edit($categories)
   {
     if(empty($categories['parent_id']))
	   $categories['parent_id']=0;
   
	 $sql="update categories set categories.category='$categories[category]',categories.parent_id='$categories[parent_id]',categories.meta_tags='$categories[meta_tags]',categories.index='$categories[index]'  where categories.id='$categories[id]'";
	 
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }
 
 function categories_delete($categories_id)
   {
     $sql="delete from categories where categories.id='$categories_id'";
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
		            <a href="categories.php?page=$page_back" style="color:black"> << </a>
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
	         if($i!=$page) $pages.="&nbsp;<a href=\"categories.php?page=$i\"  style=\"color:black;font-size:13px \">$i</a>";
	         else $pages.="<font color=\"#FFFFFF\" style=\"font-size:13px\">&nbsp;$i</font>";
       
         if(($page*$nr_per_page)<$_SESSION['total'])
	       {
	         $page_next=$page+1;	   
             $pages.=<<<EOD
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		             <a href="categories.php?page=$page_next" style="color:black"> >>
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
	    $search=" where categories.category like '%".$_SESSION['search']."%' "; 
	  
	 if(empty($search))
	   $search=" where parent_id='0'";
	 else
	   $search.=" && parent_id='0'";  
	    
     $sql="select * from categories $search limit $limit,$nr_per_page";
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
       if($row['id']==$parent_id)
	   { 
			 
	   $subcats_result=$this->categories_select_all($parent_id);
	   if($subcats_result->size())
	     {


           while($subcat=$subcats_result->fetch())
		     {
			   $subcats.=<<<EOD
                    <tr>
					  <td width="30"></td>
					  <td>
					    $subcat[category] 
					  </td>
					  <td width="30"></td>
					  <td>	
						<a href="categories_edit.php?id=$subcat[id]&parent_id=$parent_id" class="list_links"><img src="images/edit.gif" border="0"></a>
				      </td>
					  <td width="5"></td>
					  <td>		
					  
						<a href="#" onclick="redirect('$subcat[category]','$subcat[id]','$parent_id'); return false;" class="edit_links"><img src="images/delete.gif" border="0"></a>						
					  </td>
					  <td width="5"></td>
					  <td>		
					  
						<img src="img/2.gif">&nbsp;<a href="products_add.php?cat_id=$subcat[id]" class="edit_links">Add product</a>						
					  </td>
					</tr>
EOD;
			 }


		 }
		
	        $subcats=<<<EOD
              <tr>
			    <td>
				  <table class="listing">
				  
				  $subcats
				  
				  <tr><td height="20"></td></tr>
				  <tr>
				    <td width="15"></td>
	                <td colspan="5">
	                  <img src="img/2.gif">&nbsp;<a href="categories_add.php?parent_id=$parent_id" class="title_links">Add category</a> &nbsp;   <img src="img/2.gif">&nbsp;<a href="products_add.php?cat_id=$parent_id" class="title_links">Add product</a>
                    </td>
	              </tr>
				  
				  </table>
			    </td>
		      </tr>
				  
				  
EOD;
	    
		}
		else
		  $subcats="";	 
	 
	    $content.=<<<EOD
		  <tr>
			    <td  class="listing">				
				<div id="$k" class="listing" onMouseover="ddrivetip('<b>$row[category]</b>', 225)"; onMouseout="hideddrivetip()">&nbsp;&nbsp;<a href="categories.php?parent_id=$row[id]" class="list_links"> $row[category] </a>&nbsp;&nbsp;</div>			
					
				</td>
				
				
				
                <td width="20" class="listing"></td>
						
		        <td class="listing" align="center">
				<div id="edit$k" class="listing" onMouseover="ddrivetip('Click to edit <b>$row[category]</b>', 175)"; onMouseout="hideddrivetip()"><a href="categories_edit.php?id=$row[id]" class="list_links"><img src="images/edit.gif" border="0"></a></div>
				</td>
				
				<td width="5" class="listing"></td>	
					
                <td class="listing" align="center"><div id="delete$k" class="listing" onMouseover="ddrivetip('Click to delete <b>$row[category]</b>', 175)"; onMouseout="hideddrivetip()"><a href="#" onclick="redirect('$row[category]','$row[id]'); return false;" class="edit_links"><img src="images/delete.gif" border="0"></a></div></td>
          </tr>
		  $subcats
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