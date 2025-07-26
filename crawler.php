<?php include "includes/config.php";
error_reporting(1);
ini_set('display_errors', 'On');
// Archive Yesterday's picture because today those will deleted

$yesterday = date('Y-m-d', strtotime('-1 day', strtotime(date('y-m-d'))));
$qry_model = "SELECT * FROM model WHERE rstatus = '1'";
$rs_model = $con->recordselect($qry_model);
while($row_model = mysqli_fetch_array($rs_model))
{
    $rid = $row_model['rid'];
    mkdir("/var/www/html/archive/", 0777, true);
  //  mkdir("archive/", 0777, true);
    
    $qry_pics = "SELECT * FROM picts WHERE pdate = '" . $yesterday."' && rid='".$rid."' && pstatus = '1' limit 0,1";
    $rs_pics = $con->recordselect($qry_pics);
    $row_pics = mysqli_fetch_array($rs_pics);
    $pbody = $row_pics['pbody'];
    
    $yesterday_str = date('mdY', strtotime('-1 day', strtotime(date('y-m-d'))));
    if($pbody!="")
    {
    $pics_name = "/var/www/html/archive/".$rid."_".$yesterday_str.".jpg";
  // $pics_name = "archive/".$rid."_".$yesterday_str.".jpg";
    if($pbody!="")
    {
        file_put_contents("$pics_name", $pbody);
    }
    }
}



// (1)	Delete all pictures whose pdate is less than current date or pstatus=0 from picts table
$qry_pic = "delete from `picts` where pdate < '" . date('Y-m-d') . "' or pstatus = '0'";
$rs_pic = $con->recordselect($qry_pic);

// (2)	Delete all folder from server for all reps.
deleteAll('pictures');
function deleteAll($str) 
{
    //It it's a file.
    if (is_file($str)) 
    {
        //Attempt to delete it.
        return unlink($str);
    }
    //If it's a directory.
    elseif (is_dir($str)) 
    {
        //Get a list of the files in this directory.
        $scan = glob(rtrim($str,'/').'/*');
        //Loop through the list of files.
        foreach($scan as $index=>$path) 
        {
            //Call our recursive function.
            deleteAll($path);
        }
        //Remove the directory itself.
        return @rmdir($str);
    }
}
if (!file_exists('pictures')) 
    {
        mkdir("/var/www/html/pictures", 0777, true);
    }

// (3)	Create model.rid folder of ACTIVE rep. And Download a picture from picts table who have pdate = today’s date and model.rid= picts.rid and picts.pstatus=1

$qry_model = "SELECT * FROM model WHERE rstatus = '1'";
$rs_model = $con->recordselect($qry_model);
while($row_model = mysqli_fetch_array($rs_model))
{
    $rid = $row_model['rid'];
    mkdir("/var/www/html/pictures/$rid", 0777, true);
    
    $qry_pics = "SELECT * FROM picts WHERE pdate = '" . date('Y-m-d')."' && rid='".$rid."' && pstatus = '1' limit 0,1";
    $rs_pics = $con->recordselect($qry_pics);
    $row_pics = mysqli_fetch_array($rs_pics);
    $pbody = $row_pics['pbody'];
    
    $pics_name = "/var/www/html/pictures/$rid/".$rid.".jpg";
    if($pbody!="")
    {
        file_put_contents("$pics_name", $pbody);
    }
}
?>
<a href="admin-dashboard.php">Back To Dashboard</a>