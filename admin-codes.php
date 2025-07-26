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
		<title>Admin - Codes</title>
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
            	<h1>Admin - Codes</h1>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
            	<?php if($_SESSION['rep_manage_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div"><?=$_SESSION['rep_manage_msg'];?></div></div>
                    <? $_SESSION['rep_manage_msg']=''; } ?>
                <div class="col-lg-12">
                	<div class="admin_bt">
                    	<ul>
                            <li><a href="admin-code-create.php" class="btn-primary">Create Codes</a></li>
                            <li><a href="admin-code-assign.php" class="btn-primary">Manage Codes</a></li>
                            <li><a href="admin-code-stats.php" class="btn-primary">Code Stats</a></li>
                            <li><a href="admin-dashboard.php" class="btn-primary">Back</a></li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</body>
</html>