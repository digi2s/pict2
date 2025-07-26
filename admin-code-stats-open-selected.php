<?php session_start();
include "includes/config.php";

if($_SESSION['admin']=='' or $_SESSION['admin']!="yes") 
 {
    print "<META http-equiv='refresh' content='0;URL=admin-login.php'>";	
    exit;
 }
 if($_GET['vcid'])
 {
    $qry_update = "update `valcode` set rid=NULL,vstatus='1' where vcid='" . $_GET['vcid'] . "'";
    $con->update($qry_update);
     print "<META http-equiv='refresh' content='0;URL=admin-code-stats.php'>";	
    exit;
 }

 $qry_code = "SELECT * FROM valcode where vcid = '".$_GET['cid']."'";
 $rs_code = $con->recordselect($qry_code);
 $row_code = mysqli_fetch_array($rs_code);
 
 $qry_rep = "SELECT * FROM model where rid = '".$row_code['rid']."'";
 $rs_rep = $con->recordselect($qry_rep);
 $row_rep = mysqli_fetch_array($rs_rep);
 
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Admin - Code Stats</title>
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
            	<h1>Admin - Code Stats</h1>
            </header>
        </div>
        <div id="main-wrapper">
            <form>
            <div class="container">
                <div class="col-lg-12">
                    <div class="totle_pic_div">
                          ID: <?=htmlspecialchars($row_rep['rid'], ENT_QUOTES, 'UTF-8');?> - <?=htmlspecialchars($row_rep['remail'], ENT_QUOTES, 'UTF-8');?>
                    </div>
                </div>
                <?php if($_SESSION['rep_manage_msg']!="")
                    {?>
                       <div class="col-sm-12"> <div class="msg_div_rep_manage"><?=htmlspecialchars($_SESSION['rep_manage_msg'], ENT_QUOTES, 'UTF-8');?></div></div>
                    <? $_SESSION['rep_manage_msg']=''; } ?>
                <div class="col-lg-12">
                
                <div class="col-lg-9">
                    <div class="row top_space">
                    	<div class="column middle">
                        	<strong>Code</strong>
                        </div>
                        
                        <div class="column middle">
                        <strong>#Times</strong>
                        </div>
                        <div class="column middle">
                        <strong>Types</strong>
                        </div>
                        <div class="column middle">
                        <strong>Unassingned</strong>
                        </div>
                    </div>
                    <div class="scroll_div">
                    
                    <?php
                            
                            $qry_codes = "SELECT * FROM valcode where rid='".$row_rep['rid']."' order by vcid desc";    
                            $rs_codes = $con->recordselect($qry_codes);
                            $no_codes = mysqli_num_rows($rs_codes);
                            while($row_codes = mysqli_fetch_array($rs_codes))
                            {
                    ?>
                        <div class="row">
                            <div class="column middle">
                                  <?=htmlspecialchars($row_codes['vcode'], ENT_QUOTES, 'UTF-8');?>
                            </div>
                            
                            <div class="column middle">
                              <?=htmlspecialchars($row_codes['vtimes'], ENT_QUOTES, 'UTF-8');?>
                            
                            </div>
                            <div class="column middle">
                              <?=htmlspecialchars($row_codes['vtype'], ENT_QUOTES, 'UTF-8');?>
                            </div>
                            <div class="column middle">
                                  <?php if($row_codes['vtimes']=='0'){?><a href="javascript:void(0);" onclick="Unassingned(<?=htmlspecialchars($row_codes['vcid'], ENT_QUOTES, 'UTF-8');?>);">Unassingned</a> <? } ?>
                            </div>
                        </div>
                        <?  } ?>
                        
                        
                    </div>
                </div>
                
                </div>
            </div>
            <a href="admin-code-stats.php" class="btn-primary">Back</a>
            </form>
        </div>
    </div>
    <form action="" method="get" name="frm_operation">
        <input type="hidden" name="cid" id="cid" value="<?=htmlspecialchars($_GET['cid'], ENT_QUOTES, 'UTF-8');?>" />
        <input type="hidden" name="vcid" id="vcid" value="" /> 
        
    </form>
</body>

<script>

function Unassingned(vcid)
{
     if(window.confirm("Are you sure to Unassingned this Rep?"))
    {
        
        document.getElementById("vcid").value = vcid
        document.frm_operation.submit();
    }
}

</script>
</html>