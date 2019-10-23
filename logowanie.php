<?php
if(!isset($_SESSION['uID'])) echo
'<center><form method="POST" action="index.php?action=login">
<label for="username">Nazwa użytkownika:</label>
<input type="text" id="username" name="username">
<label for="password">Hasło:</label>
<input type="password" id="password" name="password">
<div id="lower">
<p><a href="#">Zapomniałeś hasła??</a></p>
<input type="checkbox"><label class="check" for="checkbox">Zapamiętaj mnie!</label>
<input type="submit" name="login-submit" value="Zaloguj"></center>
</div>
</form>';
else  header('Location: index.php?action=home');
?>


