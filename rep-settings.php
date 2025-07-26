<?php session_start();
include "includes/config.php";

if($_SESSION['user_id']=='' or $_SESSION['user_type_r']!="rep") 
 {
    print "<META http-equiv='refresh' content='0;URL=rep-login.php'>";	
    exit;
 }

$qry = "select * from model where r_id_key='".$_SESSION['user_id']."'";
$rs= $con->recordselect($qry);
$row=mysqli_fetch_array($rs); 
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Rep Settings</title>
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
            	<h1>Rep Settings</h1>
                <h4>ID: <?=htmlspecialchars($_SESSION['rid'], ENT_QUOTES, 'UTF-8');?> - <?=htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8');?></h4>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
                <div class="col-lg-12">
                	<div class="contact_form_div">
                        <form action="action.php" method="post" name="frm_contact" id="frm_contact">
                         <?php if($_SESSION['rep_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div"><?=htmlspecialchars($_SESSION['rep_msg'], ENT_QUOTES, 'UTF-8');?></div></div>
                    <? $_SESSION['rep_msg']=''; } ?>
                        <input type="hidden" name="frm_action" value="rep_settings" />
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Name</label>
                                  <input value="<?=htmlspecialchars($row['rname'], ENT_QUOTES, 'UTF-8');?>" id="name" name="name" type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Email</label>
                                  <input value="<?=htmlspecialchars($row['remail'], ENT_QUOTES, 'UTF-8');?>" id="email" name="email" type="email" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Phone</label>
                                  <input value="<?=htmlspecialchars($row['rphone'], ENT_QUOTES, 'UTF-8');?>" id="phone" name="phone" type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="message">Address</label>
                                  <textarea  id="message" name="message" class="form-control"><?=htmlspecialchars($row['raddress'], ENT_QUOTES, 'UTF-8');?></textarea>
                              </div>
                            </div>
                            <div class="col-sm-12">
                            	<div class="form-group-bt">
                                    <a href="rep-change-password.php" class="btn-primary">Change Password</a>
                              		<button type="submit" class="btn-primary" onclick="return checkform();">Save</button>
                                    <a href="rep-dashboard.php" class="btn-primary">Back</a>
                                </div>
                            </div>
            		</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>