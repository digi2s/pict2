<?php
// One-time script to migrate base64 encoded passwords to password_hash
require 'includes/config.php';

function upgrade_table($table, $idField, $passField) {
    global $con;
    $qry = "SELECT {$idField}, {$passField} FROM {$table}";
    $rs = $con->recordselect($qry);
    while($row = mysqli_fetch_array($rs)) {
        $pass = $row[$passField];
        if(strpos($pass, '$2y$') !== 0 && strpos($pass, '$argon2') !== 0) {
            $decoded = base64_decode($pass);
            $hashed = password_hash($decoded, PASSWORD_DEFAULT);
            $up = "UPDATE {$table} SET {$passField}='".mysqli_real_escape_string($con->linki,$hashed)."' WHERE {$idField}='".$row[$idField]."'";
            $con->update($up);
        }
    }
    echo "{$table} upgraded\n";
}

upgrade_table('model','r_id_key','rpassword');
upgrade_table('client','c_id_key','cpassword');

echo "Password upgrade complete.\n";
?>
