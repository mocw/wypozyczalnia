<?php
header('Content-Type: text/html; charset=utf-8');
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

if(!empty($_POST['name']) and !empty($_POST['email']) and !empty($_POST['message']) and !empty($_POST['captcha'])){
	
	if($_POST['captcha']!=$_SESSION['captcha']){
		die('Kod captcha jest nieprawidłowy');
		$input = $_POST;
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
			die('Wiadomość została wysłana');
		}else{
			die('Wiadomość nie została wysłana');
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Formularz kontaktowy</title>
	<link rel="stylesheet" href="css/kontakt.css">
</head>
<body>

<form method="post">
    <label for="name">Imię i nazwisko/ Nazwa Firmy</label>
    <input type="text" name="name" id="name" placeholder="Jan Kowalski/ Nazwa Firmy" required>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" placeholder="example@example.com" required>

    <label for="temat">Temat</label>
    <select id="subject" name="temat" class="form-group form-control">
                            <option value="" selected disabled>Wybierz temat</option>
                            <option>Wynajem długoterminowy</option>
                            <option>Wynajem kilku pojazdów</option>
                            <option>Problem z płatnościami</option>
                            <option>Inny temat</option>
                           </select>

    <label for="message">Wiadomość</label>
    <textarea name="message" id="message" placeholder="Wpisz swoją wiadomość" required></textarea>
	
	<label for="captcha">Przepisz kod captcha</label>
	<img src="includes/captcha.php" alt="Captcha" id="zdjecie">
    <input type="text" name="captcha" id="captcha" required>

    <input type="submit" name="submit" value="Wyślij">
</form>

</body>
</html>

