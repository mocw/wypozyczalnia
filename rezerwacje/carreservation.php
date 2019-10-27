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
            echo '<center></br>OK</center>';
            echo '<center>',$_POST['carID'],'</center>';
    
        }
    }
else header('Location: index.php?action=home');

?>