<?php
if(isset($_POST['login-submit'])) {
require 'dbh.inc.php';
$username=$_POST['username'];
$password=$_POST['password'];

if(empty($username) or empty($password)){
    echo '<div class="alert alert-danger" role="alert">Uzupełnij dane!</div>';
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
            echo '<div class="alert alert-danger" role="alert">Błędne hasło!</div>';
            require 'logowanie.php';  
          }
          else if($pwdCheck==true) {
              $_SESSION['uID'] = $row['userID'];
              $_SESSION['uUID'] = $row['uidUsers'];
              $_SESSION['email'] = $row['email'];
              $_SESSION['imie'] = $row['imie'];
              $_SESSION['nazwisko'] = $row['nazwisko'];
              $_SESSION['czyPracownik'] = $row['czyPracownik']; 
              $_SESSION['id_klienta'] = $row['id_klienta'];   
              $_SESSION['id_pracownika'] = $row['id_pracownika'];
              $_SESSION['isRoot'] = $row['isRoot'];                  
              if(isset($_SESSION['doZalogowania'])) header('Location: index.php?action=oferta');
              else header('Location: index.php?action=home');
          }
          else {
            echo '<div class="alert alert-danger" role="alert">Błędne hasło!</div>';
            require 'logowanie.php';    
          }

        }
        else
        {
          echo '<div class="alert alert-danger" role="alert">Nie ma takiego użytkownika!</div>';
          require 'logowanie.php'; 
        }
     }
}
}
else {
    header('Location: index.php?action=home');
}

?>