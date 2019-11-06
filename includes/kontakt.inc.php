<?php
if(isset($_POST['kontakt-submit'])) {
header('Content-Type: text/html; charset=utf-8');
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

if(!empty($_POST['name']) and !empty($_POST['email']) and !empty($_POST['message']) and !empty($_POST['captcha'])){
	
	if($_POST['captcha']!=$_SESSION['captcha']){
        $input = $_POST;
        echo '<div class="alert alert-danger" role="alert">Kod captcha jest nieprawidłowy</div>';
        require 'kontakt.php';
	}else{
		$email_odbiorcy = 'wypozyczalniaaut2137@gmail.com'; //podajemy adres na który bedzie wysłany
		
		$header = 'Reply-To: <'.$_POST['email']."> \r\n"; 
		$header .= "MIME-Version: 1.0 \r\n"; 
		$header .= "Content-Type: text/html; charset=UTF-8"; 
		
		$wiadomosc = "<p>Dostałeś wiadomość od:</p>";
		$wiadomosc .= "<p>Imie i nazwisko: " . $_POST['name'] . "</p>";
        $wiadomosc .= "<p>Temat " . $_POST['temat'] . "</p>";
        $wiadomosc .= "<p>Email: " . $_POST['email'] . "</p>";
		$wiadomosc .= "<p>Wiadomość: " . $_POST['message'] . "</p>";
		$message = '<!doctype html><html lang="pl"><head><meta charset="utf-8">'.$wiadomosc.'</head><body>';
		$subject = 'Wiadomość ze strony...';
		$subject = '=?utf-8?B?'.base64_encode($subject).'?=';
	
		if(mail($email_odbiorcy, $subject, $message, $header)){
			echo '<div class="alert alert-success" role="alert">Wiadomość została wysłana!</div>';
            require 'kontakt.php';
		}else{
			echo '<div class="alert alert-danger" role="alert">Wiadomość nie została wysłana</div>';
            require 'kontakt.php';
		}
	}
}
} else header("Location: index.php?action=rejestracja");
?>