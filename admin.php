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
		<title>Admin</title>
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
            	<h1>Admin</h1>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
            <?php if($_SESSION['admin_db_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div"><?=htmlspecialchars($_SESSION['admin_db_msg'], ENT_QUOTES, 'UTF-8');?></div></div>
                    <? $_SESSION['admin_db_msg']=''; } ?>
                <div class="col-lg-12">
                
                	<div class="admin_bt">
                    	<ul>
                            <li><a href="javascript:void(0);" onclick="admin_DB_destroy();" class="btn-primary">Destroy DBs UI</a></li>
                        	<li><a href="javascript:void(0);" onclick="admin_DB_create();" class="btn-primary">Create DBs UI</a></li>
                            <li><a href="view-dbs.php" class="btn-primary">View DBs UI</a></li>
                            <li><a href="admin-dashboard.php" class="btn-primary">Back</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<form action="action.php" method="post" name="admin_db_destroy" id="admin_db_destroy" enctype="multipart/form-data">
      <input type="hidden" name="frm_action" value="admin_destroy_db" />
</form>
<form action="action.php" method="post" name="admin_db_create" id="admin_db_create" enctype="multipart/form-data">
                        <input type="hidden" name="frm_action" value="admin_create_db" /> 
</form>                          
<script>
    function admin_DB_destroy()
    {
        if(window.confirm("Are you sure to destroy all tables from database?"))
        {
            document.admin_db_destroy.submit();
        }
    }
    function admin_DB_create()
    {
        if(window.confirm("Are you sure to create tables for database?"))
        {
            document.admin_db_create.submit();
        }
    }
</script>                      
</body>
</html>