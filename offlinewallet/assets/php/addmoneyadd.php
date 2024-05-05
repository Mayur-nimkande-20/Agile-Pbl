<?php 
include 'database.php';

$iduser = $user['id'];
extract($_POST);
if(isset($_POST['amountsend']) && isset($_POST['cid']))
{
    $sql = "INSERT INTO trans(from_user_id,to_user_id,amount) VALUES(121,$cid,'$amountsend')";
    return mysqli_query($db, $sql);
}

?>