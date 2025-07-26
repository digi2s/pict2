<?php session_start();
include "includes/config.php";

if($_SESSION['admin']=='' or $_SESSION['admin']!="yes") 
 {
    print "<META http-equiv='refresh' content='0;URL=admin-login.php'>";	
    exit;
 }
 

 $qry_pics_total = "SELECT * FROM client";
 $rs_pics_total = $con->recordselect($qry_pics_total);
 $no_pics_total = mysqli_num_rows($rs_pics_total);
 
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Admin - Manage Clients</title>
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
            	<h1>Admin - Manage Clients</h1>
            </header>
        </div>
        <div id="main-wrapper">
            <form>
            <div class="container">
                <div class="col-lg-12">
                    <div class="totle_pic_div">
                    	Total Clients <span class="pic_box"><?=$no_pics_total;?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<form action="" method="get">Search Clients: <input value="<?=$_GET['src'];?>" placeholder="Search by Name,Email,Address" size="50" type="text" class="form-control" name="src" /> <input type="submit" value="Search" /></form>
                    </div>
                </div>
                <?php if($_SESSION['rep_manage_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div_rep_manage"><?=$_SESSION['rep_manage_msg'];?></div></div>
                    <? $_SESSION['rep_manage_msg']=''; } ?>
                <div class="col-lg-12">
                	<div class="col-lg-3">
                	<div class="manage_pic_bt">
                    	<ul>
                        	<li><a href="javascript:void(0)" onclick="check_selected_view()" class="btn-primary">View/Edit</a></li>
                            <li><a href="javascript:void(0)" onclick="check_selected_delete()" class="btn-primary">Delete</a></li>
                            <li><a href="javascript:void(0)" onclick="check_selected_save_changes();" class="btn-primary">Save Changes</a></li>
                            <li><a href="admin-dashboard.php" class="btn-primary">Back</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row top_space">
                    	<div class="column first">
                        	<strong>Select</strong>
                        </div>
                        <div class="column middle">
                        <strong>Client ID</strong>
                        </div>
                        <div class="column left">
                        <strong>Name</strong>
                        </div>
                        <div class="column right">
                        <strong>Status</strong>
                        </div>
                    </div>
                    <div class="scroll_div">
                    
                    <?php
                            if($_GET['src']=="")
                            {
                                $qry_pics = "SELECT * FROM client order by cid desc";    
                            }
                            else
                            {
                                $src = $_GET['src'];
                                $qry_pics = "SELECT * FROM client where cname like '%$src%' or cemail like '%$src%' or caddress like '%$src%' order by cid desc";
                            }
                            
                            $rs_pics = $con->recordselect($qry_pics);
                            $no_pics = mysqli_num_rows($rs_pics);
                            $no=$no_pics;
                            while($row_pics = mysqli_fetch_array($rs_pics))
                            {
                              /*  $im = imagecreatefromstring($row_pics['pbody']);
                                $width = imagesx($im);
                                $height = imagesy($im); */
                    ?>
                        <div class="row">
                            <div class="column first">
                        	<input name="checked_ids[]" type="checkbox" value="<?=$row_pics['c_id_key'];?>" />
                        </div>
                            <div class="column middle">
                            <?
                           echo $row_pics['cid'];
                            ?>
                            </div>
                            <div class="column left">
                            <a href="admin-manage-client-edit.php?cid=<?=$row_pics['c_id_key'];?>" target="_blank"><?=$row_pics['cname'];?></a>
                            
                            </div>
                            <div class="column right">
                           <?
                                if($row_pics['cstatus']=="1")
                                {
                                    echo "A";
                                }
                                else
                                {
                                    echo "I";
                                }
                           ?>
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
        alert("Please select atleast one client to delete")
    }
    else if(checked_total>=1)
    {
        alert("To delete these clients please click on SAVE CHANGES")
        document.getElementById("frm_action").value = "admin_delete_clients"
        document.getElementById("selected_ids").value = pid
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
        alert("Please select any one client")
    } 
    else
    {
        window.open('admin-manage-client-edit.php?cid='+pid, '_self');
    }
}
</script>
</html>