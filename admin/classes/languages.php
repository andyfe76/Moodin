<?php
class languages
{
 var $mysql;
 
 function languages()
   {
     global $mysql;
	 $this->mysql=$mysql;
   }
 
 function languages_select()
   {
     $sql="select * from languages";
     $result=$this->mysql->query($sql);
     return $result;
   }

 function language_select($id_language)
   {
     $sql="select * from languages where id='$id_language'";
     $result=$this->mysql->query($sql);	 
	 $row=$result->fetch();
     return $row;
   }
   
   
 function language_add($language)
   {
     if(empty($index))
	   $index=0;
	 
	 $sql="insert into languages values(NULL,'$language[language]','$language[flag]')";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }

 function language_edit($language)
   {	 
	 if(empty($language['index']))
	   $language['index']=0;
	 
	 $sql="update languages set language='$language[language]', flag='$language[flag]' where id='$language[id_language]'";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;
   }
 
 function language_delete($id_language)
   {
     $sql="delete from languages where id='$id_language'";
     $result=$this->mysql->query($sql);
     if($result->isError()) return 0;
     else return 1;	
   }     
} 
?>