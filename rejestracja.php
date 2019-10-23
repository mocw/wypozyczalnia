<?php
if(!isset($_SESSION['uID'])) 
echo '<center><form method="POST" action="index.php?action=register" accept-charset="character_set">
<label for="username">Nazwa użytkownika:</label>
<input type="text" id="username" name="username">
<label for="password">Hasło:</label>
<input type="password" id="password" name="password">
<label for="password">Powtórz hasło:</label>
<input type="password" id="password" name="password-rpt">
<label for="text">Adres e-mail:</label>
<input type="text" id="email" name="email">
<label for="text">Imie:</label>
<input type="text" id="imie" name="imie">
<label for="text">Nazwisko:</label>
<input type="text" id="nazwisko" name="nazwisko">
<div id="lower">
</br>
<input type="submit" name="reg-submit" value="Zarejestruj">
</div>
</form></center>';
else  header('Location: index.php?action=home');
?>