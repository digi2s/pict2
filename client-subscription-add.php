<?php session_start();
include "includes/config.php";

if($_SESSION['user_id']=='' or $_SESSION['user_type_r']!="client") 
 {
    print "<META http-equiv='refresh' content='0;URL=client-login.php'>";	
    exit;
 }

$qry = "select * from client where c_id_key='".$_SESSION['user_id']."'";
$rs= $con->recordselect($qry);
$row=mysqli_fetch_array($rs); 



?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Client - New Subscriptions</title>
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
            	<h1>Client - New Subscriptions</h1>
                <h4>ID: <?=$_SESSION['cid'];?> - <?=$_SESSION['user_email'];?></h4>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
            
                <div class="col-lg-12">
                	<div class="contact_form_div">
                        <form action="action.php" method="post" name="frm_contact" id="frm_contact" onsubmit="return check_contact()">
                         <?php if($_SESSION['rep_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div"><?=$_SESSION['rep_msg'];?></div></div>
                    <? $_SESSION['rep_msg']=''; } ?>
                        <input type="hidden" name="frm_action" value="client_new_subscription" />
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Insert Code</label>
                                <input data-validation="required" value="" id="code" name="code" type="text" class="form-control">
                              </div>
                            </div>
                           
                            <div class="col-sm-12">
                            	<div class="form-group-bt">
                              		<button type="submit" class="btn-primary" >Add</button>
                                    <a href="client-manage-subscription.php" class="btn-primary">Back</a>
                                </div>
                            </div>
            		</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>

  $.validate({
    modules : 'location, date, security, file',
  });
</script>
</html>