<?php
if(isset($_POST['carID'])) {
    if(!isset($_SESSION['uID']))
    {
        $_SESSION['doZalogowania'] = 1;
        echo '<p class="alert">Musisz się zalogować!</p>';
        require 'logowanie.php';   
    }
        else
        {
            echo '<center>ID Pojazdu: ',$_POST['carID'],'</center>';
            echo '<center>Tu będzie będzie wniosek z egzemplarzami pojazdów o podanym ID</center>';    
        }
    }
else header('Location: index.php?action=home');

?>