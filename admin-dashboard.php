<?php session_start();
include "includes/config.php";

if($_SESSION['admin']=='' or $_SESSION['admin']!="yes") 
 {
    print "<META http-equiv='refresh' content='0;URL=admin-login.php'>";	
    exit;
 }
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Admin - Dashboard</title>
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
            	<h1>Admin - Dashboard</h1>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
            	<div class="col-lg-3"></div>
                <div class="col-lg-6">
                	<div class="dashbord_bt">
                    	<ul>
                            <li><a href="admin-manage-client.php" class="btn-primary">Manage Client</a></li>
                            <li><a href="admin-manage-rep.php" class="btn-primary">Manage Rep</a></li>
                            <li><a href="" class="btn-primary">Manage Archives</a></li>
                            <li><a href="admin.php" class="btn-primary">Update DBs</a></li>
                            <li><a href="" class="btn-primary">Estatistics</a></li>
                            <li><a href="crawler.php" class="btn-primary">RUN Crawlers</a></li>
                            <li><a href="admin-codes.php" class="btn-primary">CODEs</a></li>
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