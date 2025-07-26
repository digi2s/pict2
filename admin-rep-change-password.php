<?php session_start();
include "includes/config.php";

if($_SESSION['admin']=='' or $_SESSION['admin']!="yes" or !isset($_GET['rid']))
{
    print "<META http-equiv='refresh' content='0;URL=admin-login.php'>";
    exit;
}

$rid = filter_input(INPUT_GET, 'rid', FILTER_SANITIZE_NUMBER_INT);
$stmt = mysqli_prepare($con->linki, "select * from model where r_id_key=?");
mysqli_stmt_bind_param($stmt, 'i', $rid);
mysqli_stmt_execute($stmt);
$rs = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($rs);
mysqli_stmt_close($stmt);

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Admin - Rep Change Password</title>
        <meta name="robots" content="index, follow" />
		<link rel="icon" href="images/favicon.png" type="image/png">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description"  content="" />
        <meta name="keywords"  content="" />
		<link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <div id="wrapper">
        <div id="header-wrapper">
            <header id="header" class="container">
            	<h1>Admin - Rep Change Password</h1>
                
            </header>
        </div>
        <div id="main-wrapper">
        
            <div class="container">
            <div class="col-lg-12">
                    <div class="totle_pic_div">
                    ID: <?=$row['rid'];?>
                    </div>
                </div>
                <div class="col-lg-12">
                	<div class="contact_form_div">
                        
                            <form action="action.php" method="post" name="frm_contact" id="frm_contact" onsubmit="return check_contact();">
                         <?php if($_SESSION['rep_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div"><?=$_SESSION['rep_msg'];?></div></div>
                    <? $_SESSION['rep_msg']=''; } ?>
                        <input type="hidden" name="frm_action" value="admin_rep_change_password" />
                        <input type="hidden" name="r_id_key" value="<?=$_GET['rid'];?>" />
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Current Password</label>
                                <input data-validation="required" value="<?=base64_decode($row['rpassword']);?>" id="current_password" name="current_password" type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">New Passoword</label>
                                <input data-validation="required" value="" id="new_password" name="new_password" type="password" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Confirm Password</label>
                                <input data-validation="required" value="" id="confirm_password" name="confirm_password" type="password" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                            	<div class="form-group-bt">
                              		<button type="submit" class="btn-primary" onclick="return checkform();">Save</button>
                                    <a href="admin-manage-client.php" class="btn-primary">Back</a>
                                </div>
                            </div>
            		</form>
            		
                    </div>
                </div>
            </div>
            
        </div>
    </div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>

  $.validate({
    modules : 'location, date, security, file',
  });
  
 function check_contact()
 {

    if(document.getElementById('new_password').value != document.getElementById('confirm_password').value)
    {
        alert("Confirm password not matched.")
        return false;
    }
    return true;
 } 
</script>    
</body>
</html>