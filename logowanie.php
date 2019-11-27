<?php
if(!isset($_SESSION['uID'])) echo
'<center><form method="POST" action="index.php?action=login">
<label for="username">Nazwa użytkownika:</label>
<input type="text" id="username" name="username" required autofocus>
<label for="password">Hasło:</label>
<input type="password" id="password" name="password" required autofocus>
<div id="lower">
</br><p><a href="index.php?action=forgottenpassword">Zapomniałeś hasła?</a></p>
<p>Nie masz konta? <a href="index.php?action=rejestracja">Zarejestruj się!</a></p>
<input type="submit" name="login-submit" value="Zaloguj"></center>
</div>
</form>';
else  header('Location: index.php?action=home');
?>


