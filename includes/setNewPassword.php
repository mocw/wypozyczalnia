<?php
if(isset($_POST['setNewPassowrd-submit'])){
    $newpassword=$_POST['newPassword'];
    $newpassword_rpt=$_POST['newpassword_rpt'];
    $id=$_POST['userID'];
    require 'dbh.inc.php';
if(strcmp($newpassword,$newpassword_rpt))
 {
    echo '<div class="alert alert-danger" role="alert">Hasła nie są zgodne!</div>';
    require 'remindPasswordCode.php'; 
 }
 else {
    
    $sql="UPDATE users SET pwdUsers=? 
    WHERE userID=?";
    $stmt=mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);
    $hashedPwd=password_hash($newpassword,PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"si",$hashedPwd,$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $sql="DELETE FROM passwordcodes 
    WHERE userID=?";
    $stmt=mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"i",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    echo '<div class="disappear"><div class="alert alert-success" role="alert">Hało zostało zmienione!</div></div>';
    require 'home.php';
 }
}
else header('Location: index.php?action=home');
?>