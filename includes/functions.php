<?php

function string_replace($str)
{
	$str = trim($str);
	$str = str_replace("'", "&#39;", $str);
	$str = str_replace("\"", "&#34;", $str);

  //

	return $str;
}

//

function currentPageName()
{
	$currentFile = $_SERVER["PHP_SELF"];
  $parts = explode('/', $currentFile);

  //

  return $parts[count($parts) - 1];
}

//

function FetchQuery_fld_id($table, $field, $id)
{
	$con1 = new DBconn();
	$q = "SELECT * FROM $table WHERE $field = " . isInteger($id);
	$rs = $con1->recordselect($q);

  //

	return mysqli_fetch_array($rs);
}

//

function Count_rows_by_value($table, $field, $value)
{
	$con1 = new DBconn();
	$q = "SELECT * FROM $table WHERE $field = '" . $value . "'";
	$rs = $con1->recordselect($q);

  //

	return mysqli_num_rows($rs);
}
function Count_rows_by_value_NOT($table, $field, $value)
{
	$con1 = new DBconn();
	$q = "SELECT * FROM $table WHERE $field != '" . $value . "'";
	$rs = $con1->recordselect($q);

  //

	return mysqli_num_rows($rs);
}

//

function Count_rows($table)
{
	$con1 = new DBconn();
	$q = "SELECT * FROM $table";
	$rs = $con1->recordselect($q);

  //

	return mysqli_num_rows($rs);
}

//

function nofollow($html, $skip = null)
{
  return preg_replace_callback(
    "#(<a[^>]+?)>#is", function ($mach) use ($skip) {
      return (
        !($skip && strpos($mach[1], $skip) !== false) &&
        strpos($mach[1], 'rel=') === false
      ) ? $mach[1] . ' rel="nofollow">' : $mach[0];
    },
    $html
  );
}

//

function titleLimit($str, $limit = 60)
{
  return substr($str, 0, $limit);
}

//

function noHTML($input, $limit = 60, $encoding = 'UTF-8')
{
  if ($limit == 0)
  {
    return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
  }
  else if (strlen($input) > $limit) 
  {
    return titleLimit(htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding), $limit) . '...';
  }
  else
  {
    return titleLimit(htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding), $limit);
  }
}

//

function locationUrlEncode($str)
{
	$str = trim($str);
  $str = str_replace('/', '!', $str);
  $str = str_replace('\'', '_', $str);
  $str = str_replace('--', '$', $str);
  $str = str_replace('-', '~', $str);
  $str = str_replace(' ', '-', $str);
  $str = strtolower($str);
  $str = rawurlencode($str);

  //

  return $str;
}

//

function locationUrlDecode($str)
{
	$str = trim($str);
  $str = rawurldecode($str);
  $str = str_replace('-', ' ', $str);
  $str = str_replace('~', '-', $str);
  $str = str_replace('$', '--', $str);
  $str = str_replace('_', '\'', $str);
  $str = str_replace('!', '/', $str);

  //

  return $str;
}

//

function fixUrlEncode($str, $limit = 60)
{
  $str = str_replace(' ', '-', $str);
  $str = preg_replace('/[^A-Za-z0-9\-]/', '', strtolower($str));
  $str = preg_replace('/-+/', '-', $str);
  $str = substr($str, 0, $limit);
  $str = trim($str, '-');
  $str = trim($str);

  //

  return $str;
}

//

function fixTag($str, $limit = 100)
{
	$str = trim($str);
  $str = preg_replace('/[^A-Za-z0-9\- ]/', '', $str);
  $str = preg_replace('/-+/', '-', $str);
  $str = preg_replace('/ +/', ' ', $str);
	$str = trim($str, ' -');
  $str = substr($str, 0, $limit);

  //

  return $str;
}

//

function hexEscape($str, $extra = "")
{
  $str = bin2hex($str . $extra);
  return "UNHEX('". $str . "')";
}

//

function isInteger($str)
{
  $str = sprintf("%u", $str);
  return $str;
}

function timeAgo($time_ago)
{
    
//    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    
    $time_elapsed   = ($cur_time - $time_ago);
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "1 hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "1 week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "1 month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "1 year ago";
        }else{
            return "$years years ago";
        }
    }
}

function clean($string) 
{
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}  

?>
