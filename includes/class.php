<?
require "paging.php";
//Class
class DBconn{
	var $rowrs;	
	var $totalrows;
	var $Paging;
	var $InfoArray;
    var $linki;
	//function for database connection
	function connect($host,$db,$user,$password)
	{
		$this->linki = mysqli_connect($host,$user,$password) or die(mysqli_error($this->linki)."Could not connect to database");
		$database=mysqli_select_db($this->linki,$db) or die(mysqli_error($this->linki)."Could not select database"); 
	}
	
	//function for Find Maximum Number
	function MaxNum($tblname,$fieldname)
	{
		$sql="select max(".$fieldname.") as big from ".$tblname;
		$maxresult =  mysqli_query($this->linki,$sql) or die(mysqli_error($this->linki)."<br>".$qy);
		$max_num_rows = mysqli_num_rows($maxresult);
		
		if($max_num_rows > 0)
		{
			$myrow = mysqli_fetch_array($maxresult);
			return $myrow["big"]+1;
		}
		else
		{
			return 1;
		}
	}
	
	//function for inserting data
	function insert($qy,$st=0)
	{
		if($st==1){
			print $qy;
		}
		mysqli_query($this->linki,$qy) or die(mysqli_error($this->linki)."<br>".$qy);
	}
	
	//function for deleting records
	function delete($qy,$st=0)
	{
		if($st==1){
			print $qy;
		}
		mysqli_query($this->linki,$qy) or die(mysqli_error($this->linki)."<br>".$qy);
	}
	
	//function for updating data
	function update($qy,$st=0)
	{
		if($st==1){
			print $qy;
		}
		mysqli_query($this->linki,$qy) or die(mysqli_error($this->linki)."<br>".$qy);		
	}
	
	//function for selecting data
	function recordselect($qy,$st=0)
	{
		if($st==1)
		{
			print $qy;
		}
        
		$rs=mysqli_query($this->linki,$qy) or die(mysqli_error($this->linki)."<br>".$qy);		
       
		return $rs;
	}

	// function for selecting data
	//function recordselecttest($qy) {
  //  if($result = $mysqli->query($qy)) {
  //    return $result;
  //  }
  //  else {
  //    die($mysqli->error . "<br />" . $qy);		
  //  }
	//}
	
	//function for selecting records & paging
	function select11($qy,$page,$per_page,$totallink,$dpaging=0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$paggingvar='page')
	{
	/*
		$dpaging is for whether we want to display paging or not
		0 means paging not display
		1 means short paging only next,previous not number paging
		2 means long paging display 
		
		$paggingfunction
		name of javascript function		
	*/
		$rs=mysqli_query($this->linki,$qy) or die(mysqli_error($this->linki)."<br>".$qy);
		$num_rows = mysqli_num_rows($rs);
		$this->totalrows=$num_rows;
		$iarry[0]=$num_rows;
		$page = $page;

		$prev_page = $page - 1; 
		$next_page = $page + 1;
		$page_start = ($per_page * $page) - $per_page;
		$pageend=0;
		
		if ($num_rows <= $per_page) { 
			$num_pages = 1; 
		} else if (($num_rows % $per_page) == 0) { 
			$num_pages = ($num_rows / $per_page); 
		} else { 
			$num_pages = ($num_rows / $per_page) + 1; 
		} 
		$num_pages = (int) $num_pages; 
		if (($page > $num_pages) || ($page < 0))
		{ 
			//echo ("You have specified an invalid page number"); 
		}
		
		if($num_rows>0)
		{
			$pagestart=0;
			$pageend=0;
			$pagestart = (($page-1) * $per_page)+1;
			if($num_pages == $page)
			{
				$pageend = $num_rows;
			}
			else
			{
				$pageend = $pagestart + ($per_page - 1);
			}
		}
		
		/* Instantiate the paging class! */ 
	   $this->Paging = new PagedResults(); 
	
	   /* This is required in order for the whole thing to work! */ 
	   $this->Paging->TotalResults = $num_pages; 
	
	   /* If you want to change options, do so like this INSTEAD of changing them directly in the class! */ 
	   $this->Paging->ResultsPerPage = $per_page; 
	   $this->Paging->LinksPerPage = $totallink; 
	   $this->Paging->PageVarName = $paggingvar;
	   $this->Paging->TotalResults = $num_rows; 
	   if($paggingtype!="get")
	   {
		   	$this->Paging->PagePaggingType="post";
	   }
	
	   /* Get our array of valuable paging information! */ 
	   $this->InfoArray = $this->Paging->InfoArray(); 
	   
	   $qy1=$qy." LIMIT $page_start, $per_page ";
	   $rowrs=mysqli_query($this->linki,$qy1) or die(mysqli_error($this->linki)."<br>".$qy1);
	   
	   if($withpagging==1)
	   {
		   if($paggingtype=="get")
		   {
			   if($dpaging==1 || $dpaging==2)
			   {
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=1".$extrapara."'>First</a>&nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($this->InfoArray["PREV_PAGE"]) 
					   { 
						  echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."'>Previous</a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } 
					   }
					   /* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						  echo " <a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					   if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  echo " <a href='$PHP_SELF?".$this->Paging->PageVarName."=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
			else
			{
				if($dpaging==1 || $dpaging==2)
				{
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  echo "<a href='javascript:".$paggingfunction."(1);'>First</a>&nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($InfoArray["PREV_PAGE"]) 
					   { 
						  echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'>Preview</a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } 
					   }
					   /* Print out our next link */ 
					   if($InfoArray["NEXT_PAGE"]) { 
						  echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'><img src='images/bt_next.gif'  border='0' /></a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					   if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Last</a>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
		}
		$page_start = ($per_page * $page) - $per_page;
		$iarry[1]=$rowrs;
		$iarry[2]=$page_start+1;
		$iarry[3]=$pageend;
		return $iarry;			
	}
	function select($qy,$page,$per_page,$totallink,$dpaging=0,$withpagging = 1,$extrapara='',$count_qry='',$paggingtype='get',$paggingfunction='',$paggingvar='page')
	{
	/*
		$dpaging is for whether we want to display paging or not
		0 means paging not display
		1 means short paging only next,previous not number paging
		2 means long paging display 
		
		$paggingfunction
		name of javascript function		
	*/
    if($count_qry == '') {
      $rs = mysqli_query($this->linki,$qy) or die(mysqli_error($this->linki) . "<br>" . $qy);
      $num_rows = mysqli_num_rows($rs);
    }
    else {
      if($count_qry == '0' || isInteger($count_qry)) {
        $num_rows = $count_qry;
      }
      else {
        $rs = mysqli_query($this->linki,$count_qry) or die(mysqli_error($this->linki) . "<br>" . $qy);
        $row_rec = mysqli_fetch_array($rs);
        $num_rows = $row_rec['total'];
      }
    }
    //
		$this->totalrows=$num_rows;
		$iarry[0]=$num_rows;
		$page = $page;

		$prev_page = $page - 1; 
		$next_page = $page + 1;
		$page_start = ($per_page * $page) - $per_page;
		$pageend=0;
		
		if ($num_rows <= $per_page) { 
			$num_pages = 1; 
		} else if (($num_rows % $per_page) == 0) { 
			$num_pages = ($num_rows / $per_page); 
		} else { 
			$num_pages = ($num_rows / $per_page) + 1; 
		} 
		$num_pages = (int) $num_pages; 
		if (($page > $num_pages) || ($page < 0))
		{ 
			//echo ("You have specified an invalid page number"); 
		}
		
		if($num_rows>0)
		{
			$pagestart=0;
			$pageend=0;
			$pagestart = (($page-1) * $per_page)+1;
			if($num_pages == $page)
			{
				$pageend = $num_rows;
			}
			else
			{
				$pageend = $pagestart + ($per_page - 1);
			}
		}
		
		/* Instantiate the paging class! */ 
	   $this->Paging = new PagedResults(); 
	
	   /* This is required in order for the whole thing to work! */ 
	   $this->Paging->TotalResults = $num_pages; 
	
	   /* If you want to change options, do so like this INSTEAD of changing them directly in the class! */ 
	   $this->Paging->ResultsPerPage = $per_page; 
	   $this->Paging->LinksPerPage = $totallink; 
	   $this->Paging->PageVarName = $paggingvar;
	   $this->Paging->TotalResults = $num_rows; 
	   if($paggingtype!="get")
	   {
		   	$this->Paging->PagePaggingType="post";
	   }
	
	   /* Get our array of valuable paging information! */ 
	   $this->InfoArray = $this->Paging->InfoArray(); 
	   
	   $qy1=$qy." LIMIT $page_start, $per_page ";
	   $rowrs=mysqli_query($this->linki,$qy1) or die(mysqli_error($this->linki)."<br>".$qy1);
	   
	   if($withpagging==1)
	   {
		   if($paggingtype=="get")
		   {
			   if($dpaging==1 || $dpaging==2)
			   {
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						 /* echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=1".$extrapara."'>First</a>&nbsp;&nbsp;"; */
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($this->InfoArray["PREV_PAGE"]) 
					   { /*
						  echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."'>Previous</a> | &nbsp;&nbsp;";*/ 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } 
					   }
					   /* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						 /*?>  echo " <a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;&nbsp;";<?php */
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					   if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						 /* echo " <a href='$PHP_SELF?".$this->Paging->PageVarName."=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a>";*/ 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
			else
			{
				if($dpaging==1 || $dpaging==2)
				{
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						//  echo "<a href='javascript:".$paggingfunction."(1);'>First</a>&nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($InfoArray["PREV_PAGE"]) 
					   { 
						  echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'>Preview</a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } 
					   }
					   /* Print out our next link */ 
					   if($InfoArray["NEXT_PAGE"]) { 
						/*  echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'><img src='images/bt_next.gif'  border='0' /></a>&nbsp;&nbsp;";*/ 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					   if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						 /* echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Last</a>"; */
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
		}
		$page_start = ($per_page * $page) - $per_page;
		$iarry[1]=$rowrs;
		$iarry[2]=$page_start+1;
		$iarry[3]=$pageend;
		$iarry[4]=$this->InfoArray["TOTAL_PAGES"];
		return $iarry;			
	}
	function onlyPagging6($page,$per_page,$totallink,$dpaging = 0,$prevnext = 0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$temp_pagevars='')
	{
	  if($withpagging==1)
	   {
		   if($paggingtype=="get")
		   {
			  if($prevnext==1)
			  {
				  if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
					   /* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='$PHP_SELF?page=1".$extrapara."'>First</a>&nbsp;&nbsp;"; 
					  }
					   /* Print out our prev link */ 
				   }
				}
			  
			   if($dpaging==1 || $dpaging==2)
			   {
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						echo "<div class='titleblue_text1'><table align='center' border='0' cellpadding='0' cellspacing='0'><tr>";
						 if($this->InfoArray["PREV_PAGE"]) 
					   { 
						  echo "<td valgin='top' align='center'><a class='titleblue_text1' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."'>Previous</a></td>"; 
					   }
					   
					      if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  echo "<td valgin='top' align='center'>&nbsp;&nbsp;<a  class='titleblue_text1' href='$PHP_SELF?page=1".$extrapara."'>First</a></td>&nbsp;&nbsp;"; 
					  }
					   /* Print out our next link */ 
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo "<td valgin='top' align='center'>&nbsp;&nbsp;</td><td valgin='top' align='center' width='20' height=18 style='background-color:#FFFFF;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								//echo $this->InfoArray["PAGE_NUMBERS"][$i] . "|"; 													
							  }																															
							  else  
							  { 
								 echo "<td valgin='top' align='center'>&nbsp;&nbsp;</td><td valgin='top' align='center' width='20' height=18 style='background-color:#FFFFFF;'>&nbsp;<a class='titleblue_text1' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>"; 
							  }
						  } 
						 
						  if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
						   { 
						       echo " <td valgin='top' align='center'>&nbsp;&nbsp;<a class='titleblue_text1' href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a></td>"; 
					          }
					     
						    if($this->InfoArray["NEXT_PAGE"]) { 
					            echo "<td valgin='top' align='center'>&nbsp;&nbsp;<a class='titleblue_text1' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;"; 
					
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }  
						  echo "</td></tr></table></div>";
					   }
					   /* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						  //echo " <a href='$PHP_SELF?page=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					  
					   if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
			else
			{
				if($prevnext==1)
			    {
					/* Print out our prev link */ 
					   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					   {
					   if($this->InfoArray["PREV_PAGE"]) 
					   { 
					   		
						//  echo "<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;"; 
					   		
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					   /* Print out our next link */ 
					   
					   if($this->InfoArray["NEXT_PAGE"]) 
					  
					   {  
						 // echo "&nbsp;<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>Next</a>&nbsp;"; 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }
					   
					  } 
				}			   
				if($dpaging==1 || $dpaging==2)
				{
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='javascript:".$paggingfunction."(1);'>First</a>&nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($InfoArray["PREV_PAGE"]) 
					   { 
						 // echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'>Previous</a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   /* Example of how to print our number links! */ 
					   
					   /* Print out our next link */ 
						   echo "<div class='titleblue_text1'><table border='0' cellpadding='0' cellspacing='0'><tr>";
		           				
						    if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					       {
					          if($this->InfoArray["PREV_PAGE"]) 
					         { 
					   	        echo "<td><a class='titleblue_text1' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;</td>"; 
					   		   }
					           else
					           { 
						           // echo "Previous | &nbsp;&nbsp;"; 
					             } 
								 
								 if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					             { 
						             echo "<td><a href='javascript:".$paggingfunction."(1);'>First</a></td>&nbsp;&nbsp;"; 
					                }
					                else
					                { 
						                //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					                  }
						      } 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#999999;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								 //echo $this->InfoArray["PAGE_NUMBERS"][$i] . ""; 
							  }
							  else
							  { 
								 echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#CCCCCC;'><a href=javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].",'".$temp_pagevars."');>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>"; 
							  } 
						  } 

						       if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					          { 
						         echo "<td>&nbsp;&nbsp;<a href='javascript:".$paggingfunction."(".$this->InfoArray["TOTAL_PAGES"].");'>Last</a></td>"; 
					             }
			
						    if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					       {
						  
						      if($this->InfoArray["NEXT_PAGE"]) 
					         {  
						        echo "<td>&nbsp;<a class='titleblue_text1' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>&nbsp;Next</a></td>"; 
						       // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					           } else { 
						        //echo " Next&nbsp;&nbsp;"; 
					           }
					        }
						  echo "</tr></table></div>";
						   
						 /*  for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } */
					   }
					   /* Print out our next link */ 
					   if($InfoArray["NEXT_PAGE"]) { 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					    if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Last</a>"; 
					    }
					     else
					    { 
						  //echo " &gt;&gt;"; 
					     }
					}
				}
			}
		}
	}
	
function onlyPagging7($page,$per_page,$totallink,$dpaging = 0,$prevnext = 0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$temp_pagevars='')
	{
	  if($withpagging==1)
	   {
		   if($paggingtype=="get")
		   {
			  if($prevnext==1)
			  {
				  if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
					   /* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='$PHP_SELF?page=1".$extrapara."'>First</a>&nbsp;&nbsp;"; 
					  }
					   /* Print out our prev link */ 
				   }
				}
			  
			   if($dpaging==1 || $dpaging==2)
			   {
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						echo "<div class='titleblue_text1' ><table border='0' cellpadding='0' cellspacing='5'><tr height='55'>";
						 if($this->InfoArray["PREV_PAGE"]) 
					   { 
						  echo "<td valign='middle'><a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."'><img src='images/previous_icon.gif' alt='Previous' title='Previous' border='0' /></a></td>"; 
					   }
					   
					      if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
					//	  echo "<td>&nbsp;&nbsp;<a  class='titleblue_text1' href='$PHP_SELF?page=1".$extrapara."'>First</a></td>&nbsp;&nbsp;"; 
					  }
					   /* Print out our next link */ 
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
						//		 echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#FFFFF;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								//echo $this->InfoArray["PAGE_NUMBERS"][$i] . "|"; 													
							  }																															
							  else  
							  { 
							//	 echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#FFFFFF;'>&nbsp;<a class='titleblue_text1' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>"; 
							  }
						  } 
						 
						  if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
						   { 
						 //      echo " <td>&nbsp;&nbsp;<a class='titleblue_text1' href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a></td>"; 
					          }
					     
						    if($this->InfoArray["NEXT_PAGE"]) { 
					            echo "<td valign='middle'><a  href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."'><img src='images/next_icon.gif'  alt='Next' title='Next' border='0' /></a>"; 
					
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }  
						  echo "</td></tr></table></div>";
					   }
					   /* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						  //echo " <a href='$PHP_SELF?page=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					  
					   if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
			else
			{
				if($prevnext==1)
			    {
					/* Print out our prev link */ 
					   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					   {
					   if($this->InfoArray["PREV_PAGE"]) 
					   { 
					   		
						//  echo "<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;"; 
					   		
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					   /* Print out our next link */ 
					   
					   if($this->InfoArray["NEXT_PAGE"]) 
					  
					   {  
						 // echo "&nbsp;<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>Next</a>&nbsp;"; 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }
					   
					  } 
				}			   
				if($dpaging==1 || $dpaging==2)
				{
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='javascript:".$paggingfunction."(1);'>First</a>&nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($InfoArray["PREV_PAGE"]) 
					   { 
						 // echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'>Previous</a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   /* Example of how to print our number links! */ 
					   
					   /* Print out our next link */ 
						   echo "<div class='titleblue_text1'><table border='0' cellpadding='0' cellspacing='0'><tr>";
		           				
						    if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					       {
					          if($this->InfoArray["PREV_PAGE"]) 
					         { 
					   	        echo "<td><a class='titleblue_text1' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;</td>"; 
					   		   }
					           else
					           { 
						           // echo "Previous | &nbsp;&nbsp;"; 
					             } 
								 
								 if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					             { 
						    //         echo "<td><a href='javascript:".$paggingfunction."(1);'>First</a></td>&nbsp;&nbsp;"; 
					                }
					                else
					                { 
						                //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					                  }
						      } 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#999999;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								 //echo $this->InfoArray["PAGE_NUMBERS"][$i] . ""; 
							  }
							  else
							  { 
								 echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#CCCCCC;'><a href=javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].",'".$temp_pagevars."');>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>"; 
							  } 
						  } 

						       if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					          { 
						         echo "<td>&nbsp;&nbsp;<a href='javascript:".$paggingfunction."(".$this->InfoArray["TOTAL_PAGES"].");'>Last</a></td>"; 
					             }
			
						    if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					       {
						  
						      if($this->InfoArray["NEXT_PAGE"]) 
					         {  
						        echo "<td>&nbsp;<a class='titleblue_text1' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>&nbsp;Next</a></td>"; 
						       // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					           } else { 
						        //echo " Next&nbsp;&nbsp;"; 
					           }
					        }
						  echo "</tr></table></div>";
						   
						 /*  for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } */
					   }
					   /* Print out our next link */ 
					   if($InfoArray["NEXT_PAGE"]) { 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					    if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Last</a>"; 
					    }
					     else
					    { 
						  //echo " &gt;&gt;"; 
					     }
					}
				}
			}
		}
	}	
		
	//function for paging
	function onlyPagging($page,$per_page,$totallink,$dpaging = 0,$prevnext = 0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$temp_pagevars='')
	{
	  if($withpagging==1)
	   {
		   if($paggingtype=="get")
		   {
			  if($prevnext==1)
			  {
				  if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
					   /* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='$PHP_SELF?page=1".$extrapara."'>First</a>&nbsp;&nbsp;"; 
					  }
					   /* Print out our prev link */ 
				   }
				}
			  
			   if($dpaging==1 || $dpaging==2)
			   {
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						echo "<table border='0' cellpadding='0' cellspacing='0'><tr>";
						if($this->InfoArray["PREV_PAGE"]) 
					   { 
						  /*echo "<td><a class='link1' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."'>Previous</a></td>";*/ 
					   }
					   
					      if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						/*  echo "<td>&nbsp;&nbsp;<a href='$PHP_SELF?page=1".$extrapara."' class='link1'>First</a>&nbsp;&nbsp;</td>"; */
					  }
					   /* Print out our next link */ 
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#7A7A7A; border:solid 2px; border-color:#FFFFFF;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								//echo $this->InfoArray["PAGE_NUMBERS"][$i] . "|"; 													
							  }																															
							  else
							  { 
								 echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#FFFFFF; border:solid 2px; border-color:#7A7A7A;'>&nbsp;&nbsp;<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a>&nbsp;&nbsp;</td>"; 
							  }
						  } 
						 
						  if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
						   { 
						      /* echo " <td>&nbsp;&nbsp;<a class='link1' href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a></td>"; */
					          }
					     
						    if($this->InfoArray["NEXT_PAGE"]) { 
					          /*  echo "<td>&nbsp;&nbsp;<a class='link1' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;"; */
					
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }  
						  echo "</td></tr></table>";
					   }
					   /* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						  //echo " <a href='$PHP_SELF?page=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					  
					   if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
			else
			{
				if($prevnext==1)
			    {
					/* Print out our prev link */ 
					   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					   {
					   if($this->InfoArray["PREV_PAGE"]) 
					   { 
					   		
						//  echo "<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;"; 
					   		
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					   /* Print out our next link */ 
					   
					   if($this->InfoArray["NEXT_PAGE"]) 
					  
					   {  
						 // echo "&nbsp;<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>Next</a>&nbsp;"; 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }
					   
					  } 
				}			   
				if($dpaging==1 || $dpaging==2)
				{
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='javascript:".$paggingfunction."(1);'>First</a>&nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($InfoArray["PREV_PAGE"]) 
					   { 
						 // echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'>Previous</a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   /* Example of how to print our number links! */ 
					   
					   /* Print out our next link */ 
						   echo "<table border='0' cellpadding='0' cellspacing='0'><tr>";
		           				
						    if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					       {
					          if($this->InfoArray["PREV_PAGE"]) 
					         { 
					   	        /*echo "<td><a class='link1' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;</td>";*/ 
					   		   }
					           else
					           { 
						           // echo "Previous | &nbsp;&nbsp;"; 
					             } 
								 
								 if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					             { 
						             echo "<td><a href='javascript:".$paggingfunction."(1);' class='link1'>First</a>&nbsp;&nbsp;</td>"; 
					                }
					                else
					                { 
						                //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					                  }
						      } 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#7A7A7A; border:solid 2px; border-color:#FFFFFF;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								 //echo $this->InfoArray["PAGE_NUMBERS"][$i] . ""; 
							  }
							  else
							  { 
								 echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#FFFFFF; border:solid 2px; border-color:#CC00FF;'><a href=javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].",'".$temp_pagevars."');>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>"; 
							  } 
						  } 

						       if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					          {/* 
						         echo "<td>&nbsp;&nbsp;<a href='javascript:".$paggingfunction."(".$this->InfoArray["TOTAL_PAGES"].");' class='link1'>Last</a></td>"; */
					             }
			
						    if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					       {
						  
						      if($this->InfoArray["NEXT_PAGE"]) 
					         {  
						      /*  echo "<td>&nbsp;<a class='link1' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>&nbsp;Next</a></td>"; */
						       // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					           } else { 
						        //echo " Next&nbsp;&nbsp;"; 
					           }
					        }
						  echo "</tr></table>";
						   
						 /*  for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } */
					   }
					   /* Print out our next link */ 
					   if($InfoArray["NEXT_PAGE"]) { 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					    if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Last</a>"; 
					    }
					     else
					    { 
						  //echo " &gt;&gt;"; 
					     }
					}
				}
			}
		}
	}
	function onlyPagging_New($page,$per_page,$totallink,$dpaging = 0,$prevnext = 0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$temp_pagevars='', $current_page='')
	{
	   if($current_page=='')
       {
        $PHP_SELF=$PHP_SELF;
       }
       else
       {
        $PHP_SELF=$current_page;
       }
	   
	  if($withpagging==1)
	   {
		   if($paggingtype=="get")
		   {
			  if($prevnext==1)
			  {
				  if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
					   /* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='$PHP_SELF?page=1".$extrapara."'>First</a>&nbsp;&nbsp;"; 
					  }
					   /* Print out our prev link */ 
				   }
				}
			  
			   if($dpaging==1 || $dpaging==2)
			   {
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						echo "<div class='pagination-tt clearfix'><ul>";
						 if($this->InfoArray["PREV_PAGE"]) 
					   { 
						  echo "<li><a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."'>Previous</a></li>"; 
					   }
					   
					      if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  echo "<li><a href='$PHP_SELF?page=1".$extrapara."'>First</a></li>"; 
					  }
					   /* Print out our next link */ 
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo "<li><span>".$this->InfoArray["PAGE_NUMBERS"][$i]."</span></li>"; 
								//echo $this->InfoArray["PAGE_NUMBERS"][$i] . "|"; 													
							  }																															
							  else  
							  { 
								 echo "<li><a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></li>"; 
							  }
						  } 
						 
						  if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
						   { 
						       echo "<li><a href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a></li>"; 
					          }
					     
						    if($this->InfoArray["NEXT_PAGE"]) { 
					            echo "<li><a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>"; 
					
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }  
						  echo "</li></ul></div>";
					   }
					   /* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						  //echo " <a href='$PHP_SELF?page=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					  
					   if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
			else
			{
				if($prevnext==1)
			    {
					/* Print out our prev link */ 
					   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					   {
					   if($this->InfoArray["PREV_PAGE"]) 
					   { 
					   		
						//  echo "<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;"; 
					   		
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					   /* Print out our next link */ 
					   
					   if($this->InfoArray["NEXT_PAGE"]) 
					  
					   {  
						 // echo "&nbsp;<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>Next</a>&nbsp;"; 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }
					   
					  } 
				}			   
				if($dpaging==1 || $dpaging==2)
				{
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='javascript:".$paggingfunction."(1);'>First</a>&nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($InfoArray["PREV_PAGE"]) 
					   { 
						 // echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'>Previous</a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   /* Example of how to print our number links! */ 
					   
					   /* Print out our next link */ 
						   echo "<div class='titleblue_text1'><table border='0' cellpadding='0' cellspacing='0'><tr>";
		           				
						    if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					       {
					          if($this->InfoArray["PREV_PAGE"]) 
					         { 
					   	        echo "<td><a class='titleblue_text1' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;</td>"; 
					   		   }
					           else
					           { 
						           // echo "Previous | &nbsp;&nbsp;"; 
					             } 
								 
								 if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					             { 
						             echo "<td><a href='javascript:".$paggingfunction."(1);'>First</a></td>&nbsp;&nbsp;"; 
					                }
					                else
					                { 
						                //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					                  }
						      } 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#999999;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								 //echo $this->InfoArray["PAGE_NUMBERS"][$i] . ""; 
							  }
							  else
							  { 
								 echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#CCCCCC;'><a href=javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].",'".$temp_pagevars."');>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>"; 
							  } 
						  } 

						       if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					          { 
						         echo "<td>&nbsp;&nbsp;<a href='javascript:".$paggingfunction."(".$this->InfoArray["TOTAL_PAGES"].");'>Last</a></td>"; 
					             }
			
						    if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					       {
						  
						      if($this->InfoArray["NEXT_PAGE"]) 
					         {  
						        echo "<td>&nbsp;<a class='titleblue_text1' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>&nbsp;Next</a></td>"; 
						       // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					           } else { 
						        //echo " Next&nbsp;&nbsp;"; 
					           }
					        }
						  echo "</tr></table></div>";
						   
						 /*  for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } */
					   }
					   /* Print out our next link */ 
					   if($InfoArray["NEXT_PAGE"]) { 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					    if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Last</a>"; 
					    }
					     else
					    { 
						  //echo " &gt;&gt;"; 
					     }
					}
				}
			}
		}
	}    
	//function for paging
	function onlyPagging2($page,$per_page,$totallink,$dpaging = 0,$prevnext = 0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$temp_pagevars='')
	{
	  if($withpagging==1)
	   {
		   if($paggingtype=="get")
		   {
			  if($prevnext==1)
			  {
				  if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
					   /* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='$PHP_SELF?page=1".$extrapara."'>First</a>&nbsp;&nbsp;"; 
					  }
					   /* Print out our prev link */ 
				   }
				}
			  
			   if($dpaging==1 || $dpaging==2)
			   {
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						echo "<table border='0' cellpadding='0' cellspacing='0'><tr>";
						if($this->InfoArray["PREV_PAGE"]) 
					   { 
						  //echo "<td><a class='link1' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."'>Previous</a></td>"; 
					   }
					   
					      if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						 // echo "<td>&nbsp;&nbsp;<a href='$PHP_SELF?page=1".$extrapara."' class='link1'>First</a>&nbsp;&nbsp;</td>"; 
					  }
					   /* Print out our next link */ 
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo "<td>&nbsp;&nbsp;</td><td align='center' width='15' height=18 style='background-color:#7A7A7A; border:solid 2px; border-color:#FFFFFF;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								//echo $this->InfoArray["PAGE_NUMBERS"][$i] . "|"; 													
							  }																															
							  else
							  { 
								 echo "<td>&nbsp;&nbsp;</td><td align='center' width='15' height=18 style='background-color:#FFFFFF; border:solid 2px; border-color:#7A7A7A;'><a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>"; 
							  }
						  } 
						 
						  if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
						   { 
						       //echo " <td>&nbsp;&nbsp;<a class='link1' href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a></td>"; 
					          }
					     
						    if($this->InfoArray["NEXT_PAGE"]) { 
					            //echo "<td>&nbsp;&nbsp;<a class='link1' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;"; 
					
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }  
						  echo "</td></tr></table>";
					   }
					   /* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						  //echo " <a href='$PHP_SELF?page=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					  
					   if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
			else
			{
				if($prevnext==1)
			    {
					/* Print out our prev link */ 
					   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					   {
					   if($this->InfoArray["PREV_PAGE"]) 
					   { 
					   		
						//  echo "<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;"; 
					   		
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					   /* Print out our next link */ 
					   
					   if($this->InfoArray["NEXT_PAGE"]) 
					  
					   {  
						 // echo "&nbsp;<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>Next</a>&nbsp;"; 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }
					   
					  } 
				}			   
				if($dpaging==1 || $dpaging==2)
				{
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='javascript:".$paggingfunction."(1);'>First</a>&nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($InfoArray["PREV_PAGE"]) 
					   { 
						 // echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'>Previous</a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   /* Example of how to print our number links! */ 
					   
					   /* Print out our next link */ 
						   echo "<table border='0' cellpadding='0' cellspacing='0'><tr>";
		           				
						    if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					       {
					          if($this->InfoArray["PREV_PAGE"]) 
					         { 
					   	        echo "<td><a class='link1' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;</td>"; 
					   		   }
					           else
					           { 
						           // echo "Previous | &nbsp;&nbsp;"; 
					             } 
								 
								 if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					             { 
						             /*echo "<td><a href='javascript:".$paggingfunction."(1);' class='link1'>First</a>&nbsp;&nbsp;</td>"; */
					                }
					                else
					                { 
						                //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					                  }
						      } 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#7A7A7A; border:solid 2px; border-color:#FFFFFF;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								 //echo $this->InfoArray["PAGE_NUMBERS"][$i] . ""; 
							  }
							  else
							  { 
								 echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#FFFFFF; border:solid 2px; border-color:#7A7A7A;'><a href=javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].",'".$temp_pagevars."');>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>"; 
							  } 
						  } 

						       if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					          { 
						         echo "<td>&nbsp;&nbsp;<a href='javascript:".$paggingfunction."(".$this->InfoArray["TOTAL_PAGES"].");' class='link1'>Last</a></td>"; 
					             }
			
						    if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					       {
						  
						      if($this->InfoArray["NEXT_PAGE"]) 
					         {  
						        echo "<td>&nbsp;<a class='link1' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>&nbsp;Next</a></td>"; 
						       // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					           } else { 
						        //echo " Next&nbsp;&nbsp;"; 
					           }
					        }
						  echo "</tr></table>";
						   
						 /*  for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } */
					   }
					   /* Print out our next link */ 
					   if($InfoArray["NEXT_PAGE"]) { 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					    if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Last</a>"; 
					    }
					     else
					    { 
						  //echo " &gt;&gt;"; 
					     }
					}
				}
			}
		}
	}

}
?>
