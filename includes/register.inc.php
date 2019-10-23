<?php
if(isset($_POST['reg-submit'])) {
require 'dbh.inc.php';

$username=$_POST['username'];
$password=$_POST['password'];
$password_rpt=$_POST['password-rpt'];
$email=$_POST['email'];
$imie=$_POST['imie'];
$nazwisko=$_POST['nazwisko'];

if(empty($username) or empty($password) or empty($password_rpt) or empty($email) or empty($imie) or empty($nazwisko)){
    echo '<p class="alert">Uzupełnij wszystkie pola!</p>';
    require 'rejestracja.php';   
 } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<p class="alert">Nieprawidłowy adres e-mail!</p>';
    require 'rejestracja.php'; 
} else if(strcmp($password,$password_rpt))
 {
    echo '<p class="alert">Hasła nie są zgodne!</p>';
    require 'rejestracja.php'; 
 }
 else {
     $imie=strtolower($imie);
     $nazwisko=strtolower($nazwisko);
     $imie=ucfirst($imie);
     $nazwisko=ucfirst($nazwisko);

     $sql="SELECT uidUsers FROM users WHERE uidUsers=?";
     $stmt=mysqli_stmt_init($conn);
     if(!mysqli_stmt_prepare($stmt,$sql))
     {
        echo '<p class="alert">Błąd SQL!</p>';
        require 'rejestracja.php'; 
     }
     else{
         mysqli_stmt_bind_param($stmt,"s",$username);
         mysqli_stmt_execute($stmt);
         mysqli_stmt_store_result($stmt);
         $resultCheck=mysqli_stmt_num_rows($stmt);
         if($resultCheck > 0 )
         {
            echo '<p class="alert">Nazwa użytkownika zajęta!</p>';
            require 'rejestracja.php';  
         }
         else {
             $sql="SELECT uidUsers FROM users WHERE email=?";
             $stmt=mysqli_stmt_init($conn);
             if(!mysqli_stmt_prepare($stmt,$sql))
             {
                echo '<p class="alert">Błąd SQL!</p>';
                require 'rejestracja.php'; 
             }
             else {
                 mysqli_stmt_bind_param($stmt,"s",$email);
                 mysqli_stmt_execute($stmt);
                 mysqli_stmt_store_result($stmt);
                 $resultCheck=mysqli_stmt_num_rows($stmt);
                 if($resultCheck > 0 )
                {
                    echo '<p class="alert">Ten email jest już wykorzystany!</p>';
                    require 'rejestracja.php';  
                }
                else {
                    $sql="INSERT INTO users(uidUsers,pwdUsers,email,imie,nazwisko) VALUES(?,?,?,?,?)";
                    $stmt=mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql))
                    {
                    echo '<p class="alert">Błąd SQL!</p>';
                    require 'rejestracja.php'; 
                    }
                    else
                    {
                        $hashedPwd=password_hash($password,PASSWORD_DEFAULT);

                        mysqli_stmt_bind_param($stmt,"sssss",$username,$hashedPwd,$email,$imie,$nazwisko);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        echo '<p class="success">Zarejestorwano!</p>';
                        require 'rejestracja.php';  
                    }
                }
             }
         }
     }
     mysqli_stmt_close($stmt);
     mysqli_close($conn);
 }
}
else{
    header("Location: index.php?action=rejestracja");
}
?>