<?php session_start();
include "includes/config.php";

$frm_action = filter_input(INPUT_POST, 'frm_action', FILTER_SANITIZE_STRING);
if($frm_action === null) {
    $frm_action = filter_input(INPUT_GET, 'frm_action', FILTER_SANITIZE_STRING);
}

if($frm_action == "rep_login")
{
        $username = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_EMAIL);
        $password = base64_encode(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

        $stmt = mysqli_prepare($con->linki, "SELECT * FROM model WHERE remail = ? AND rpassword = ? AND rstatus = '1'");
        mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
        mysqli_stmt_execute($stmt);
        $rs_user = mysqli_stmt_get_result($stmt);
        $no_user = mysqli_num_rows($rs_user);
        $row_user = mysqli_fetch_array($rs_user);
        mysqli_stmt_close($stmt);
       
        if($no_user <= 0) 
        {
            $_SESSION['rep_login_msg'] =  "User / Password not valid, please try again.";
            print "<META http-equiv='refresh' content='0;URL=rep-login.php'>";	
            exit;
        }
        else 
        {
            $_SESSION['user_id'] = $row_user['r_id_key'];
            $_SESSION['user_type_r'] = 'rep';
            $_SESSION['user_name_r'] = $row_user['rname'];
            $_SESSION['user_email'] = $row_user['remail'];
            $_SESSION['rid'] = $row_user['rid'];
            
            $redirect_url = "rep-dashboard.php";
            print "<META http-equiv='refresh' content='0;URL=$redirect_url'>";	
            exit;
        }
}
else if($frm_action == "rep_change_password")
{
        $password = base64_encode(filter_input(INPUT_POST, 'current_password', FILTER_SANITIZE_STRING));

        $stmt = mysqli_prepare($con->linki, "SELECT * FROM model WHERE r_id_key = ? AND rpassword = ?");
        mysqli_stmt_bind_param($stmt, 'is', $_SESSION['user_id'], $password);
        mysqli_stmt_execute($stmt);
        $rs_user = mysqli_stmt_get_result($stmt);
        $no_user = mysqli_num_rows($rs_user);
        
        if($no_user <= 0)
        {
            $_SESSION['rep_msg'] =  "Sorry you entered wrong current password.";
            print "<META http-equiv='refresh' content='0;URL=rep-change-password.php'>";
            exit;
        }
        else
        {
            $new_password =  base64_encode(filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING));
            $stmt_up = mysqli_prepare($con->linki, "UPDATE `model` SET rpassword=? WHERE r_id_key=?");
            mysqli_stmt_bind_param($stmt_up, 'si', $new_password, $_SESSION['user_id']);
            mysqli_stmt_execute($stmt_up);
            mysqli_stmt_close($stmt_up);
        
            mysqli_stmt_close($stmt);

            $_SESSION['rep_msg'] =  "Password changed successfully.";
            $redirect_url = "rep-settings.php";
            print "<META http-equiv='refresh' content='0;URL=$redirect_url'>";
            exit;
        }
}
else if($frm_action == "client_change_password")
{
        $password = base64_encode(filter_input(INPUT_POST, 'current_password', FILTER_SANITIZE_STRING));

        $stmt = mysqli_prepare($con->linki, "SELECT * FROM client WHERE c_id_key = ? AND cpassword = ?");
        mysqli_stmt_bind_param($stmt, 'is', $_SESSION['user_id'], $password);
        mysqli_stmt_execute($stmt);
        $rs_user = mysqli_stmt_get_result($stmt);
        $no_user = mysqli_num_rows($rs_user);
       
        if($no_user <= 0) 
        {
            $_SESSION['rep_msg'] =  "Sorry you entered wrong current password.";
            print "<META http-equiv='refresh' content='0;URL=client-change-password.php'>";	
            exit;
        }
        else
        {
            $new_password =  base64_encode(filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING));
            $stmt_up = mysqli_prepare($con->linki, "UPDATE `client` SET cpassword=? WHERE c_id_key=?");
            mysqli_stmt_bind_param($stmt_up, 'si', $new_password, $_SESSION['user_id']);
            mysqli_stmt_execute($stmt_up);
            mysqli_stmt_close($stmt_up);
            mysqli_stmt_close($stmt);
            
            $_SESSION['rep_msg'] =  "Password changed successfully.";
            $redirect_url = "client-settings.php";
            print "<META http-equiv='refresh' content='0;URL=$redirect_url'>";	
            exit;
        }
}
else if($frm_action == "admin_client_change_password")
{
        $password = base64_encode(filter_input(INPUT_POST, 'current_password', FILTER_SANITIZE_STRING));

        $new_password =  base64_encode(filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING));
        $cid = filter_input(INPUT_POST, 'c_id_key', FILTER_SANITIZE_NUMBER_INT);
        $stmt_up = mysqli_prepare($con->linki, "UPDATE `client` SET cpassword=? WHERE c_id_key=?");
        mysqli_stmt_bind_param($stmt_up, 'si', $new_password, $cid);
        mysqli_stmt_execute($stmt_up);
        mysqli_stmt_close($stmt_up);
        
        $_SESSION['rep_manage_msg'] =  "Password changed successfully.";
        $redirect_url = "admin-manage-client.php";
        print "<META http-equiv='refresh' content='0;URL=$redirect_url'>";	
        exit;
       
}
else if($frm_action == "admin_rep_change_password")
{
        $password = base64_encode(filter_input(INPUT_POST, 'current_password', FILTER_SANITIZE_STRING));

        $new_password =  base64_encode(filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING));
        $rid = filter_input(INPUT_POST, 'r_id_key', FILTER_SANITIZE_NUMBER_INT);
        $stmt_up = mysqli_prepare($con->linki, "UPDATE `model` SET rpassword=? WHERE r_id_key=?");
        mysqli_stmt_bind_param($stmt_up, 'si', $new_password, $rid);
        mysqli_stmt_execute($stmt_up);
        mysqli_stmt_close($stmt_up);
        
        $_SESSION['rep_manage_msg'] =  "Password changed successfully.";
        $redirect_url = "admin-manage-rep.php";
        print "<META http-equiv='refresh' content='0;URL=$redirect_url'>";	
        exit;
       
}
else if($frm_action == "client_login")
{
        $username = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_EMAIL);
        $password = base64_encode(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

        $stmt = mysqli_prepare($con->linki, "SELECT * FROM client WHERE cemail = ? AND cpassword = ? AND cstatus = '1'");
        mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
        mysqli_stmt_execute($stmt);
        $rs_user = mysqli_stmt_get_result($stmt);
        $no_user = mysqli_num_rows($rs_user);
        $row_user = mysqli_fetch_array($rs_user);
        mysqli_stmt_close($stmt);
       
        if($no_user <= 0) 
        {
            $_SESSION['client_login_msg'] =  "User / Password not valid, please try again.";
            print "<META http-equiv='refresh' content='0;URL=client-login.php'>";	
            exit;
        }
        else 
        {
            $_SESSION['user_id'] = $row_user['c_id_key'];
            $_SESSION['user_type_r'] = 'client';
            $_SESSION['user_name_r'] = $row_user['cname'];
            $_SESSION['user_email'] = $row_user['cemail'];
            $_SESSION['cid'] = $row_user['cid'];
            $redirect_url = "client-dashboard.php";
            print "<META http-equiv='refresh' content='0;URL=$redirect_url'>";	
            exit;
        }
}
else if($frm_action == "admin_login") 
{
        $username = $_POST['user'];
        $password = $_POST['password'];
       
        if($username!=$admin_username or $password!=$admin_password) 
        {
            $_SESSION['client_login_msg'] =  "User / Password not valid, please try again.";
            print "<META http-equiv='refresh' content='0;URL=admin-login.php'>";	
            exit;
        }
        else 
        {
            $_SESSION['admin'] = 'yes';
            $redirect_url = "admin-dashboard.php";
            print "<META http-equiv='refresh' content='0;URL=$redirect_url'>";	
            exit;
        }
}
else if($frm_action == "rep_single_upload") 
{  
    $pic_name = $_FILES['picture']['name'];
    
     $qry_pic_name = "SELECT * FROM picts WHERE name = '" . $pic_name . "'";
     $rs_pic_name = $con->recordselect($qry_pic_name);
     $no_pic_name = mysqli_num_rows($rs_pic_name);
     if($no_pic_name>0)
     {
        $_SESSION['rep_upload_msg']="Picture name already exist in database. Please rename picture and then upload.";
        print "<META http-equiv='refresh' content='0;URL=rep-single-upload.php'>";	
            exit;
     }
    
    $imagetmp= addslashes (file_get_contents($_FILES['picture']['tmp_name']));
    
     $qry_pic = "SELECT * FROM picts WHERE rid = '" . $_SESSION['rid'] . "' && pdate >= '" . date('Y-m-d') . "' && pstatus = '1'";
     $rs_pic = $con->recordselect($qry_pic);
     $no_pic = mysqli_num_rows($rs_pic);
     
     $pdate = date('Y-m-d', strtotime(date('Y-m-d') . " +$no_pic day"));
    
   
    
    
    $qry_in = "insert into `picts`(`pbody`,`name`,`pupdate`,`rid`,`pdate`,`pstatus`)values('{$imagetmp}','".mysqli_real_escape_string($con->linki,$pic_name)."','".date('Y-m-d H:i:s')."','".$_SESSION['rid']."','".$pdate."','1')";
    $con->insert($qry_in);
    
    $_SESSION['rep_upload_msg']="Image uploaded successfully!!!";
    print "<META http-equiv='refresh' content='0;URL=rep-single-upload.php'>";	
            exit;
}
else if($frm_action == "admin_destroy_db") 
{  
    $qry_t = "SHOW TABLES";
    $rs_t = $con->recordselect($qry_t);
    while($row_t = mysqli_fetch_array($rs_t))
    {
        $qry_d = "DROP TABLE IF EXISTS ".$row_t[0];
        $rs_d = $con->recordselect($qry_d);
    } 
    
 /*   $q1 = "DROP DATABASE $db_name";
    $rs_t = $con->recordselect($q1); */
    
    $_SESSION['admin_db_msg']="Database tables destroyed successfully!!!";
    print "<META http-equiv='refresh' content='0;URL=admin.php'>";	
    exit;
}
else if($frm_action == "admin_create_db") 
{  
  /* $username1 = $_POST['username'];
   $password1 = $_POST['password'];
   $database1 = $_POST['database']; 
   
   $q1 = "CREATE USER '$username1'@'localhost' IDENTIFIED BY '$password1'";
   $con->recordselect($q1);
   
   $q1 = "CREATE DATABASE $database1";
   $con->recordselect($q1);
   
   $q1 = "grant all on *.* to $username1@localhost identified by '$password1'";
   $con->recordselect($q1); */
    
    
    
    // Name of the file
    $filename = 'pictures.sql';
    // MySQL host
    $mysql_host = $host_connect;
    // MySQL username
    $mysql_username = $db_username;
    // MySQL password
    $mysql_password = $db_username_password;
    // Database name
    $mysql_database = $db_name;
    
    // Connect to MySQL server
  // $this->link123 = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysqli_error($this->link123));
    // Select database
 //   mysqli_select_db($this->link123,$mysql_database) or die('Error selecting MySQL database: ' . mysqli_error($this->link123));
    
    // Temporary variable, used to store current query
    $templine = '';
    // Read in entire file
    $lines = file($filename);
    // Loop through each line
    foreach ($lines as $line)
    {
    // Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;
    
    // Add this line to the current segment
    $templine .= $line;
    // If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';')
    {
        // Perform the query
        $con->recordselect($templine);
      //  mysqli_query($this->link123,$templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($this->link123) . '<br /><br />');
        // Reset temp variable to empty
        $templine = '';
    }
    }
    
    
    $_SESSION['admin_db_msg']="Database created successfully!!!";
    print "<META http-equiv='refresh' content='0;URL=admin.php'>";	
    exit; 
}
else if($frm_action == "rep_settings")
{
    if($_POST['name']!="")
    {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        $stmt_up = mysqli_prepare($con->linki, "UPDATE `model` SET rname=?, remail=?, rphone=?, raddress=? WHERE r_id_key=?");
        mysqli_stmt_bind_param($stmt_up, 'ssssi', $name, $email, $phone, $message, $_SESSION['user_id']);
        mysqli_stmt_execute($stmt_up);
        mysqli_stmt_close($stmt_up);
        
        $_SESSION['rep_msg']="Settings saved successfully!!!";
        print "<META http-equiv='refresh' content='0;URL=rep-settings.php'>";	
        exit; 
    }
} 
else if($frm_action == "client_settings")
{

    if($_POST['name']!="")
    {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        $stmt_up = mysqli_prepare($con->linki, "UPDATE `client` SET cname=?, cemail=?, cphone=?, caddress=? WHERE c_id_key=?");
        mysqli_stmt_bind_param($stmt_up, 'ssssi', $name, $email, $phone, $message, $_SESSION['user_id']);
        mysqli_stmt_execute($stmt_up);
        mysqli_stmt_close($stmt_up);
        
        $_SESSION['rep_msg']="Settings saved successfully!!!";
        print "<META http-equiv='refresh' content='0;URL=client-settings.php'>";	
        exit; 
    }
}    
else if($frm_action == "admin_client_edit")
{
    if($_POST['name']!="")
    {
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
        $level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        $cid = filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_NUMBER_INT);
        $stmt_up = mysqli_prepare($con->linki, "UPDATE `client` SET cstatus=?, clevel=?, cname=?, cemail=?, cphone=?, caddress=? WHERE c_id_key=?");
        mysqli_stmt_bind_param($stmt_up, 'isssssi', $status, $level, $name, $email, $phone, $message, $cid);
        mysqli_stmt_execute($stmt_up);
        mysqli_stmt_close($stmt_up);
        
        $_SESSION['rep_manage_msg']="Settings saved successfully!!!";
        print "<META http-equiv='refresh' content='0;URL=admin-manage-client.php'>";	
        exit; 
    }
}    
else if($frm_action == "admin_rep_edit")
{
    if($_POST['name']!="")
    {
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
        $level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        $rid_key = filter_input(INPUT_POST, 'r_id_key', FILTER_SANITIZE_NUMBER_INT);
        $stmt_up = mysqli_prepare($con->linki, "UPDATE `model` SET rstatus=?, rlevel=?, rname=?, remail=?, rphone=?, raddress=? WHERE r_id_key=?");
        mysqli_stmt_bind_param($stmt_up, 'isssssi', $status, $level, $name, $email, $phone, $message, $rid_key);
        mysqli_stmt_execute($stmt_up);
        mysqli_stmt_close($stmt_up);
      
        
        $_SESSION['rep_manage_msg']="Settings saved successfully!!!";
        print "<META http-equiv='refresh' content='0;URL=admin-manage-rep.php'>";	
        exit; 
    }
}    
else if($frm_action == "rep_register")
{

        if($_POST['name']!="")
        {
                $rep_rid = filter_input(INPUT_POST, 'rep_rid', FILTER_SANITIZE_NUMBER_INT);
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
                $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
                $password = base64_encode(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
                $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);

                $stmt_in = mysqli_prepare($con->linki, "INSERT INTO `model`(`rid`,`rname`,`remail`,`rphone`,`raddress`,`rpassword`,`rstatus`,`rcode`) VALUES (?,?,?,?,?,?,1,?)");
                mysqli_stmt_bind_param($stmt_in, 'issssss', $rep_rid, $name, $email, $phone, $message, $password, $user);
                mysqli_stmt_execute($stmt_in);
                mysqli_stmt_close($stmt_in);
                
                $qry_code = "SELECT * FROM valcode WHERE vcode = '" . $_POST['user'] . "' && vstatus = '1'";
                $rs_code = $con->recordselect($qry_code);
                $row_code = mysqli_fetch_array($rs_code);
                $vcode = $row_code['vcode'];
                $vtype = $row_code['vtype'];
                $vtype_times = substr($vtype,1,strlen($vtype));
                $vtimes = ($row_code['vtimes'] + 1);
                
                 $qry_up="update `valcode` set vtimes='".$vtimes."' where vcid='".$row_code['vcid']."'";
                 $con->update($qry_up);
                 if($vtype_times==$vtimes)
                 {
                    $qry_up="update `valcode` set vstatus='0' where vcid='".$row_code['vcid']."'";
                    $con->update($qry_up);
                 }
                
               
                $_SESSION['rep_login_msg'] = "Registration has been compeleted successfully!!!";
                print "<META http-equiv='refresh' content='0;URL=rep-login.php'>";	
                exit; 
            
        }
}
else if($frm_action == "client_register")
{
        if($_POST['name']!="")
        {
                $client_cid = filter_input(INPUT_POST, 'client_cid', FILTER_SANITIZE_NUMBER_INT);
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
                $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
                $password = base64_encode(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
                $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);

                $stmt_in = mysqli_prepare($con->linki, "INSERT INTO `client`(`cid`,`cname`,`cemail`,`cphone`,`caddress`,`cpassword`,`cstatus`,`ccode`) VALUES (?,?,?,?,?,?,1,?)");
                mysqli_stmt_bind_param($stmt_in, 'issssss', $client_cid, $name, $email, $phone, $message, $password, $user);
                mysqli_stmt_execute($stmt_in);
                mysqli_stmt_close($stmt_in);
                
                $qry_code = "SELECT * FROM valcode WHERE vcode = '" . $_POST['user'] . "' && vstatus = '1'";
                $rs_code = $con->recordselect($qry_code);
                $row_code = mysqli_fetch_array($rs_code);
                $vcode = $row_code['vcode'];
                $vtype = $row_code['vtype'];
                $vtype_times = substr($vtype,1,strlen($vtype));
                $vtimes = ($row_code['vtimes'] + 1);
                
                 $qry_up="update `valcode` set vtimes='".$vtimes."' where vcid='".$row_code['vcid']."'";
                 $con->update($qry_up);
                 if($vtype_times==$vtimes)
                 {
                    $qry_up="update `valcode` set vstatus='0' where vcid='".$row_code['vcid']."'";
                    $con->update($qry_up);
                 }
                
                $_SESSION['client_login_msg'] = "Registration has been compeleted successfully!!!";
                print "<META http-equiv='refresh' content='0;URL=client-login.php'>";	
                exit; 
            
        }
}
else if($frm_action == "rep_sort_pictures") 
{ 
    if($_POST['sort_order_forsave']!="")
    {
        $ids_arr = explode(",",$_POST['sort_order_forsave']);
        
         $qry_pics = "SELECT * FROM picts where rid='".$_SESSION['rid']."' && pdelete='0' order by pdate asc limit 0,1";
         $rs_pics = $con->recordselect($qry_pics);
         $row_pics = mysqli_fetch_array($rs_pics);
         
         $first_date = $row_pics['pdate'];
         $no_pics = count($ids_arr);
         
         for($i=0;$i<$no_pics;$i++)
         {
           $next_date =  date('Y-m-d', strtotime($first_date . " +$i day"));
          
          $qry_up="update `picts` set pdate='".$next_date."' where pid='".$ids_arr[$i]."'";
          $con->update($qry_up);
         }                   
      // print_r($ids_arr);
      // exit; 
        
        
         $_SESSION['rep_manage_msg'] = "Sorting has been saved successfully!!!";
         print "<META http-equiv='refresh' content='0;URL=rep-manage-pictures.php'>";	
         exit; 
        
        
    }
}
else if($frm_action == "rep_delete_pictures") 
{ 
        $qry_delete="delete from `picts` where pdelete='1' && rid='".$_SESSION['rid']."'";
        $con->delete($qry_delete);
        $_SESSION['rep_manage_msg'] = "Pictures has been deleted successfully from database";
        $_SESSION['rep_manage_pics_del'] = "";
         print "<META http-equiv='refresh' content='0;URL=rep-manage-pictures.php'>";	
         exit; 

}  
else if($frm_action == "rep_delete_pictures_tmp") 
{ 

    if($_POST['selected_ids']!="")
    {
        $ids_arr = explode("==",$_POST['selected_ids']);
        $tot_selected = count($ids_arr);
        for($i=0;$i<$tot_selected;$i++)
        {
            $delete_id = trim($ids_arr[$i]);
            if($delete_id!="")
            {
                $qry_up="update `picts` set pdelete='1' where pid='".$delete_id."'";
                $con->update($qry_up);
            }
        }
        $_SESSION['rep_manage_msg'] = "To delete those pictures permanently from database please click SAVE CHANGES button";
        $_SESSION['rep_manage_pics_del'] = "1";
         print "<META http-equiv='refresh' content='0;URL=rep-manage-pictures.php'>";	
         exit; 
    }
}      
else if($frm_action == "admin_delete_clients") 
{ 
    if($_POST['selected_ids']!="")
    {
        $ids_arr = explode("==",$_POST['selected_ids']);
        $tot_selected = count($ids_arr);
        for($i=0;$i<$tot_selected;$i++)
        {
            $delete_id = trim($ids_arr[$i]);
            if($delete_id!="")
            {
                $qry_delete="delete from `client` where c_id_key='".$delete_id."'";
                $con->delete($qry_delete);
            }
        }
        $_SESSION['rep_manage_msg'] = "Clients has been deleted successfully!!!";
         print "<META http-equiv='refresh' content='0;URL=admin-manage-client.php'>";	
         exit; 
    }
}    
else if($frm_action == "admin_delete_rep") 
{ 
    if($_POST['selected_ids']!="")
    {
        $ids_arr = explode("==",$_POST['selected_ids']);
        $tot_selected = count($ids_arr);
        for($i=0;$i<$tot_selected;$i++)
        {
            $delete_id = trim($ids_arr[$i]);
            if($delete_id!="")
            {
                $qry_delete="delete from `model` where r_id_key='".$delete_id."'";
                $con->delete($qry_delete);
            }
        }
        $_SESSION['rep_manage_msg'] = "Rep has been deleted successfully!!!";
         print "<META http-equiv='refresh' content='0;URL=admin-manage-rep.php'>";	
         exit; 
    }
}
else if($frm_action == "client_new_subscription") 
{ 
    if($_POST['code']!="")
    {
        $code = $_POST['code'];
        
        $qry_code = "SELECT * FROM sub WHERE cid = '" . $_SESSION['cid'] . "' && scode = '" . $code . "'";
        $rs_code = $con->recordselect($qry_code);
        $no_code = mysqli_num_rows($rs_code);
        if($no_code>0)
        {
            $_SESSION['rep_msg'] = "You already subsribed this code. Please enter another code.";
            print "<META http-equiv='refresh' content='0;URL=client-subscription-add.php'>";	
            exit; 
        }
        
        $qry_code = "SELECT * FROM valcode WHERE vcode = '" . $code . "' && vstatus='1' && rid IS NOT NULL";
        $rs_code = $con->recordselect($qry_code);
        $no_code = mysqli_num_rows($rs_code);
        if($no_code>0)
        {
            $row_code = mysqli_fetch_array($rs_code);
            
            $qry_up="update `sub` set sdefault=0 where cid='".$_SESSION['cid']."'";
            $con->update($qry_up);
            
            $qry_in = "insert into `sub`(`cid`,`rid`,`sstatus`,`scode`,`screation`,`sdefault`)values ('".$_SESSION['cid']."','".$row_code['rid']."','1','".$code."','".date('Y-m-d H:i:s')."',1)";
            $con->insert($qry_in);
            
            ////
                $qry_code1 = "SELECT * FROM valcode WHERE vcode = '" . $code . "' && vstatus = '1'";
                $rs_code1 = $con->recordselect($qry_code1);
                $row_code1 = mysqli_fetch_array($rs_code1);
                $vcode = $row_code1['vcode'];
                $vtype = $row_code1['vtype'];
                $vtype_times = substr($vtype,1,strlen($vtype));
                $vtimes = ($row_code1['vtimes'] + 1);
                
                 $qry_up="update `valcode` set vtimes='".$vtimes."' where vcid='".$row_code1['vcid']."'";
                 $con->update($qry_up);
                 if($vtype_times==$vtimes)
                 {
                    $qry_up="update `valcode` set vstatus='0' where vcid='".$row_code1['vcid']."'";
                    $con->update($qry_up);
                 }
            
            ///
            
             $_SESSION['rep_manage_msg'] = "Subscription code has been added successfully!!!";
             print "<META http-equiv='refresh' content='0;URL=client-manage-subscription.php'>";	
            exit;
        }
        else
        {
            $_SESSION['rep_msg'] = "Invalid Code or Code is expired.";
            print "<META http-equiv='refresh' content='0;URL=client-subscription-add.php'>";	
            exit;
        }
        
        
        
        
    }
}
else if($frm_action == "client_subscription_default") 
{ 
    if($_POST['selected_ids']!="")
    {
        $ids_arr = explode("==",$_POST['selected_ids']);
        $tot_selected = count($ids_arr);
        for($i=0;$i<$tot_selected;$i++)
        {
            $delete_id = trim($ids_arr[$i]);
            if($delete_id!="")
            {
                $qry_up="update `sub` set sdefault=0 where cid='".$_SESSION['cid']."'";
                $con->update($qry_up);
            
                $qry_up="update `sub` set sdefault=1 where s_id_key='".$delete_id."'";
                $con->update($qry_up);
            }
        }
       $_SESSION['rep_manage_msg'] = "Subscription set as default successfully!!!";
       print "<META http-equiv='refresh' content='0;URL=client-manage-subscription.php'>";	
       exit;
    }
}   
else if($frm_action == "client_subscription_cancel") 
{ 
    if($_POST['sid']!="")
    {
        $qry_up="update `sub` set sstatus=0 where cid='".$_SESSION['cid']."' && s_id_key='".$_POST['sid']."'";
        $con->update($qry_up);
        
         $_SESSION['rep_manage_msg'] = "Subscription cancelled successfully!!!";
       print "<META http-equiv='refresh' content='0;URL=client-manage-subscription.php'>";	
       exit;
    }
}
else if($frm_action == "client_download") 
{ 
    if($_POST['rid']!="")
    {
        $rid = $_POST['rid'];
        $path = $_POST['path'];
        $qry_pics = "SELECT * FROM picts WHERE pdate = '" . date('Y-m-d')."' && rid='".$rid."' && pstatus = '1' limit 0,1";
        $rs_pics = $con->recordselect($qry_pics);
        $row_pics = mysqli_fetch_array($rs_pics);
        $pbody = $row_pics['pbody'];
        
        $qry_up="update `client` set `cdpath`='".mysqli_real_escape_string($con->linki,$path)."' where cid='".$_SESSION['cid']."'";
        $con->update($qry_up);
        
        $pics_name = "$path".$row_pics['name'];
        
        $pics_path = "http://24.13.97.214/pictures/$rid/$rid.jpg";
      
        file_put_contents("$pics_name", $pbody);
       //file_put_contents($pics_name, file_get_contents($pics_path));
     /*  $ch = curl_init($pics_path);
$fp = fopen('D:\xampp7\htdocs\lucas\flower.jpg', 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp); */

       
        $_SESSION['rep_msg'] = "Model picture downloaded successfully!!!";
        print "<META http-equiv='refresh' content='0;URL=client-download.php'>";	
        exit;
    }    
} 
else if($frm_action == "admin_code_create") 
{ 
    if($_POST['vcode']!="")
    {
        if($_POST['cid']=="")
        {
            
            $vtype = $_POST['type'];
            $vtimes = $_POST['times'];
            $vterm = $_POST['vterm'];
            $vcode = $_POST['vcode'];
            
            $vtype = $vtype.$vtimes;
            $cdate = date('Y-m-d');
            
            if($cdate<=$vterm)
            {
                $qry_in = "insert into `valcode`(`vcode`,`vtype`,`vterm`,`vstatus`)values ('".$vcode."','".$vtype."','".$vterm."','1')";
                $con->insert($qry_in);
                $_SESSION['rep_manage_msg'] = "Code has been created successfully!!!";
                print "<META http-equiv='refresh' content='0;URL=admin-codes.php'>";	
                exit;
            }
            else
            {
                $_SESSION['rep_manage_msg'] = "Termination Date must be greated than the today date";
                print "<META http-equiv='refresh' content='0;URL=admin-codes.php'>";	
                exit;
            }
        }
        else
        {
            $cid=$_POST['cid'];
            
            $qry_up="update `valcode` set vcode='".$_POST['vcode']."',vtype='".$_POST['vtype']."',vterm='".$_POST['vterm']."' where vcid='".$cid."'";
            $con->update($qry_up);   
             
            $_SESSION['rep_manage_msg'] = "Code has been updated successfully!!!";
            print "<META http-equiv='refresh' content='0;URL=admin-codes.php'>";	
            exit;
        }
    }
} 
else if($frm_action == "admin_delete_codes") 
{ 
    if($_POST['selected_ids']!="")
    {
        $ids_arr = explode("==",$_POST['selected_ids']);
        $tot_selected = count($ids_arr);
        for($i=0;$i<$tot_selected;$i++)
        {
            $delete_id = trim($ids_arr[$i]);
            if($delete_id!="")
            {
                $qry_delete="delete from `valcode` where vcid='".$delete_id."'";
                $con->delete($qry_delete);
            }
        }
        $_SESSION['rep_manage_msg'] = "Code has been deleted successfully!!!";
         print "<META http-equiv='refresh' content='0;URL=admin-codes.php'>";	
         exit; 
    }
} 
else if($frm_action == "admin_code_assign") 
{
    if($_POST['vcid']!="")
    {
        $vcid=$_POST['vcid'];
            
        $qry_up="update `valcode` set rid='".$_POST['rid']."' where vcid='".$vcid."'";
        $con->update($qry_up); 
        
        $_SESSION['rep_manage_msg'] = "Code has been assigned successfully!!!";
         print "<META http-equiv='refresh' content='0;URL=admin-codes.php'>";	
         exit;  
    }    
}    

?>