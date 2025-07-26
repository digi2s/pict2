<?php session_start();
include "includes/config.php";

if(!empty($_FILES))
{
    $pic_name = $_FILES['file']['name'];
    
     $qry_pic_name = "SELECT * FROM picts WHERE name = '" . $pic_name . "'";
     $rs_pic_name = $con->recordselect($qry_pic_name);
     $no_pic_name = mysqli_num_rows($rs_pic_name);
     if($no_pic_name>0)
     {
            exit;
     }
     
    $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $imagetmp= addslashes (file_get_contents($_FILES['file']['tmp_name']));
    
     $qry_pic = "SELECT * FROM picts WHERE rid = '" . $_SESSION['rid'] . "' && pdate >= '" . date('Y-m-d') . "' && pstatus = '1'";
     $rs_pic = $con->recordselect($qry_pic);
     $no_pic = mysqli_num_rows($rs_pic);
     
     $pdate = date('Y-m-d', strtotime(date('Y-m-d') . " +$no_pic day"));
      $pic_name = $_FILES['file']['name'];
     
    $qry_in = "insert into `picts`(`pbody`,`name`,`pupdate`,`rid`,`pdate`,`pstatus`)values('{$imagetmp}','".mysqli_real_escape_string($con->linki,$pic_name)."','".date('Y-m-d H:i:s')."','".$_SESSION['rid']."','".$pdate."','1')";
    $con->insert($qry_in);
}
?>