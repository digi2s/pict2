<?php session_start();
include "includes/config.php";

if($_SESSION['admin']=='' or $_SESSION['admin']!="yes" or $_GET['cid']=="") 
 {
    print "<META http-equiv='refresh' content='0;URL=admin-login.php'>";	
    exit;
 }

$qry_code = "SELECT * FROM valcode where vcid = '".$_GET['cid']."'";
 $rs_code = $con->recordselect($qry_code);
 $row_code = mysqli_fetch_array($rs_code);
 
 $qry_rep = "SELECT * FROM model where rid = '".$row_code['rid']."'";
 $rs_rep = $con->recordselect($qry_rep);
 $row_rep = mysqli_fetch_array($rs_rep);
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Admin - Rep Info</title>
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
            	<h1>Admin - Rep Info</h1>
                
            </header>
        </div>
        <div id="main-wrapper">
        
            <div class="container">
            <div class="col-lg-12">
                    <div class="totle_pic_div">
                    ID: <?=$row_rep['rid'];?> - <?=$row_rep['remail'];?>
                    </div>
                </div>
                <div class="col-lg-12">
                	<div class="contact_form_div">
                        
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Name:</label>
                                <?=$row_rep['rname'];?>
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Email</label>
                                <?=$row_rep['remail'];?>
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Phone</label>
                                <?=$row_rep['rphone'];?>
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="message">Address</label>
                                <?=$row_rep['raddress'];?>
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group center_bt">
                                <a href="admin-code-stats.php" class="btn-primary">Back</a>
                              </div>
                            </div>
                           
            		
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>