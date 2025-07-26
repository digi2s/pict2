<?php session_start();
include "includes/config.php";

if($_SESSION['admin']=='' or $_SESSION['admin']!="yes") 
 {
    print "<META http-equiv='refresh' content='0;URL=admin-login.php'>";	
    exit;
 }

$qry = "select * from valcode where vcid='".$_GET['cid']."'";
$rs= $con->recordselect($qry);
$row=mysqli_fetch_array($rs); 

$level = $row['clevel'];
$cstatus = '';
if($row['cstatus']=='1')
{
    $cstatus = "Active";
}
else
{
    $cstatus = "Deactive";
}

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Admin - Code Create</title>
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
            	<h1>Admin - Code Create</h1>
                
            </header>
        </div>
        <div id="main-wrapper">
        <form action="action.php" method="post" name="frm_contact" id="frm_contact">
        <input type="hidden" name="frm_action" value="admin_code_create" />
         <input type="hidden" name="cid" value="<?=$_GET['cid'];?>" />
            <div class="container">
            
                <div class="col-lg-12">
                	<div class="contact_form_div">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Type</label>
                                <select data-validation="required" id="type" name="type">
                                    <option value="">Select Type</option>
                                    <option value="R">R(Rep)</option>
                                    <option value="C">C(Client)</option>
                                    <option value="S">S(Subscription)</option>
                                </select>
                              </div>
                            </div>
                             <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Times</label>
                                <select data-validation="required" id="times" name="times">
                                    <option value="">Select Times</option>
                                    <option value="0">Infinite</option>
                                    <?php for($i=1;$i<100;$i++)
                                    {?>
                                    <option value="<?=$i;?>"><?=$i;?></option>
                                    <? } ?>        
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">Term</label>
                                <input data-validation="required" value="<?=$row['vterm'];?>" id="vterm" name="vterm" type="date" class="form-control"> 
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group center_bt">
                                <input type="button" value="Generate Code" onclick="generate_code()" /> 
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="fullname">CODE</label>
                                <input maxlength="10" data-validation="required" value="<?=$row['vcode'];?>" id="vcode" name="vcode" type="text" class="form-control">
                              </div>
                            </div>
                          
                            
                            <div class="col-sm-12">
                            	<div class="form-group-bt">
                                    
                              		<button type="submit" class="btn-primary" onclick="return checkform();">Save</button>
                                    <a href="admin-codes.php" class="btn-primary">Back</a>
                                </div>
                            </div>
            		
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>

  $.validate({
    modules : 'location, date, security, file',
  });
</script>

<script>
function generate_code()
{
    var rand_nums = Math.floor(Math.random() * 900000000) + 100000000;
    if(document.getElementById('type').value=="")
    {
        alert("Please select TYPE first");
        return false;
    }
    var type_tmp = document.getElementById('type').value;
    
    var final_code = type_tmp + rand_nums;
    document.getElementById('vcode').value = final_code
    
}  
</script>
</html>