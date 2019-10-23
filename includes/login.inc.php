<?php
if(isset($_POST['login-submit'])) {
require 'dbh.inc.php';
$username=$_POST['username'];
$password=$_POST['password'];

if(empty($username) or empty($password)){
    echo '<p class="alert">Uzupełnij pola!</p>';
   require 'logowanie.php';   
}
else{
    $sql="SELECT * FROM users WHERE uidUsers=?";
    $stmt=mysqli_stmt_init($conn);
     if(!mysqli_stmt_prepare($stmt,$sql))
     {
        echo '<p class="alert">>Błąd SQL!</p>';
        require 'logowanie.php'; 
     }
     else {

        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result))
        {
          $pwdCheck=password_verify($password,$row['pwdUsers']);
          if($pwdCheck==false)
          {
           echo '<p class="alert">Błędne hasło!</p>';
            require 'logowanie.php';  
          }
          else if($pwdCheck==true) {
              $_SESSION['uID'] = $row['userID'];
              $_SESSION['uUID'] = $row['uidUsers'];
              $_SESSION['email'] = $row['email'];
              $_SESSION['imie'] = $row['imie'];
              $_SESSION['nazwisko'] = $row['nazwisko'];
              header('Location: index.php?action=home');
          }
          else {
            echo '<p class="alert">Błędne hasło!</p>';
            require 'logowanie.php';    
          }

        }
        else
        {
            echo '<p class="alert">Użytkownik nie istnieje!</p>';
            require 'logowanie.php'; 
        }
     }
}
}
else {
    header('Location: index.php?action=home');
}

?>