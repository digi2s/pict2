<?php session_start();
include "includes/config.php";

if($_SESSION['user_id']=='' or $_SESSION['user_type_r']!="rep") 
 {
    print "<META http-equiv='refresh' content='0;URL=rep-login.php'>";	
    exit;
 }
 
 $qry_pics_size = "SELECT sum(LENGTH(pbody)) AS size_in_bytes FROM picts where rid='".$_SESSION['rid']."'";
 $rs_pics_size = $con->recordselect($qry_pics_size);
 $row_pics_size = mysqli_fetch_array($rs_pics_size);
 $size_in_mb =  number_format($row_pics_size['size_in_bytes'] / 1048576, 2); 
 
 $qry_pics_total = "SELECT * FROM picts where rid='".$_SESSION['rid']."'";
 $rs_pics_total = $con->recordselect($qry_pics_total);
 $no_pics_total = mysqli_num_rows($rs_pics_total);
 
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>Rep - Manage Pictures</title>
        <meta name="robots" content="index, follow" />
		<link rel="icon" href="images/favicon.png" type="image/png">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description"  content="" />
        <meta name="keywords"  content="" />
		<link rel="stylesheet" href="assets/css/style.css" />
        <style type="text/css">
		#sortable-list		{ padding:0; }
		#sortable-list li	{ padding:0px 4px; color:#000; cursor:move; list-style:none;  background:#f2f2f2; margin:5px 0; border:1px solid #e5e5e5; }
		#message-box		{ background:#fffea1; border:2px solid #fc0; padding:4px 8px; margin:0 0 14px 0;  }
	</style>

    <script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
	<script type="text/javascript">
		/* when the DOM is ready */
		jQuery(document).ready(function() {
			/* grab important elements */
			var sortInput = jQuery('#sort_order');
			var submit = jQuery('#autoSubmit');
			var messageBox = jQuery('#message-box');
			var list = jQuery('#sortable-list');
			/* create requesting function to avoid duplicate code */
			var request = function() {
				jQuery.ajax({
					beforeSend: function() {
						messageBox.text('Updating the sort order in the database.');
					},
					complete: function() {
						messageBox.text('Database has been updated.');
					},
					data: 'sort_order=' + sortInput[0].value + '&ajax=' + submit[0].checked + '&do_submit=1&byajax=1', //need [0]?
					type: 'post',
					url: '/demo/drag-drop-sort-save-jquery.php'
				});
			};
			/* worker function */
			var fnSubmit = function(save) {
				var sortOrder = [];
				list.children('li').each(function(){
					sortOrder.push(jQuery(this).data('id'));
				});
				sortInput.val(sortOrder.join(','));
				if(save) {
					request();
				}
               document.getElementById('sort_order_forsave').value = document.getElementById('sort_order').value
               document.frm_operation.frm_action.value = "rep_sort_pictures"
			};
			/* store values */
			list.children('li').each(function() {
				var li = jQuery(this);
				li.data('id',li.attr('title')).attr('title','');
			});
			/* sortables */
			list.sortable({
				opacity: 0.7,
				update: function() {
				    
					fnSubmit(submit[0].checked);
				}
			});
			list.disableSelection();
			/* ajax form submission */
			jQuery('#dd-form').bind('submit',function(e) {
				if(e) e.preventDefault();
				fnSubmit(true);
			});
		});
	</script>
</head>
<body>
    <div id="wrapper">
        <div id="header-wrapper">
            <header id="header" class="container">
            	<h1>Rep - Manage Pictures</h1>
                <h4>ID: <?=htmlspecialchars($_SESSION['rid'], ENT_QUOTES, 'UTF-8');?> - <?=htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8');?></h4>
            </header>
        </div>
        <div id="main-wrapper">
            <form>
            <div class="container">
                <div class="col-lg-12">
                    <div class="totle_pic_div">
                        Total Pictures <span class="pic_box"><?=htmlspecialchars($no_pics_total, ENT_QUOTES, 'UTF-8');?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Space Used <span class="pic_box"><?=htmlspecialchars($size_in_mb, ENT_QUOTES, 'UTF-8');?> Mb</span>
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
                        	<?php /* <li><a href="javascript:void(0)" onclick="check_selected_view()" class="btn-primary">View</a></li> */ ?>
                            <?php /* <li><a href="javascript:void(0)" onclick="check_selected_sort()" class="btn-primary">Sort</a></li> */ ?>
                            <li><a href="javascript:void(0)" onclick="check_selected_delete()" class="btn-primary">Delete</a></li>
                            <li><a href="javascript:void(0)" onclick="check_selected_save_changes();" class="btn-primary">Save Changes</a></li>
                            <li><a href="rep-dashboard.php" class="btn-primary">Back</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row top_space">
                    	<div class="column first">
                        	<strong>Select</strong>
                        </div>
                        <div class="column left">
                        <strong>Name</strong>
                        </div>
                        <div class="column middle">
                        <strong>Upload Date</strong>
                        </div>
                        <div class="column right">
                        <strong>Number</strong>
                        </div>
                    </div>
                    <div class="scroll_div">
                    <ul id="sortable-list" class="ui-sortable" unselectable="on" style="-moz-user-select: none;">
                    <?php
                            $qry_pics = "SELECT * FROM picts where rid='".$_SESSION['rid']."' && pdelete='0' order by pdate asc";
                            $rs_pics = $con->recordselect($qry_pics);
                            $no_pics = mysqli_num_rows($rs_pics);
                            $no=$no_pics;
                            $order_val = "";
                            while($row_pics = mysqli_fetch_array($rs_pics))
                            {
                                $order_val.=$row_pics['pid'].",";
                              /*  $im = imagecreatefromstring($row_pics['pbody']);
                                $width = imagesx($im);
                                $height = imagesy($im); */
                    ?>
                      <li title="<?=htmlspecialchars($row_pics['pid'], ENT_QUOTES, 'UTF-8');?>">
                        <div class="row">
                            <div class="column first">
                                  <input name="checked_ids[]" type="checkbox" value="<?=htmlspecialchars($row_pics['pid'], ENT_QUOTES, 'UTF-8');?>" />
                        </div>
                            <div class="column left">
                              <a href="rep-pics-view.php?pid=<?=htmlspecialchars($row_pics['pid'], ENT_QUOTES, 'UTF-8');?>" target="_blank"><?=htmlspecialchars($row_pics['name'], ENT_QUOTES, 'UTF-8');?></a>
                            </div>
                            <div class="column middle">
                            <?
                           echo $row_pics_dt = date("d F Y",strtotime($row_pics['pupdate']));
                            ?>
                            </div>
                            <div class="column right">
                           <? //echo $no;
                           
                           echo $row_pics_dt = date("y/d",strtotime($row_pics['pdate']));
                           ?>
                            </div>
                        </div>
                     </li>   
                        <? $no--; }
                        if($order_val!="")
                        {
                            $order_val = substr($order_val,0,strlen($order_val)-1);
                        }
                         ?>
                        
                        </ul>
                    </div>
                </div>
                </div>
            </div>
              <input name="sort_order" id="sort_order" value="<?=htmlspecialchars($order_val, ENT_QUOTES, 'UTF-8');?>" type="hidden">
            <input name="do_submit" value="Submit Sortation" type="hidden">
            <input value="0" name="autoSubmit" id="autoSubmit" type="hidden">
            </form>
        </div>
    </div>
    <form action="action.php" method="post" name="frm_operation">
        <?php if($_SESSION['rep_manage_pics_del']=="1")
        {?>
        <input type="hidden" name="frm_action" id="frm_action" value="rep_delete_pictures" />
        <? }else{ ?>
        <input type="hidden" name="frm_action" id="frm_action" value="" />
        <? } ?> 
        <input type="hidden" name="selected_ids" id="selected_ids" value="" /> 
          <input name="sort_order_forsave" id="sort_order_forsave" value="<?=htmlspecialchars($order_val, ENT_QUOTES, 'UTF-8');?>" type="hidden">
        
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
        if(window.confirm("Are you sure to delete these pics?"))
        {
            document.getElementById("frm_action").value = "rep_delete_pictures_tmp"
            document.getElementById("selected_ids").value = pid
            document.frm_operation.submit();
        }
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
        alert("Please select any one picture")
    } 
    else
    {
        window.open('rep-pics-view.php?pid='+pid, '_blank');
    }
}
</script>
</html>