<?php session_start();
error_reporting(0);
if($_SESSION['admin_db_msg']!="")
                     {?>
                        <?=htmlspecialchars($_SESSION['admin_db_msg'], ENT_QUOTES, 'UTF-8');?>
                     <? //$_SESSION['admin_db_msg']='';
                    
                    echo "<br />Please add another database in includes/config.php with username and password because existing database is deleted.";
                    exit;
                    } ?>
<?                    
include "includes/config.php";


?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Destroy DBs</title>
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
            	<h1>Destroy DBs</h1>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
                <div class="col-lg-12">
                	<div class="contact_form_div">
                        <form action="action.php" method="post" name="admin_db_destroy" id="admin_db_destroy" enctype="multipart/form-data" onsubmit="return check_destroy();">
                        <input type="hidden" name="frm_action" value="admin_destroy_db" /> 
                        <?php if($_SESSION['admin_db_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div"><?=htmlspecialchars($_SESSION['admin_db_msg'], ENT_QUOTES, 'UTF-8');?></div></div>
                    <? $_SESSION['admin_db_msg']=''; } ?>
                          
                           <div class="col-sm-12">
                           
                            </div>
                            <div class="col-sm-12">
                            	<div class="form-group-bt">
                              		<button type="submit" class="btn-primary">Destroy DB</button>
                                </div>
                            </div>
            		</form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
function check_destroy()
{
    if(window.confirm("Are you sure to destroy all tables from database?"))
    {
        return true
    }
    else
    {
        return false;
    }
}
</script>
</html>