<?php
if(isset($_POST['login-submit'])) {
require 'dbh.inc.php';
$username=$_POST['username'];
$password=$_POST['password'];

if(empty($username) or empty($password)){
    echo '<div class="alert alert-danger" role="alert">Uzupełnij dane!</div>'; 
}
else{
    $sql="SELECT * 
    FROM users  
    LEFT JOIN pracownicy
    ON users.id_pracownika=pracownicy.id
    LEFT JOIN stanowiska
    ON pracownicy.id_stanowiska=stanowiska.id
    WHERE uidUsers=?";
    $stmt=mysqli_stmt_init($conn);
     if(!mysqli_stmt_prepare($stmt,$sql))
     {
        echo '<p class="alert">>Błąd SQL!</p>';
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
          }
          else{
              $_SESSION['uID'] = $row['userID'];
              $_SESSION['uUID'] = $row['uidUsers'];
              $_SESSION['email'] = $row['email'];
              $_SESSION['imie'] = $row['imie'];
              $_SESSION['nazwisko'] = $row['nazwisko'];
              $_SESSION['id_klienta'] = $row['id_klienta'];   
              $_SESSION['id_pracownika'] = $row['id_pracownika'];
              $_SESSION['isRoot'] = $row['isRoot'];    
              $_SESSION['stanowisko'] = $row['nazwa'];   
              echo'<form method="POST" action="index.php?action=home" id="logg"></form>
              ';  
              echo '<script>document.getElementById("logg").submit();
              </script>';
          }
        }
        else
        {
          echo '<div class="alert alert-danger" role="alert">Nie ma takiego użytkownika!</div>';
        }
     }
}
}
?>