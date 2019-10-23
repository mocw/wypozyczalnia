<?php
if(!isset($_SESSION['uID'])) echo
'<center><form method="POST" action="index.php?action=remindpassword">
<label for="username">Adres e-mail:</label>
<input type="text" id="email" name="email">
<div id="lower">
</br><input type="submit" name="remind-submit" value="Wyślij"></center>
</div>
</form>';
else  header('Location: index.php?action=home');
?>