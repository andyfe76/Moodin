<?php
ini_set("display_errors",1);
require_once '../config.inc.php';
require_once '../language/back_end.php';
class MySQL
{
  var $db;
  var $connectError;
  var $host;
  var $database;
  var $user;
  var $password;

  function MySQL()
   {
     global $host,$database,$user,$password;	 
	 $this->host=$host;
	 $this->database=$database;
	 $this->user=$user;
	 $this->password=$password;
	 $this->connect();
	 
   }
  function connect()
   {
     //conexiunea la MySQL server
     if(!$this->db=@mysql_connect("$this->host","$this->user","$this->password"))
         {
           trigger_error('Could not connect to server');
           $this->connectError=true;
         }
     else if(!@mysql_select_db("$this->database",$this->db))
         { trigger_error('Could not select database');
           $this->connectError=true; 
         }     
   }
  function isError()
   {
     if($this->connectError)
         {
            return true;
         }
     $error=mysql_error($this->db);
     if(empty($error))
         {
             return false;
         }
     else
         {
             return true;
         }  
   } 
  function &query($sql)
   {
     if(!$result=mysql_query($sql,$this->db))
         {
           trigger_error('Query failed:'.mysql_error($this->db).'SQL'.$sql);
         } 
     else return new MySQLResult($this,$result); 
   }
  
   

}

class MySQLResult
{
 var $mysql;
 var $query;
 function MySQLResult(&$mysql,$query)
   {
      $this->mysql=&$mysql;
      $this->query=$query;
   }
 function fetch()
   {
      if($row=mysql_fetch_array($this->query,MYSQL_ASSOC))
         {
           return $row;
         }
      else if($this->size()>0)
         {
           mysql_data_seek($this->query,0);
           return false;
         }
   }
 
 function isError()
   {
      return $this->mysql->isError();
   } 
 function size()
   {
      return mysql_num_rows($this->query);
   }       
}
?>