<?php session_start();
include "includes/config.php";


?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta charset="utf-8" />
		<title>View DBs</title>
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
            	<h1>View DBs</h1>
            </header>
        </div>
        <div id="main-wrapper">
            <div class="container">
                <div class="col-lg-12">
                                    	<?php
                                               listAll($db_name,$host_connect,$db_username,$db_username_password);
                                                
                    function listAll($db,$host1,$user1,$pass1) {
                        
                 $link567 =     mysqli_connect("$host1","$user1","$pass1");
                      mysqli_select_db($link567,$db);
                      $tables = mysqli_query($link567,"SHOW TABLES FROM $db");
                      while (list($tableName)=mysqli_fetch_array($tables)) {
                        $result = mysqli_query($link567,"DESCRIBE $tableName");
                        $rows = array();
                        while (list($row)=mysqli_fetch_array($result)) {
                          $rows[] = $row;
                        }
                        $count = count($rows);
                        if ($count>0) {
                          echo '<p><strong>',htmlentities($tableName),'</strong><br /><table border="1"><tr>';
                          foreach ($rows as &$value) {
                            echo '<td><strong>',htmlentities($value),'</strong></td>';
                          }
                          echo '</tr>';
                          $result = mysqli_query($link567,"SELECT * FROM $tableName");
                          while ($row=mysqli_fetch_array($result)) {
                            echo '<tr>';
                            for ($i=0;$i<(count($row)/2);$i++) {
                              echo '<td>',htmlentities($row[$i]),'</td>';
                            }
                            echo '</tr>';
                          }
                          echo '</table></p>';
                        }
                      }
                    return FALSE;
                    }
                                               ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>