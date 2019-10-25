<?php
if(isset($_POST['car'])) {
    if(!isset($_SESSION['uID']))
    {
        $_SESSION['doZalogowania'] = 1;
        echo '<p class="alert">Musisz się zalogować!</p>';
        require 'logowanie.php';   
        //header('Location: index.php?action=logowanie');
    }
        else
        {
            echo '<center></br>OK</center>';
            echo '<center>',$_POST['car'],'</center>';
    
        }
    }
else header('Location: index.php?action=home');

?>