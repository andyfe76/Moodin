<?php


class upload
{ 

  var $path;
  
  function upload($path="")
    {
	  $this->path=$path;
	}

function upload_file($file)
   {
      
	$path_to_file = $this->path;

      if (!ereg("/$", $path_to_file))
        $path_to_file = $path_to_file."/";

      if ($file['size'])
        {

          $name=$file['name'];
		  $ext=$this->getFileExtension($name);
		  
		  $name=md5(time())."_ENCODED";
		  $name.=".".$ext;
		  		  
          $name = ereg_replace("[^a-z0-9._]", "",str_replace(" ", "_",str_replace("%20", "_", strtolower($name))));
          $location = $path_to_file.$name;
          /*   while (file_exists($location))
          $location .= ".copy"; */

	      $name=eregi_replace(" ", "_", $name);
		  

          $ext=$this->getFileExtension($name);
          $ext=".".$ext;
          $name=ereg_replace($ext, "", $name);
          $copy="";
          $n=1;
          while(file_exists($this->path.$name. $copy.$ext)) {
						$copy = "_copy" . $n;
						$n++;
					}

          $name=$name.$copy.$ext;

          copy($file['tmp_name'],$this->path.$name);
	      unlink($file['tmp_name']);
	     		
		  return $name;
       }
   }
  
  function upload_image($file,$thumbs)
   {
      
	  
	  $path_to_file = $this->path;

      if (!ereg("/$", $path_to_file))
        $path_to_file = $path_to_file."/";

      if ($file['size'])
        {

          $name=$file['name'];
		  $ext=$this->getFileExtension($name);
		  
		  $token = md5(uniqid(rand(),1));
          $name=substr($token, 0, 10); 
		  $name.=".".$ext;
		  		  
          $name = ereg_replace("[^a-z0-9._]", "",str_replace(" ", "_",str_replace("%20", "_", strtolower($name))));
          $location = $path_to_file.$name;
          /*   while (file_exists($location))
          $location .= ".copy"; */

	      $name=eregi_replace(" ", "_", $name);
		  

          $ext=$this->getFileExtension($name);
          $ext=".".$ext;
          $name=ereg_replace($ext, "", $name);
          $copy="";
          $n=1;
          while(file_exists($this->path.$name. $copy.$ext)) {
						$copy = "_copy" . $n;
						$n++;
					}

          $name=$name.$copy.$ext;

          copy($file['tmp_name'],$this->path.$name);
	      unlink($file['tmp_name']);
	      
		  
		  $image_path=$this->path.$name;
		  list($imgWidth,$imgHeight,$type,$imgAttr)=getimagesize($image_path);
	      
		  
		  if(is_array($thumbs))
		  foreach ($thumbs as $key => $value)
		    {
		  
		      $height1=$thumbs[$key]['height'];
			  $width1=$thumbs[$key]['width'];  
			  
			  
			  if($height1==0)
		        $height1=($width1/$imgWidth)*$imgHeight;
			
		      else if($width1==0)
		        $width1=($height1/$imgHeight)*$imgWidth;
			
			
		      if($width1<$imgWidth && $height1<$imgHeight)	
			    $this->resize($name,$width1,$height1,"_thumb$key");
		      else
		        $this->resize($name,$imgWidth,$imgHeight,"_thumb$key");	

            }
			
		  return $name;
       }
   }
   


  function resize($image,$width,$height,$ext_name="")
    {
      $path_to_file = $this->path;

      if (!ereg("/$", $path_to_file))
        $path_to_file = $path_to_file."/";

      $image=$path_to_file.$image;

      require_once 'resizeimage.php';
	  $rimg=new RESIZEIMAGE("$image");
	  echo $rimg->error();

      $ext=$this->getFileExtension($image);
      $ext=".".$ext;
      $image=ereg_replace($ext, "", $image);

	  $rimg->resize($width,$height,"$image"."$ext_name");
	  $rimg->close();
    }

  function getFileExtension($str)
    {
      $i = strrpos($str,".");
      if (!$i) { return ""; }
      $l = strlen($str) - $i;
      $ext = substr($str,$i+1,$l);
      return $ext;
    }

  function filename_mod($file,$add)
    {
      $ext=$this->getFileExtension($file);
	  $ext=".".$ext;
	  $file=ereg_replace($ext, "", $file);	 
	  $file=$file.$add.$ext;
	  return $file;
    }	
	
}


?>
