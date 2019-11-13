<?php
require 'zarzadzaniekontem.php';
if(isset($_POST['permiss-submit'])){
    $sql="UPDATE users SET isRoot=0 WHERE NOT userID=? AND NOT uidUsers='root'";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
    echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
    require 'uprawnienia.php';
    }
    else {
        mysqli_stmt_bind_param($stmt,"i",$_SESSION['uID']);
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
            }
        }
        echo '<div class="disappear"><div class="alert alert-success" role="alert">Sukces!</div></div>';
    } 
}

if(isset($_SESSION['uID']) && $_SESSION['isRoot']==1){
    require 'includes/dbh.inc.php';
    $sql="SELECT * FROM users";
    $stmt=mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_execute($stmt);
    $users=mysqli_stmt_get_result($stmt);
    mysqli_fetch_all($users,MYSQLI_ASSOC);
    echo '
    <form method="POST" action="index.php?action=uprawnienia">
    <table class="table">
    <thead>
        <tr>
            <th>
            Root
            </th>
            <th>Nazwa użytkownika</th>
            <th>Imię</th>
            <th>Nazwisko</th>
        </tr>
    </thead> ';
    foreach ($users as $row) {
        $id=$row['userID'];
        $username=$row['uidUsers'];
        $imie=$row['imie'];
        $nazwisko=$row['nazwisko'];
        $isRoot=$row['isRoot'];
        echo '
        <tbody>
        <tr>';
        if($row['userID']!=$_SESSION['uID'] && $row['uidUsers']!='root')
        {
            if($isRoot==1) {
                echo '<td><input type="checkbox" name="'.$id.'" value="'.$id.'" checked></td>';
            } else echo '<td><input type="checkbox" name="'.$id.'" value="'.$id.'"></td>';
        } else echo '<td></td>';     
            echo'
            <td>'.$username.'</td>
            <td>'.$imie.'</td>
            <td>'.$nazwisko.'</td>
        </tr>
        </tbody>';
    }    
echo '</table>
</br><center><input type="submit" VALUE="Zatwierdź" NAME="permiss-submit"></center>
</form>';
} else header('Location: index.php?action=home');
?>



