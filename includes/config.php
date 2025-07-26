<?php error_reporting(0);

    require "class.php";
	require "functions.php";
	$con=new DBconn();
    
    $host_connect = "localhost";
    $db_username = "esmiamig_phpmyadmin";
    $db_username_password = "PHPSeventySix";
    $db_name = "esmiamig_pictures";
    
	$con->connect("$host_connect","$db_name","$db_username","$db_username_password");
    
    $admin_username = "admin";
    $admin_password = "123456";

?>