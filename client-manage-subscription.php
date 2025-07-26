<?php session_start();
include "includes/config.php";

if($_SESSION['user_id']=='' or $_SESSION['user_type_r']!="client") 
 {
    print "<META http-equiv='refresh' content='0;URL=client-login.php'>";	
    exit;
 }
 
 $qry_sub_total = "SELECT * FROM sub where cid='".$_SESSION['cid']."'";
 $rs_sub_total = $con->recordselect($qry_sub_total);
 $no_sub_total = mysqli_num_rows($rs_sub_total);
 
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Client - Manage Subscriptions</title>
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
            	<h1>Client - Manage Subscriptions</h1>
                <h4>ID: <?=htmlspecialchars($_SESSION['cid'], ENT_QUOTES, 'UTF-8');?> - <?=htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8');?></h4>
            </header>
        </div>
        <div id="main-wrapper">
            <form>
            <div class="container">
                <div class="col-lg-12">
                    <div class="totle_pic_div">
                        Total Subscriptions <span class="pic_box"><?=htmlspecialchars($no_sub_total, ENT_QUOTES, 'UTF-8');?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <?php if($_SESSION['rep_manage_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div_rep_manage"><?=htmlspecialchars($_SESSION['rep_manage_msg'], ENT_QUOTES, 'UTF-8');?></div></div>
                    <? $_SESSION['rep_manage_msg']=''; } ?>
                <div class="col-lg-12">
                	<div class="col-lg-3">
                	<div class="manage_pic_bt">
                    	<ul>
                            <li><a href="client-subscription-add.php" class="btn-primary">New Subscription</a></li>
                        	<li><a href="javascript:void(0)" onclick="check_selected_view()" class="btn-primary">View/Edit</a></li>
                            <li><a href="javascript:void(0)" onclick="check_selected_default()" class="btn-primary">Make Default</a></li>
                            <li><a href="client-dashboard.php" class="btn-primary">Back</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row top_space">
                    	<div class="column first">
                        	<strong>Select</strong>
                        </div>
                        <div class="column left">
                        <strong>Model</strong>
                        </div>
                        <div class="column middle">
                        <strong>Stars</strong>
                        </div>
                        <div class="column right">
                        <strong>Level</strong>
                        </div>
                    </div>
                    <div class="scroll_div">
                    
                    <?php
                            $qry_sub = "SELECT * FROM sub where cid='".$_SESSION['cid']."' && sstatus='1' order by s_id_key desc";
                            $rs_sub = $con->recordselect($qry_sub);
                            while($row_sub = mysqli_fetch_array($rs_sub))
                            {
                                $qry_model = "SELECT * FROM model where rid='".$row_sub['rid']."'";
                                $rs_model = $con->recordselect($qry_model);
                                $row_model = mysqli_fetch_array($rs_model)
                    ?>
                        <div class="row">
                            <div class="column first">
                                  <input name="checked_ids[]" type="checkbox" value="<?=htmlspecialchars($row_sub['s_id_key'], ENT_QUOTES, 'UTF-8');?>" />
                        </div>
                            <div class="column left">
                              <a href="client-subscription-view-edit.php?sid=<?=htmlspecialchars($row_sub['s_id_key'], ENT_QUOTES, 'UTF-8');?>" target="_blank"><?=htmlspecialchars($row_model['rname'], ENT_QUOTES, 'UTF-8');?></a>
                            </div>
                            <div class="column middle">
                           0
                            </div>
                            <div class="column right">
                             <?=htmlspecialchars($row_sub['slevel'], ENT_QUOTES, 'UTF-8');?>
                            </div>
                        </div>
                        <? $no--; } ?>
                        
                        
                    </div>
                </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <form action="action.php" method="post" name="frm_operation">
        <input type="hidden" name="frm_action" id="frm_action" value="" /> 
        <input type="hidden" name="selected_ids" id="selected_ids" value="" /> 
        
    </form>
</body>

<script>
function checkbox_changed(val)
{
    var chk_arr =  document.getElementsByName("checked_ids[]");
    var chklength = chk_arr.length;             
    var pid = '';
    for(k=0;k< chklength;k++)
    {
        if(chk_arr[k].value!=val)
        {
            chk_arr[k].checked=false;
        }
    }
}
function check_selected_sort()
{
    var chk_arr =  document.getElementsByName("checked_ids[]");
    var chklength = chk_arr.length;             
    var pid = '';
    
    var checked_total = 0;
    for(k=0;k< chklength;k++)
    {
        if(chk_arr[k].checked)
        {
            pid = pid + "=="+chk_arr[k].value;
            checked_total = (checked_total)+1
        }
    }
    if(checked_total<2)
    {
        alert("Please select 2 pictures to sort")
    }
    else if(checked_total>2)
    {
        alert("Please select only 2 pictures to sort")
    }
    else if(checked_total==2)
    {
        alert("To sort these two products please click on SAVE CHANGES")
        document.getElementById("frm_action").value = "rep_sort_pictures"
        document.getElementById("selected_ids").value = pid
    }
    
}
function check_selected_delete()
{
    var chk_arr =  document.getElementsByName("checked_ids[]");
    var chklength = chk_arr.length;             
    var pid = '';
    
    var checked_total = 0;
    for(k=0;k< chklength;k++)
    {
        if(chk_arr[k].checked)
        {
            pid = pid + "=="+chk_arr[k].value;
            checked_total = (checked_total)+1
        }
    }
    if(checked_total<1)
    {
        alert("Please select atleast one picture to delete")
    }
    else if(checked_total>=1)
    {
        alert("To delete these pictures please click on SAVE CHANGES")
        document.getElementById("frm_action").value = "rep_delete_pictures"
        document.getElementById("selected_ids").value = pid
    }
}
function check_selected_default()
{
    var chk_arr =  document.getElementsByName("checked_ids[]");
    var chklength = chk_arr.length;             
    var pid = '';
    
    var checked_total = 0;
    for(k=0;k< chklength;k++)
    {
        if(chk_arr[k].checked)
        {
            pid = pid + "=="+chk_arr[k].value;
            checked_total = (checked_total)+1
        }
    }
    
    if(checked_total<1)
    {
        alert("Please select any one subscription")
    }
    else if(checked_total>1)
    {
        alert("Please select only one subscription")
        
    }
    else if(checked_total==1)
    {
        document.getElementById("frm_action").value = "client_subscription_default"
        document.getElementById("selected_ids").value = pid
        document.frm_operation.submit();
    }
}
function check_selected_save_changes()
{
    if(document.getElementById("frm_action").value=="")
    {
        alert("You not performed any operation. Nothing to save")
    }
    else
    {
        document.frm_operation.submit();
    }
}    
function check_selected_view()
{
    var chk_arr =  document.getElementsByName("checked_ids[]");
    var chklength = chk_arr.length;             
    var pid = '';
    for(k=0;k< chklength;k++)
    {
        if(chk_arr[k].checked)
        {
            pid = chk_arr[k].value;
        }
    }
    if(pid=='')
    {
        alert("Please select any one subscription")
    } 
    else
    {
        window.open('client-subscription-view-edit.php?sid='+pid, '_self');
    }
}
</script>
</html>