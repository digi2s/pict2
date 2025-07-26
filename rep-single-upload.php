<?php session_start();
include "includes/config.php";

if($_SESSION['user_id']=='' or $_SESSION['user_type_r']!="rep") 
 {
    print "<META http-equiv='refresh' content='0;URL=rep-login.php'>";	
    exit;
 }
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Rep - Single Upload</title>
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
            	<h1>Rep - Single Upload</h1>
                <h4>ID: <?=htmlspecialchars($_SESSION['rid'], ENT_QUOTES, 'UTF-8');?> - <?=htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8');?></h4>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
                <div class="col-lg-12">
                	<div class="contact_form_div">
                        <form action="action.php" method="post" name="frm_single_upload" id="frm_single_upload" enctype="multipart/form-data">
                        <input type="hidden" name="frm_action" value="rep_single_upload" /> 
                          <?php if($_SESSION['rep_upload_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div"><?=htmlspecialchars($_SESSION['rep_upload_msg'], ENT_QUOTES, 'UTF-8');?></div></div>
                    <? $_SESSION['rep_upload_msg']=''; } ?>
                            <div class="col-sm-12">
                              <div class="form-group">
                                  <label for="fullname">ID: <?=htmlspecialchars($_SESSION['rid'], ENT_QUOTES, 'UTF-8');?></label>
                              </div>
                            </div>
                           <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Upload Your Picture</label>
                                <input data-validation="mime dimension required" data-validation-allowing="jpg, png, gif, raw" data-validation-dimension="max4500x3500" type="file" name="picture" />
                              </div>
                            </div>
                            <div class="col-sm-12">
                            	<div class="form-group-bt">
                              		<button type="submit" class="btn-primary">Submit</button>
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>

  $.validate({
    modules : 'location, date, security, file',
  });
</script>
</html>