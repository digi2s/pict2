<?php session_start();
include "includes/config.php";

if($_SESSION['admin']=='' or $_SESSION['admin']!="yes" or $_GET['cid']=="") 
 {
    print "<META http-equiv='refresh' content='0;URL=admin-login.php'>";	
    exit;
 }

$qry = "select * from client where c_id_key='".$_GET['cid']."'";
$rs= $con->recordselect($qry);
$row=mysqli_fetch_array($rs); 

$level = $row['clevel'];
$cstatus = '';
if($row['cstatus']=='1')
{
    $cstatus = "Active";
}
else
{
    $cstatus = "Deactive";
}

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Admin - Client Edit</title>
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
            	<h1>Admin - Client Edit</h1>
                
            </header>
        </div>
        <div id="main-wrapper">
        <form action="action.php" method="post" name="frm_contact" id="frm_contact">
        <input type="hidden" name="frm_action" value="admin_client_edit" />
         <input type="hidden" name="cid" value="<?=$_GET['cid'];?>" />
            <div class="container">
            <div class="col-lg-12">
                    <div class="totle_pic_div">
                    ID: <?=$row['cid'];?>  <br /><br />
                    	Change Level 
                        <select name="level">
                            <option value="0" <?php if($level=="0"){?> selected <? } ?>>0</option>
                            <option value="1" <?php if($level=="1"){?> selected <? } ?>>1</option>
                            <option value="2" <?php if($level=="2"){?> selected <? } ?>>2</option>
                            <option value="3" <?php if($level=="3"){?> selected <? } ?>>3</option>
                            <option value="4" <?php if($level=="4"){?> selected <? } ?>>4</option>
                            <option value="5" <?php if($level=="5"){?> selected <? } ?>>5</option>
                            <option value="6" <?php if($level=="6"){?> selected <? } ?>>6</option>
                            <option value="7" <?php if($level=="7"){?> selected <? } ?>>7</option>
                            <option value="8" <?php if($level=="8"){?> selected <? } ?>>8</option>
                            <option value="9" <?php if($level=="9"){?> selected <? } ?>>9</option>
                            <option value="10" <?php if($level=="10"){?> selected <? } ?>>10</option>
                        </select>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Change Status 
                        <select name="status">
                            <option value="1" <?php if($row['cstatus']=="1"){?> selected <? } ?>>Active</option>
                            <option value="0" <?php if($row['cstatus']=="0"){?> selected <? } ?>>Inactive</option>
                        </select>  
                        
                    </div>
                </div>
                <div class="col-lg-12">
                	<div class="contact_form_div">
                        
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Name</label>
                                <input value="<?=$row['cname'];?>" id="name" name="name" type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Email</label>
                                <input value="<?=$row['cemail'];?>" id="email" name="email" type="email" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Phone</label>
                                <input value="<?=$row['cphone'];?>" id="phone" name="phone" type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="message">Address</label>
                                <textarea id="message" name="message" class="form-control"><?=$row['caddress'];?></textarea>
                              </div>
                            </div>
                            <div class="col-sm-12">
                            	<div class="form-group-bt">
                                    <a href="admin-client-change-password.php?cid=<?=$_GET['cid'];?>" class="btn-primary">Change Password</a>
                              		<button type="submit" class="btn-primary" onclick="return checkform();">Save</button>
                                    <a href="admin-manage-client.php" class="btn-primary">Back</a>
                                </div>
                            </div>
            		
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</body>
</html>