<?php
if(isset($_POST['reg-submit'])) {
require 'dbh.inc.php';

$username=$_POST['username'];
$password=$_POST['password'];
$password_rpt=$_POST['password-rpt'];
$email=$_POST['email'];
$imie=$_POST['imie'];
$nazwisko=$_POST['nazwisko'];
$pesel=$_POST['pesel'];
$nr_tel=$_POST['nr_tel'];
$data_ur=$_POST['data_ur'];
$data_ur = date("Y-m-d", strtotime($data_ur));

$rejestracjaSite='rejestracja.php';

if(strcmp($password,$password_rpt))
 {
    echo '<div class="alert alert-danger" role="alert">Hasła nie są zgodne!</div>';
    require 'rejestracja.php'; 
 }
 else if(checkPESEL($pesel)==false)
 {
    echo '<div class="alert alert-danger" role="alert">Numer PESEL jest nieprawidłowy!</div>';
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
                    $sql="INSERT INTO users(uidUsers,pwdUsers,email,imie,nazwisko,
                    pesel,nr_tel,data_ur) VALUES(?,?,?,?,?,?,?,?)";
                    $stmt=mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql))
                    {
                    echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
                    require $rejestracjaSite; 
                    }
                    else
                    {
                        $hashedPwd=password_hash($password,PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt,"ssssssss",$username,$hashedPwd,$email,$imie,$nazwisko,
                     $pesel,$nr_tel,$data_ur);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        echo '<div class="disappear"><div class="alert alert-success" role="alert">Zarejestorwano!
                        Teraz możesz się zalogować!</div></div>';
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

function CheckPESEL($str)
{
	if (!preg_match('/^[0-9]{11}$/',$str)) //sprawdzamy czy ciąg ma 11 cyfr
	{
		return false;
	}
 
	$arrSteps = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3); // tablica z odpowiednimi wagami
	$intSum = 0;
	for ($i = 0; $i < 10; $i++)
	{
		$intSum += $arrSteps[$i] * $str[$i]; //mnożymy każdy ze znaków przez wagć i sumujemy wszystko
	}
	$int = 10 - $intSum % 10; //obliczamy sumć kontrolną
	$intControlNr = ($int == 10)?0:$int;
	if ($intControlNr == $str[10]) //sprawdzamy czy taka sama suma kontrolna jest w ciągu
	{
		return true;
	}
	return false;
}

?>