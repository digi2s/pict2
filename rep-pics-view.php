<?php error_reporting(0); 
header("content-type:image/jpeg");

$host = 'localhost';
$user = 'phpmyadmin';
$pass = 'lucas123456';

$link234 = mysqli_connect($host, $user, $pass);
mysqli_select_db($link234,'pictures');

$select_image="select * from picts where pid='".$_GET['pid']."'";
$var=mysqli_query($link234,$select_image);
if($row=mysqli_fetch_array($var))
{
     $image=$row["pbody"];
}
echo $image;

?>