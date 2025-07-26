<?php session_start();
include "includes/config.php";

if($_SESSION['admin']=='' or $_SESSION['admin']!="yes") 
 {
    print "<META http-equiv='refresh' content='0;URL=admin-login.php'>";	
    exit;
 }
 

 $qry_code_total = "SELECT * FROM valcode";
 $rs_code_total = $con->recordselect($qry_code_total);
 $no_code_total = mysqli_num_rows($rs_code_total);
 
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Admin - Manage Code</title>
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
            	<h1>Admin - Manage Code</h1>
            </header>
        </div>
        <div id="main-wrapper">
            <form>
            <div class="container">
                <div class="col-lg-12">
                    <div class="totle_pic_div">
                        Total Code <span class="pic_box"><?=htmlspecialchars($no_code_total, ENT_QUOTES, 'UTF-8');?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<form action="" method="get">Search Codes: <input value="<?=htmlspecialchars($_GET['src'] ?? '', ENT_QUOTES, 'UTF-8');?>" placeholder="Search by Code" size="30" type="text" class="form-control" name="src" /> <input type="submit" value="Search" /></form>
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
                        	<li><a href="javascript:void(0)" onclick="check_selected_view()" class="btn-primary">View/Edit</a></li>
                            <li><a href="admin-code-create.php"  class="btn-primary">Create Client Code</a></li>
                            <li><a href="admin-code-create.php"  class="btn-primary">Create Subscription Code</a></li>
                            <li><a href="admin-code-create.php"  class="btn-primary">Create Rep Code</a></li>
                            <li><a href="admin-code-assign.php"  class="btn-primary">Assign Code</a></li>
                            <li><a href="javascript:void(0)" onclick="check_selected_delete()" class="btn-primary">Delete</a></li>
                            <li><a href="admin-dashboard.php" class="btn-primary">Back</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row top_space">
                    	<div class="column first">
                        	<strong>Select</strong>
                        </div>
                        
                        <div class="column left">
                        <strong>CODE</strong>
                        </div>
                        <div class="column middle">
                        <strong>RID</strong>
                        </div>
                        <div class="column right">
                        <strong>Status</strong>
                        </div>
                    </div>
                    <div class="scroll_div">
                    
                    <?php
                            if($_GET['src']=="")
                            {
                                $qry_codes = "SELECT * FROM valcode order by vcid desc";    
                            }
                            else
                            {
                                $src = $_GET['src'];
                                $qry_codes = "SELECT * FROM valcode where vcode like '%$src%' order by vcid desc";
                            }
                            
                            $rs_codes = $con->recordselect($qry_codes);
                            $no_codes = mysqli_num_rows($rs_codes);
                            while($row_codes = mysqli_fetch_array($rs_codes))
                            {
                    ?>
                        <div class="row">
                            <div class="column first">
                                  <input name="checked_ids[]" type="checkbox" value="<?=htmlspecialchars($row_codes['vcid'], ENT_QUOTES, 'UTF-8');?>" />
                        </div>
                            
                            <div class="column left">
                              <a href="admin-manage-client-edit.php?cid=<?=htmlspecialchars($row_codes['c_id_key'], ENT_QUOTES, 'UTF-8');?>" target="_blank"><?=htmlspecialchars($row_codes['vcode'], ENT_QUOTES, 'UTF-8');?></a>
                            
                            </div>
                            <div class="column middle">
                            <?
                             echo htmlspecialchars($row_codes['rid'], ENT_QUOTES, 'UTF-8');
                            ?>
                            </div>
                            <div class="column right">
                           <?
                                if($row_codes['vstatus']=="1")
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
                        <?  } ?>
                        
                        
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
        alert("Please select atleast one code to delete")
        return false;
    }
    else if(checked_total>=1)
    {
        document.getElementById("frm_action").value = "admin_delete_codes"
        document.getElementById("selected_ids").value = pid
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
        alert("Please select any one code")
    } 
    else
    {
        window.open('admin-code-create.php?cid='+pid, '_blank');
    }
}
</script>
</html>