<?php
if(!isset($_SESSION['uID'])) 
echo '
<div class="container">  
<form id="contact" method="POST" action="index.php?action=register" accept-charset="character_set">
<fieldset>
      <input placeholder="Nazwa użytkownika*" name="username" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Hasło*" name="password" type="password" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Powtorz hasło*" name="password-rpt" type="password" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Adres e-mail*" name="email" type="email" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Imie*" name="imie" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Nazwisko*" name="nazwisko" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Pesel" name="pesel" type="text" tabindex="1">
</fieldset>
<fieldset>
      <input placeholder="Numer telefonu*" name="nr_tel" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Data urodzenia*" name="data_ur" type="date" tabindex="1" required autofocus>
</fieldset>
<p style="color:red">* - pola obowiązkowe</p>
<fieldset>
      <button name="reg-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
</fieldset>
</div>
</form>
';
else  header('Location: index.php?action=home');
?>




