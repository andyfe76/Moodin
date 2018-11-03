<?php
class cont
{
  var $mysql;

  function cont($mysql)
    {               
      $this->mysql=$mysql; 
    }

  function login($admin,$password)
    {
	  $password=md5($password);
      $sql="select * from admin where admin='$admin' && password='$password'";
      $result=$this->mysql->query($sql);
      $row=$result->fetch();
      if($result->size()) 
       {
	     session_start();
		 if(empty($_COOKIE['PHPSESSID'])): 
           $Cookie_ID = session_id(); 
           setcookie("PHPSESSID",  $Cookie_ID ); 
           endif; 
         srand((double)microtime()*1000000);
         $id=substr(md5(rand(0,9999999)), 0, 16);        
         $_SESSION['admin']=$admin;
         $_SESSION['id_a']=$id;
		 
		 $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		 $_SESSION['aa']=$url;  
		 $_SESSION['ab']=$url;
		 $_SESSION['ac']=$url;
	
         return 1;
       }
      else return 0;
    }
  
  function change_password($password_noua)
  {
    $sql="update admin set password='$password_noua' where admin='$_SESSION[nume]'";
	$this->mysql->query($sql);
	if($this->mysql->isError()) return 0;
	else return 1; 
  } 
   
  function logout()
  {
    
    unset($_SESSION['admin']);
    unset($_SESSION['id_a']);
      
  }
  
  function form($content="")
  {
    if(empty($content))
	  $content="";
	
	$content=<<<EOD
<html><head><title>Bag Anonymous - Administrative Login</title>
<script type="text/javascript">
function noNumbers(e)
{
var keynum
var keychar
var numcheck

if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
if(keynum=="13")
	document.getElementById("submit").click();
	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body bgcolor="#ffffff" onkeydown="return noNumbers(event)">
<form action="index.php" method="POST" id="login_form" name="login_form">
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
  <tbody><tr align="center" valign="middle"> 
    <td>
      <table border="0" cellpadding="0" cellspacing="0" width="350">
        <tbody><tr>
          <td><img src="images/logo.jpg" height="63" width="350"></td>
        </tr>
        <tr bgcolor="#000000"> 
          <td height="1"><img src="images/trans.gif" height="1" width="1"></td>
        </tr>
        <tr>
          <td>
            <table border="0" cellpadding="0" cellspacing="0" width="350">
              <tbody><tr> 
                <td><input onkeyup="" type="hidden" name="submitted" value="submitted"></td>
              </tr>
              <tr align="center"> 
                <td> 
                  <table border="0" cellpadding="0" cellspacing="0" width="321">
                    <tbody><tr> 
                      <td height="30" width="110"><font color="#666666" face="Century Gothic, Arial" size="2"><b><font size="1">USERNAME:</font></b></font></td>
                      <td align="center" height="30"> 
                        <input name="admin" type="text" id="admin" size="28">
                      </td>
                    </tr>
                    <tr> 
                      <td height="30" width="110"><font color="#666666" face="Century Gothic, Arial" size="2"><b><font size="1">PASSWORD: 
                        </font></b></font></td>
                      <td align="center" height="30"> 
                        <input name="password" onkeyup="" type="password" id="password" size="28">
                      $content
					  </td>
                    </tr>
                    <tr> 
                      <td height="30" width="110">&nbsp;</td>
                      <td align="right" height="30"> <input type="submit" style="visibility:hidden" name="submit" id="submit" > <img   src="images/continue_button2.gif" style="cursor:pointer" onClick="document.getElementById('submit').click()"  height="25" width="82"></td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
      </tbody></table>
    </td>
  </tr>
</tbody></table>
</form>
</body></html>
EOD;
   return $content;
  } 
}
?>