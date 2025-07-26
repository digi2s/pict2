<?php session_start();
include "includes/config.php";

if($_SESSION['user_id']=='' or $_SESSION['user_type_r']!="client") 
 {
    print "<META http-equiv='refresh' content='0;URL=client-login.php'>";	
    exit;
 }

$qry = "select * from sub where s_id_key='".$_GET['sid']."'";
$rs= $con->recordselect($qry);
$no = mysqli_num_rows($rs);
if($no<=0)
{
    print "<META http-equiv='refresh' content='0;URL=client-manage-subscription.php'>";	
    exit;
}
$row=mysqli_fetch_array($rs); 

$sub_status = "";
if($row['sstatus']=='1')
{
    $sub_status = "Active";
}
else
{
    $sub_status = "Inactive";
}

$qry_model = "SELECT * FROM model WHERE rid = '" . $row['rid'] . "'";
$rs_model = $con->recordselect($qry_model);
$row_model = mysqli_fetch_array($rs_model);
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Client - Edit Subscriptions</title>
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
            	<h1>Client - Edit Subscriptions</h1>
                <h4>ID: <?=htmlspecialchars($_SESSION['cid'], ENT_QUOTES, 'UTF-8');?> - <?=htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8');?>  STATUS: <?=htmlspecialchars($sub_status, ENT_QUOTES, 'UTF-8');?></h4>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
            
                <div class="col-lg-12">
                	<div class="contact_form_div">
                       
                         <?php if($_SESSION['rep_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div"><?=htmlspecialchars($_SESSION['rep_msg'], ENT_QUOTES, 'UTF-8');?></div></div>
                    <? $_SESSION['rep_msg']=''; } ?>
                        
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Model:</label> <?=htmlspecialchars($row_model['rname'], ENT_QUOTES, 'UTF-8');?><br />
                                <?php 
                                $rid = $row['rid'];
                                $qry_pics = "SELECT * FROM picts WHERE pdate = '" . date('Y-m-d')."' && rid='".$rid."' && pstatus = '1' limit 0,1";
                                $rs_pics = $con->recordselect($qry_pics);
                                $row_pics = mysqli_fetch_array($rs_pics);
                                
                                $model_pic = "pictures/$rid/".$row_pics['name'];
                                if (file_exists($model_pic)) 
                                {
                                ?>
                                  <img width="150" height="150" src="<?=htmlspecialchars($model_pic, ENT_QUOTES, 'UTF-8');?>" alt="Picture display here" />
                                <? }else{ ?>
                                <img width="150" height="150" src="images/imagenotfound.png" alt="Picture display here" />
                                <? } ?>
                                <br />
                               
                              </div>
                            </div>
                            <div class="col-sm-12">
                            <div class="form-group-bt">
                                Stars: 0 <br />
                                  Level: <?=htmlspecialchars($row['slevel'], ENT_QUOTES, 'UTF-8');?><br />
                                </div>
                            </div>
                           
                            <div class="col-sm-12">
                            	<div class="form-group-bt">
                              		<button type="button" class="btn-primary" >Upgrade</button>
                                    <a href="javascript:void(0);" onclick="subscription_cancel();" class="btn-primary">Cancel</a>
                                    <a href="client-manage-subscription.php" class="btn-primary">Back</a>
                                </div>
                            </div>
            		
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="action.php" method="post" name="frm_operation">
        <input type="hidden" name="frm_action" id="frm_action" value="" /> 
        <input type="hidden" name="sid" id="sid" value="<?=htmlspecialchars($_GET['sid'], ENT_QUOTES, 'UTF-8');?>" />
        
    </form>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>

  $.validate({
    modules : 'location, date, security, file',
  });
</script>

<script>
function subscription_cancel()
{
    if(window.confirm("Are you sure to cancel this subscription?"))
    {
        document.getElementById("frm_action").value = "client_subscription_cancel"
        document.frm_operation.submit();
    }
}
</script>

</html>