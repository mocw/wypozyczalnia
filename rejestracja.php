<?php
if(!isset($_SESSION['uID'])) 
echo '
<div class="container">  
<form id="contact" method="POST" action="index.php?action=register" accept-charset="character_set">
<fieldset>
      <input placeholder="Nazwa użytkownika" name="username" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Hasło" name="password" type="password" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Powtorz hasło" name="password-rpt" type="password" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Adres e-mail" name="email" type="email" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Imie" name="imie" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Nazwisko" name="nazwisko" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <button name="reg-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
</fieldset>
</div>
</form>
';
else  header('Location: index.php?action=home');
?>




<!---
<center><form method="POST" action="index.php?action=register" accept-charset="character_set">
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
</form></center>
-->