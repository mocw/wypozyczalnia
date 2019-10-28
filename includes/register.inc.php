<?php
if(isset($_POST['reg-submit'])) {
require 'dbh.inc.php';

$username=$_POST['username'];
$password=$_POST['password'];
$password_rpt=$_POST['password-rpt'];
$email=$_POST['email'];
$imie=$_POST['imie'];
$nazwisko=$_POST['nazwisko'];
$rejestracjaSite='rejestracja.php';

if(empty($username) || empty($password) || empty($password_rpt) || empty($email) || empty($imie) || empty($nazwisko)){
    echo '<div class="alert alert-danger" role="alert">Uzypełnij wszystkie pola!</div>';
    require $rejestracjaSite;   
 } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<div class="alert alert-danger" role="alert">Nieprawidłowy adres e-mail!</div>';
    require 'rejestracja.php'; 
} else if(strcmp($password,$password_rpt))
 {
    echo '<div class="alert alert-danger" role="alert">Hasła nie są zgodne!</div>';
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
        echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
        require $rejestracjaSite; 
     }
     else{
         mysqli_stmt_bind_param($stmt,"s",$username);
         mysqli_stmt_execute($stmt);
         mysqli_stmt_store_result($stmt);
         $resultCheck=mysqli_stmt_num_rows($stmt);
         if($resultCheck > 0 )
         {
            echo '<div class="alert alert-danger" role="alert">Nazwa użytkownika zajęta!</div>';
            require $rejestracjaSite;  
         }
         else {
             $sql="SELECT uidUsers FROM users WHERE email=?";
             $stmt=mysqli_stmt_init($conn);
             if(!mysqli_stmt_prepare($stmt,$sql))
             {
                echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
                require $rejestracjaSite; 
             }
             else {
                 mysqli_stmt_bind_param($stmt,"s",$email);
                 mysqli_stmt_execute($stmt);
                 mysqli_stmt_store_result($stmt);
                 $resultCheck=mysqli_stmt_num_rows($stmt);
                 if($resultCheck > 0 )
                {
                    echo '<div class="alert alert-danger" role="alert">Ten email jest już wykorzystany!</div>';
                    require $rejestracjaSite;  
                }
                else {
                    $sql="INSERT INTO users(uidUsers,pwdUsers,email,imie,nazwisko) VALUES(?,?,?,?,?)";
                    $stmt=mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql))
                    {
                    echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
                    require $rejestracjaSite; 
                    }
                    else
                    {
                        $hashedPwd=password_hash($password,PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt,"sssss",$username,$hashedPwd,$email,$imie,$nazwisko);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        echo '<div class="alert alert-success" role="alert">Zarejestorwano!</div>';
                        require $rejestracjaSite;  
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