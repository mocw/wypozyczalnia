<?php
if(isset($_POST['remind-submit'])){
    $email=$_POST['email'];
    require 'dbh.inc.php';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p class="alert">Nieprawidłowy adres e-mail!</p>';
        require 'forgottenpassword.php'; 
    }
    else {
        $sql="SELECT * FROM users WHERE email=?";
        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            echo '<p class="alert">>Błąd SQL!</p>';
            require 'logowanie.php'; 
        } else {
            mysqli_stmt_bind_param($stmt,"s",$email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck=mysqli_stmt_num_rows($stmt);
            if($resultCheck!=1)
            {
            echo '<p class="alert">Na podany adres nie jest zarejestorwany żaden użytkowik!</p>';
            require 'forgottenpassword.php';  
            }
            else{
                echo '<center>OK</center>';
                require 'forgottenpassword.php';
                //C.D.N          
            }

        }
    }
}else header('Location: index.php?action=home');
?>