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
		<title>Rep - Bulk Upload</title>
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
            	<h1>Rep - Bulk Upload</h1>
                <h4>ID: <?=$_SESSION['rid'];?> - <?=$_SESSION['user_email'];?></h4>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
                <div class="col-lg-12">
                	<div class="submit-section">
                                <div class="file_upload">
                                <form action="file_upload.php" class="dropzone" method="post">
                                </form>
                                
                                <div class="up-preview">
                           	    <div class="row-images">
                                    <a href="rep-dashboard.php" class="btn-primary">Back</a>
                                </div>
                                </div>
                           
                                </div>
						</div>
                </div>
            </div>
        </div>
    </div>
    
    
</body>

	<script>
		jQuery(document).ready(function() {       
			// initiate layout and plugins
			App.init();
			Gallery.init();
		});
	</script>
    
    <script type="text/javascript" src="assets/js/dropzone.js"></script>
</html>