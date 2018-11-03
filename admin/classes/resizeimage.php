<?php


	define("HAR_AUTO_NAME",1);
	Class RESIZEIMAGE
	{
		var $imgFile="";
		var $imgWidth=0;
		var $imgHeight=0;
		var $imgType="";
		var $imgAttr="";
		var $type=NULL;
		var $_img=NULL;
		var $_error="";

		function RESIZEIMAGE($imgFile="")
		{
			$this->type=Array(1 => 'GIF', 2 => 'JPG', 3 => 'PNG', 4 => 'SWF', 5 => 'PSD', 6 => 'BMP', 7 => 'TIFF', 8 => 'TIFF', 9 => 'JPC', 10 => 'JP2', 11 => 'JPX', 12 => 'JB2', 13 => 'SWC', 14 => 'IFF', 15 => 'WBMP', 16 => 'XBM');
			if(!empty($imgFile))
				$this->setImage($imgFile);
		}
		function error()
		{
			return $this->_error;
		}
		function setImage($imgFile)
		{
			$this->imgFile=$imgFile;
			return $this->_createImage();
		}
		function close()
		{
			return imagedestroy($this->_img);
		}
		function resize_percentage($percent=100,$newfile=NULL)
		{
			$newWidth=($this->imgWidth*$percent)/100;
			$newHeight=($this->imgHeight*$percent)/100;
			return $this->resize($newWidth,$newHeight,$newfile);
		}
		function resize_xypercentage($xpercent=100,$ypercent=100,$newfile=NULL)
		{
			$newWidth=($this->imgWidth*$xpercent)/100;
			$newHeight=($this->imgHeight*$ypercent)/100;
			return $this->resize($newWidth,$newHeight,$newfile);
		}
		function resize($width,$height,$newfile=NULL)
		{
			if(empty($this->imgFile))
			{
				$this->_error="File name is not initialised.";
				return false;
			}
			if($this->imgWidth<=0 || $this->imgHeight<=0)
			{
				$this->_error="Could not resize given image";
				return false;
			}
			if($width<=0)
				$width=$this->imgWidth;
			if($height<=0)
				$height=$this->imgHeight;

			return $this->_resize($width,$height,$newfile);
		}
		function _getImageInfo()
		{
			list($this->imgWidth,$this->imgHeight,$type,$this->imgAttr)=getimagesize($this->imgFile);
			$this->imgType=$this->type[$type];
		}
		function _createImage()
		{
			$this->_getImageInfo($imgFile);
			if($this->imgType=='GIF')
			{
				$this->_img=imagecreatefromgif($this->imgFile);
			}
			elseif($this->imgType=='JPG')
			{
				$this->_img=imagecreatefromjpeg($this->imgFile);
			}
			elseif($this->imgType=='PNG')
			{
				$this->_img=imagecreatefrompng($this->imgFile);
			}
			if(!$this->_img || !is_resource($this->_img))
			{
				$this->_error="Error loading ".$this->imgFile;
				return false;
			}
			return true;
		}
		function _resize($width,$height,$newfile=NULL)
		{
			$newimg=imagecreatetruecolor($width,$height);
			imagecopyresampled ( $newimg, $this->_img, 0,0,0,0, $width, $height, $this->imgWidth,$this->imgHeight);
			if($newfile===HAR_AUTO_NAME)
			{
				if(preg_match("/\..*+$/",basename($this->imgFile),$matches))
			   		$newfile=substr_replace($this->imgFile,"_har",-strlen($matches[0]),0);
			}
			elseif(!empty($newfile))
			{
				if(preg_match("/\..*+$/",basename($this->imgFile),$matches))
				   $newfile=$newfile.$matches[0];
			}

			if($this->imgType=='GIF')
			{
				if(!empty($newfile))
					imagegif($newimg,$newfile);
				else
					imagegif($newimg);
			}
			elseif($this->imgType=='JPG')
			{
				if(!empty($newfile))
					imagejpeg($newimg,$newfile);
				else
					imagejpeg($newimg);
			}
			elseif($this->imgType=='PNG')
			{
				if(!empty($newfile))
					imagepng($newimg,$newfile);
				else
					imagepng($newimg);
			}
			imagedestroy($newimg);
		}
	}
?>