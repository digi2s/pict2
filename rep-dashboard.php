<?php session_start();
include "includes/config.php";

if($_SESSION['user_id']=='' or $_SESSION['user_type_r']!="rep") 
 {
    print "<META http-equiv='refresh' content='0;URL=rep-login.php'>";	
    exit;
 }
 
 $qry_up="update `picts` set pdelete='0' where rid='".$_SESSION['rid']."'";
 $con->update($qry_up);
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Rep - Dashboard</title>
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
            	<h1>Rep - Dashboard</h1>
                <h4>ID: <?=htmlspecialchars($_SESSION['rid'], ENT_QUOTES, 'UTF-8');?> - <?=htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8');?></h4>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
            	<div class="col-lg-3"></div>
                <div class="col-lg-6">
                	<div class="dashbord_bt">
                    	<ul>
                        	<li><a href="rep-single-upload.php" class="btn-primary">Single Upload</a></li>
                            <li><a href="rep-bulk-upload.php" class="btn-primary">Bulk Upload</a></li>
                            <li><a href="rep-manage-pictures.php" class="btn-primary">Manage Pictures</a></li>
                            <li><a href="rep-settings.php" class="btn-primary">Settings</a></li>
                            <li><a href="logout.php" class="btn-primary">Logout</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </div>
    </div>

</body>
</html>