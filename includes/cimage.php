<?php
class Upload
{
	var $img_name;	
	var $dir;
	var $dir_ok;
	var $max_filesize=1024;		
	var $error=0;
	var $error_message="";
	var $file_type;
	var $file_name="";
	var $file_size;
	var $file_new_prefix="";
	var $file_new_name="";
	
	function Upload()
	{
		
	}
	
	function UploadImageDimension($file,$w,$h)
	{
		$temparr=$this->Gen_File_Dimension($_FILES[$file]['tmp_name']);
		if($w>$temparr[0] or $h>$temparr[1])
		{
			$this->error_message="File Dimension should be ".$w." x ".$h;
			echo "<table width='100%' border=0>";
			echo "<tr>";
			echo "<td align='center' valgin=top height=230>&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td align='center' valgin=top>".$this->error_message."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td align='center' valgin=top><a href='javascript:history.back();'>back</a></td>";
			echo "</tr>";
			echo "</table>";
			exit;
		}
		else
		{
			
		}
	}
	
	function UploadImage($file)
	{

		$dir_ok=true;
		$this->file_name = strtolower($_FILES[$file]['name']);
		$type_arr=explode(".",$this->file_name);
		$this->file_type=strtolower($type_arr[count($type_arr)-1]);
//	echo 	$this->file_type = strtolower(substr($this->file_name,strlen($this->file_name)-3)); 
		if(!file_exists($this->dir))
		{
			mkdir($this->dir);
			chmod($this->dir,0777);
		}
		if(!file_exists($this->dir))
		{
			
			$dir_ok=false;
		}
		if($dir_ok==true)
		{
			
			/*if(($_FILES[$file]['size']/1024)>$this->max_filesize)
			{
				$this->error_message="File Size Error. File Size should be below ".$this->max_filesize." Kbs";
				echo "<table width='100%' border=0>";
				echo "<tr>";
				echo "<td align='center' valgin=top height=230>&nbsp;</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td align='center' valgin=top>".$this->error_message."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td align='center' valgin=top><a href='javascript:history.back();'>back</a></td>";
				echo "</tr>";
				echo "</table>";
				exit;
			}*/
			$this->Gen_Name();
			
			if(move_uploaded_file($_FILES[$file]['tmp_name'],$this->dir."/".$this->file_new_name))
			{
				return $this->dir."/".$this->file_new_name;
			}
		}
		else
		{
			$this->error_message="Directory Error. Cannot Create Directory ".$this->dir;
			echo "<table width='100%' border=0>";
			echo "<tr>";
			echo "<td align='center' valgin=top height=230>&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td align='center' valgin=top>".$this->error_message."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td align='center' valgin=top><a href='javascript:history.back();'>back</a></td>";
			echo "</tr>";
			echo "</table>";
			exit;
		}	
	}
	
	function Gen_Name()
	{
		
		$type_arr=explode(".",$this->file_name);
		$tmp=strtolower($type_arr[count($type_arr)-1]);
		
		$this->file_new_name="";
		if($this->file_new_prefix!="")
		{
			$this->file_new_name=$this->file_new_prefix."_";	
		}
		$this->file_new_name.=rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$tmp;
	}
	
	function Gen_File_Dimension($temp_filename)
	{
	
		list($width, $height) = getimagesize($temp_filename);
		$rarr[0]=$width;
		$rarr[1]=$height;
		
		return $rarr;
	}
	
	function Gen_standard_Name()
	{
		$testfile_new_name="";
		if($this->file_new_prefix!="")
		{
			$testfile_new_name=$this->file_new_prefix."_";	
		}
		if($this->file_type=="jpeg")
		{
		$testfile_new_name.=rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".substr($this->file_name,strlen($this->file_name)-4);
		}
		else
		{
			$testfile_new_name.=rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".substr($this->file_name,strlen($this->file_name)-3);
		}
		return $testfile_new_name;
	}
    function Gen_standard_Name_1()
	{
		$testfile_new_name="";
		if($this->file_new_prefix!="")
		{
			$testfile_new_name=$this->file_new_prefix."_";	
		}
		if($this->file_type=="jpeg")
		{
		$testfile_new_name.=$this->file_name;
		}
		else
		{
			$testfile_new_name.=$this->file_name;
		}
		return $testfile_new_name;
	}
	
	function Aspect_Size($width, $height, $target)
	{
		// USE :
		// $mysock = getimagesize("images/sock001.jpg"); 
		//<img src="images/sock001.jpg" Aspect_Size($mysock[0], $mysock[1], 150);
				
		//takes the larger size of the width and height and applies the  
		if($width>=$target and $height>=$target)
		{
			if($height==$width)
			{
				$ar=$target*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;						
			}
			elseif($height>$width)
			{
				$ar=$target*100/$height;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
			elseif($height<$width)
			{
				$ar=$target*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
		}
		else
		{
			$newwidth=$width;
			$newheight=$height;
		}
		
		//gets the new value and applies the percentage, then rounds the value 
		//$width = round($width * $percentage);
		//$height = round($height * $percentage);
		
		return "width=\"$newwidth\" height=\"$newheight\""; 
	}	
	
	function resizeImage($filename,$max_width,$newfilename="",$max_height='',$withSampling=true) 
	{ 
		if($newfilename=="") 
			$newfilename=$filename; 
		// Get new sizes 
		
		list($width, $height) = getimagesize($filename); 
		
		if($width>=$max_width and $height>=$max_width)
		{
			if($height==$width)
			{
				$ar=$max_width*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;						
			}
			elseif($height>$width)
			{
				$ar=$max_width*100/$height;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
			elseif($height<$width)
			{
				$ar=$max_width*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
		}
		else
		{
			if($height<$max_width and $width<$max_width)
			{
				$newwidth=$width;
				$newheight=$height;
			}
			else if($height<$width)
			{
				$ar=$max_width*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
			else 
			{
				$newwidth=$width;
				$newheight=$height;
			}
			/*$newwidth=$width;
			$newheight=$height;*/
			
		}
		
		//-- dont resize if the width of the image is smaller or equal than the new size. 
		/*if($width<=$max_width) 
			$max_width=$width;
			
		$percent = $max_width/$width; 
		
		$newwidth = $width * $percent; 
		if($max_height=='') { 
			$newheight = $height * $percent;
		} else 
			$newheight = $max_height; */
		
		
		$newwidth =round($newwidth);
		$newheight =round($newheight);
		
		// Load 
		$thumb = imagecreatetruecolor($newwidth, $newheight); 
		
		$type_arr=explode(".",$filename);
		$ext=strtolower($type_arr[count($type_arr)-1]);
		//$ext = strtolower(substr($filename,strlen($filename)-3)); 
		
		if($ext=='jpg' || $ext=='jpeg') 
			$source = imagecreatefromjpeg($filename); 
		if($ext=='gif') 
			$source = imagecreatefromgif($filename); 
		if($ext=='png') 
			$source = imagecreatefrompng($filename); 
		
		// Resize 
		if($withSampling) 
			imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
		else    
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
			
		// Output 
		if($ext=='jpg' || $ext=='jpeg') 
			return imagejpeg($thumb,$newfilename,100); 
		if($ext=='gif') 
			return imagegif($thumb,$newfilename,100); 
		if($ext=='png') 
			return imagepng($thumb,$newfilename,9); 
	} 
}
?>