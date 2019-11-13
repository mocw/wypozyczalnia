<?php
if(isset($_SESSION['uID'])) require 'zarzadzaniekontem.php';
if(isset($_POST['passwordChange-submit'])){
    require 'dbh.inc.php';
    $oldpassword=$_POST['old-password'];
    $newpassword=$_POST['newpassword'];
    $newpassword_rpt=$_POST['newpassword-rpt'];
    $stmt=mysqli_stmt_init($conn);
    $sql="SELECT * FROM users
      WHERE userID='$_SESSION[uID]'";
      $stmt=mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt,$sql);
      mysqli_stmt_execute($stmt);
      $result=mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      $pwdCheck=password_verify($oldpassword,$row['pwdUsers']);
      if($pwdCheck==false) {
            echo '<div class="alert alert-danger" role="alert">Błędne hasło!</div>';
      }
      else{
            if(strcmp($newpassword,$newpassword_rpt)){
                echo '<div class="alert alert-danger" role="alert">Hasła nie są zgodne!</div>';
            }
            else{
                $id=$_SESSION['uID'];
                $sql="UPDATE users SET pwdUsers=? 
                WHERE userID=?";
                $stmt=mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);
                $hashedPwd=password_hash($newpassword,PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt,"si",$hashedPwd,$id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                echo '<div class="disappear"><div class="alert alert-success" role="alert">Hasło zostało zmienione!</div></div>';
            }
      }
}

if(isset($_SESSION['uID'])){
echo '
<div class="container">  
<form id="contact" method="POST" action="index.php?action=changePassword" accept-charset="character_set">
<fieldset>
      <input placeholder="Stare hasło" name="old-password" type="password" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Nowe hasło" name="newpassword" type="password" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Powtórz nowe" name="newpassword-rpt" type="password" tabindex="1" required autofocus>
</fieldset>
<button name="passwordChange-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
</form>
</div>
';
} else header('Location: index.php?action=home');

?>