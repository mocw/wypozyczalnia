<?php
if(isset($_POST['permiss-submit'])){
    require 'includes/dbh.inc.php';
    $sql="UPDATE users SET isRoot=0";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
    echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
    require 'uprawnienia.php';
    }
    else {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        foreach($_POST as $key => $name){
            if($key=='permiss-submit') break;
            $sql="UPDATE users SET isRoot=1 WHERE userID=?";
            $stmt=mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql))
            {
            echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
            }
            else {
                mysqli_stmt_bind_param($stmt,"i",$key);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $_SESSION['isRoot']=1;
                $success=1;
            }
        }
        if(isset($success)) echo '<div class="alert alert-success" role="alert">Sukces!</div>';
        else echo '<div class="alert alert-danger" role="alert">Błąd!</div>';
        require 'uprawnienia.php';
    } 
} else header('Location: index.php?action=home');

?>