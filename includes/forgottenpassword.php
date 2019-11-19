<?php
function incrementalHash($len = 5){
    $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $base = strlen($charset);
    $result = '';
  
    $now = explode(' ', microtime())[1];
    while ($now >= $base){
      $i = $now % $base;
      $result = $charset[$i] . $result;
      $now /= $base;
    }
    return substr($result, -5);
  }

function sendMail($email,$id){
            require 'dbh.inc.php';
            $code=incrementalHash(5);    
            $subject = "Przypomnienie hasła"; //MAIL
            $messages= "Jeżeli nie spodziewałeś się tej wiadomości, zignoruj ją.
            Kliknij w poniższy link aby ustawić nowe hasło:
            http://localhost/wypozyczalnia/resetPassword.php?passwordCode=$code
            "; //!!! JEŚLI MACIE INNĄ NAZWE KATALOGU ZMIEŃCIE TREŚĆ LINKA !!!
            if( mail($email, $subject, $messages) ) {
                $sql="INSERT INTO passwordcodes(code,userID) VALUES(?,?)";
                $stmt=mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,"si",$code,$id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                echo '<div class="disappear"><div class="alert alert-success" role="alert">
                Wiadomość wysłana!</div></div>';                                   
            } 
            else {
            echo '<div class="alert alert-danger" role="alert"><Niepowodzenie!</div>';  //MAIL-KONIEC
            }  
}

if(!isset($_SESSION['uID'])){
    if(isset($_POST['reSend'])){
        $id=$_POST['userID'];
        $email=$_POST['email'];
        sendMail($email,$id);
    }    
else if(isset($_POST['remind-submit'])){
    $email=$_POST['email'];
    require 'dbh.inc.php';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="alert alert-danger" role="alert">Nieprawidłowy adres e-mail!</div>';
    }
    else {
        $sql="SELECT * FROM users WHERE email=?";
        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            echo '<p class="alert">>Błąd SQL!</p>';
        } else {
            mysqli_stmt_bind_param($stmt,"s",$email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck=mysqli_stmt_num_rows($stmt);
            if($resultCheck!=1)
            {
            echo '<div class="alert alert-danger" role="alert">Na podany adres nie jest zarejestorwany żaden użytkowik!</div>'; 
            }
            else{
                $sql="SELECT userID FROM users WHERE email='$email'"; //POBIERAMY ID
                $query = mysqli_query($conn, $sql);
                $row=mysqli_fetch_row($query);
                $id=$row[0];

                $sql="SELECT code FROM passwordcodes WHERE userID=$id"; //SPRAWDZAMY CZY JUZ NIE WYSLANO KODU
                    $stmt=mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt,$sql);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $resultCheck=mysqli_stmt_num_rows($stmt);
                 if($resultCheck > 0 ){
                    echo '<div class="alert alert-danger" role="alert">Kod już został wysłany!
                    Jeśli chcesz wysłać ponownie, kliknij 
                    <form id="resend" name="page" method="POST" action="index.php?action=forgottenpassword">
                    <input type="submit" name="reSend" value="tutaj">
                    <input type="hidden" name="userID" value="'.$id.'">
                    <input type="hidden" name="email" value="'.$email.'">
                    </form>
                    </div>';
                }
                else {
                sendMail($email,$id);                                     
            }
        }
    }
}
}

echo
'<center><form method="POST" action="index.php?action=forgottenpassword">
<label for="username">Adres e-mail:</label>
<input type="email" id="email" name="email">
<div id="lower">
</br><input type="submit" name="remind-submit" value="Wyślij"></center>
</div>
</form>';
} 
else  header('Location: index.php?action=home');
?>