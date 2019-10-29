<?php
if(isset($_SESSION['uID']))
{
    session_start();
    session_unset();
    session_destroy();
    
    $sql="SELECT * FROM users WHERE uidUsers=?";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
     {
        echo '<p class="alert">Błąd SQL!</p>';
     }
     else {
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result))
        {
            $_SESSION['uID'] = $row['userID'];
            $_SESSION['uUID'] = $row['uidUsers'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['imie'] = $row['imie'];
            $_SESSION['nazwisko'] = $row['nazwisko'];
            $_SESSION['czyPracownik'] = $row['czyPracownik']; 
            $_SESSION['id_klienta'] = $row['id_klienta'];   
            $_SESSION['id_pracownika'] = $row['id_pracownika'];  
            header('Location: index.php?action=home');
        }
        else {
            echo '<p class="alert">Błąd!</p>';
        }
     }
}



?>