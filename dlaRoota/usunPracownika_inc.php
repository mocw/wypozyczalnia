<?php
if(isset($_POST['customer-delete-submit'])){
    $cnt=0;
    foreach($_POST as $key => $name){
        if($key=='customer-delete-submit') break;
        $cnt++;
    }

    if($cnt==0){
        require 'usunPracownika.php';
        echo '<script language="javascript">alert("Nikogo nie zaznaczyłeś!")</script>';
    }
    else {
        require 'includes/dbh.inc.php';    
        foreach($_POST as $key => $name){
        if($key=='customer-delete-submit') break;
        $sql="SELECT id_pracownika FROM users WHERE userID=?";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"i",$key);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $row=mysqli_fetch_row($result);
        $id_pracownika=$row[0];
        $sql="UPDATE users
        SET id_pracownika=NULL
        WHERE userID=?";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"i",$key);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $sql="DELETE FROM pracownicy
        WHERE id='$id_pracownika'";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        }    
    echo '<div class="disappear"><div class="alert alert-success" role="alert">Sukces!</div></div>';
    require 'dlaRoota/usunPracownika.php';  
    }
} else header('Location: index.php?action=home');
?>
