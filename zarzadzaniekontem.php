<?php
if(isset($_SESSION['uID']))
{
    echo '<center>Witaj ',$_SESSION['imie']," ",$_SESSION['nazwisko'],'</center>';
    if($_SESSION['czyPracownik']==1) echo '<center></br>Pracownik!</center>';   
} else header('Location: index.php?action=home');
?>