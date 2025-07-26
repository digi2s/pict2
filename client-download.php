<?php session_start();
include "includes/config.php";

if($_SESSION['user_id']=='' or $_SESSION['user_type_r']!="client") 
 {
    print "<META http-equiv='refresh' content='0;URL=client-login.php'>";	
    exit;
 }

$qry = "select * from client where c_id_key='".$_SESSION['user_id']."'";
$rs= $con->recordselect($qry);
$row1=mysqli_fetch_array($rs); 



?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Client - Download</title>
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
            	<h1>Client - Download</h1>
                <h4>ID: <?=htmlspecialchars($_SESSION['cid'], ENT_QUOTES, 'UTF-8');?> - <?=htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8');?></h4>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
            
                <div class="col-lg-12">
                	<div class="contact_form_div">
                        <form action="client-download-img.php" method="post" name="frm_contact" id="frm_contact">
                         <?php if($_SESSION['rep_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div"><?=htmlspecialchars($_SESSION['rep_msg'], ENT_QUOTES, 'UTF-8');?></div></div>
                    <? $_SESSION['rep_msg']=''; } ?>
                        <input type="hidden" name="frm_action" value="client_download" />
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Model</label>
                                <select name="rid" id="rid" class="form-control">
                                <?php
                                    $qry = "select * from sub where cid='".$_SESSION['cid']."' && sstatus='1'";
                                    $rs= $con->recordselect($qry);
                                    while($row=mysqli_fetch_array($rs))
                                    {   
                                     $qry_model = "SELECT * FROM model where rid='".$row['rid']."'";
                                     $rs_model = $con->recordselect($qry_model);
                                     $row_model = mysqli_fetch_array($rs_model);
          
                                ?>
                                    <option <?php if($row['sdefault']=="1"){?> selected="" <? } ?> value="<?=htmlspecialchars($row['rid'], ENT_QUOTES, 'UTF-8');?>"><?=htmlspecialchars($row_model['rname'], ENT_QUOTES, 'UTF-8');?> - <?=htmlspecialchars($row['rid'], ENT_QUOTES, 'UTF-8');?></option>
                                   <? } ?>
                                </select>
                              </div>
                            </div>
                            <?php /*
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Path</label>
                                <input data-validation="required" value="<?=htmlspecialchars($row1['cdpath'], ENT_QUOTES, 'UTF-8');?>" id="path" name="path" type="text" class="form-control">
                                <br />For Example: <strong>C:\Users\Public\</strong>
                              </div>
                            </div>
                           <? */ ?>
                            <div class="col-sm-12">
                            	<div class="form-group-bt">
                              		<button type="submit" class="btn-primary" >Download</button>
                                    <a href="client-dashboard.php" class="btn-primary">Back</a>
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