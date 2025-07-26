<?php
if($_POST['rid']!="")
{
    $rid = $_POST['rid'];
    $pics_path = "pictures/$rid/$rid.jpg";
    if(file_exists($pics_path)) 
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($pics_path).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($pics_path));
        flush(); // Flush system output buffer
        readfile($pics_path);
        exit;
    }
}
?>