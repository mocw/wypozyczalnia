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
                Kliknij w poniższy link, a następnie wpisz podany kod.
                http://localhost/wypozyczalnia/index.php?action=remindpasswordCode 
                Kod: $code
                "; //!!! JEŚLI MACIE INNĄ NAZWE KATALOGU ZMIEŃCIE TREŚĆ LINKA !!!
                if( mail($email, $subject, $messages) ) {
                    $sql="INSERT INTO passwordcodes(code,userID) VALUES(?,?)";
                    $stmt=mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt,$sql);
                    mysqli_stmt_bind_param($stmt,"si",$code,$id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    echo '<div class="alert alert-success" role="alert">Wiadomość wysłana!</div>';
                    require 'forgottenpassword.php';                                      
                } 
                else {
                echo '<div class="alert alert-success" role="alert"><Niepowodzenie!</div>';
                require 'forgottenpassword.php';   //MAIL-KONIEC
                }  
    }

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
            echo '<div class="alert alert-danger" role="alert">Na podany adres nie jest zarejestorwany żaden użytkowik!</div>';
            require 'forgottenpassword.php';  
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
                    <form id="resend" name="page" method="POST" action="index.php?action=remindpassword">
                    <input type="submit" name="reSend" value="tutaj">
                    <input type="hidden" name="userID" value="'.$id.'">
                    <input type="hidden" name="email" value="'.$email.'">
                    </form>
                    </div>';
                    require 'forgottenpassword.php';   
                }
                else {
                sendMail($email,$id);                                     
            }
        }
    }
}
}
else header('Location: index.php?action=home');
?>