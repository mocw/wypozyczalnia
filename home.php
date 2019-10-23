<?php
if(!isset($_SESSION['uID'])) echo '<center>Jesteś wylogowany! </center>';
else echo '<center>Jesteś zalogowany! ',$_SESSION['imie']," ",$_SESSION['nazwisko'],'</center>';


?>