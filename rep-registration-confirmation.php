<?php session_start();
include "includes/config.php";

$pos = strpos($_POST['user'], 'R');
if($pos === false) {
    $_SESSION['rep_reg_msg'] =  "Rep Reg CODE not valid, please try again.";
    print "<META http-equiv='refresh' content='0;URL=rep-registration.php'>";	
   exit;
}
$c_date = date('Y-m-d');
$qry_code = "SELECT * FROM valcode WHERE vterm>='".$c_date."' && vcode = '" . $_POST['user'] . "' && vstatus = '1' && rid IS NOT NULL";
$rs_code = $con->recordselect($qry_code);
$no_code = mysqli_num_rows($rs_code);
if($no_code <= 0) 
{
    $_SESSION['rep_reg_msg'] =  "Rep Reg CODE not valid, please try again.";
    print "<META http-equiv='refresh' content='0;URL=rep-registration.php'>";	
    exit;
}
    
$row_code = mysqli_fetch_array($rs_code);
$vcode = $row_code['vcode'];
$vtype = $row_code['vtype'];
$vtimes = ($row_code['vtimes'] + 1);
        
$vtype_times = substr($vtype,1,strlen($vtype));

if($vtype_times!='0')
{
    if($vtimes>$vtype_times)
    {
        $_SESSION['rep_reg_msg'] =  "Rep Reg CODE not valid, please try again.";
        print "<META http-equiv='refresh' content='0;URL=rep-registration.php'>";	
        exit;
    }
}

$qry_code = "SELECT * FROM model WHERE remail = '" . $_POST['email'] . "'";
$rs_code = $con->recordselect($qry_code);
$no_code = mysqli_num_rows($rs_code);
if($no_code > 0) 
{
    $_SESSION['rep_reg_msg'] =  "Email id already in use. Please use another email id";
    print "<META http-equiv='refresh' content='0;URL=rep-registration.php'>";	
    exit;
}

$rep_rid = "R510000001";
                
                $qry_check = "SELECT * FROM model order by r_id_key";
                $rs_check = $con->recordselect($qry_check);
                $no_rep = mysqli_num_rows($rs_check);
                
                if($no_rep>0)
                {
                    $rep_rid = "R".(510000001+$no_rep);
                }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Rep Registration Confirmation</title>
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
            	<h1>Rep Registration Confirmation</h1>
            </header>
        </div>
        <form action="action.php" method="post" name="frm_contact" id="frm_contact">
        <input type="hidden" name="frm_action" value="rep_register" />
         
        <input type="hidden" name="user" value="<?=$_POST['user'];?>" />
        <input type="hidden" name="name" value="<?=$_POST['name'];?>" />
        <input type="hidden" name="email" value="<?=$_POST['email'];?>" />
        <input type="hidden" name="password" value="<?=$_POST['password'];?>" />
        <input type="hidden" name="phone" value="<?=$_POST['phone'];?>" />
        <input type="hidden" name="message" value="<?=$_POST['message'];?>" />
        <input type="hidden" name="rep_rid" value="<?=$rep_rid;?>" />
        <div id="main-wrapper">
            <div class="container">
                <div class="col-lg-12">
                	<div class="col-lg-6">
                    <span class="conf_tit_text">Name</span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_dis_text"><?=$_POST['name'];?></span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_tit_text">Email</span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_dis_text"><?=$_POST['email'];?></span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_tit_text">Password</span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_dis_text">******</span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_tit_text">Phone</span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_dis_text"><?=$_POST['phone'];?></span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_tit_text">Address</span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_dis_text"><?=$_POST['message'];?></span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_tit_text">Rep ID</span>
                    </div>
                    <div class="col-lg-6">
                    <span class="conf_dis_text"><?=$rep_rid;?></span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group-bt">
                        <a href="index.php" class="btn-primary">Back</a>
                        <a href="javascript:window.history.back();" class="btn-primary">Edit</a>
                        <button type="submit" class="btn-primary" >Register</button>
                        
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</body>
</html>