<?php
if(isset($_POST['passwordCode-submit'])){
    require 'dbh.inc.php';
    $code=$_POST['passwordCode'];
    $sql="SELECT code FROM passwordCodes WHERE code=?";
    $stmt=mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$code);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $resultCheck=mysqli_stmt_num_rows($stmt);
    if($resultCheck!=1)
    {
    echo '<div class="alert alert-danger" role="alert">Kod jest błędny lub został już wykorzystany!</div>';
    require 'remindPasswordCode.php';  
    }
    else {
        $sql="SELECT userID FROM passwordCodes WHERE code='$code'";
        $query=mysqli_query($conn, $sql);
        $row=mysqli_fetch_row($query);
        $id=$row[0];

        echo
        '<center><form method="POST" action="index.php?action=setNewPassword">
        <label for="username">Podaj nowe hasło:</label>
        <input type="password" id="password" name="newPassword">
        <label for="username">Powtórz hasło:</label>
        <input type="password" id="password" name="newpassword_rpt">
        <input type="hidden" name="userID" value="'.$id.'">
        <div id="lower">
        </br><input type="submit" name="setNewPassowrd-submit" value="Zatwierdź"></center>
        </div>
        </form>';
    }
}
else header('Location: index.php?action=home');
?>