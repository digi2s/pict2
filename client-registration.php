<?php session_start();
include "includes/config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Client Registration</title>
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
            	<h1>Client Registration</h1>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
                <div class="col-lg-12">
                	<div class="contact_form_div">
                        <form action="client-registration-confirmation.php" method="post" name="frm_contact" id="frm_contact" onsubmit="return check_contact()">
                        <input type="hidden" name="frm_action" value="rep_register" /> 
                        <?php if($_SESSION['rep_reg_msg']!="")
                    {?>
                       <div class="col-sm-12"><div class="msg_div"><?=$_SESSION['rep_reg_msg'];?></div></div>
                    <? $_SESSION['rep_reg_msg']=''; } ?>
                           <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Client Reg CODE</label>
                                <input data-validation="required" id="user" name="user" type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Name</label>
                                <input data-validation="required" id="name" name="name" type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Email</label>
                                <input data-validation="email required" id="email" name="email" type="email" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="email">Password</label>
                                <input data-validation="required" id="password" name="password" type="password" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="email">Confirm Password</label>
                                <input data-validation="required" id="cpassword" name="cpassword" type="password" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Phone</label>
                                <input data-validation="required" id="phone" name="phone" type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="message">Address</label>
                                <textarea data-validation="required" id="message" name="message" class="form-control"></textarea>
                              </div>
                            </div>
                            <div class="col-sm-12">
                            	<div class="form-group-bt">
                              		<button type="submit" class="btn-primary" onclick="return checkform();">Submit</button>
                                    <a href="index.php" class="btn-primary">Back</a>
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
  
 function check_contact()
 {
    if(document.getElementById('password').value != document.getElementById('cpassword').value)
    {
        alert("Confirm password not matched.")
        return false;
    }
    return true;
 } 
</script>
</html>