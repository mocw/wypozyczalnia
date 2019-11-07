<?php
if(isset($_POST['carID'])) {
    if(!isset($_SESSION['uID']))
    {
        $_SESSION['doZalogowania'] = 1;
        echo '<div class="alert alert-danger" role="alert">Musisz się zalogować!</div>';
        require 'logowanie.php';   
    }
        else
        {
            if($isDataFilled==0)
            {
                echo '<p class="alert alert-danger">Musisz wypełnić dane!</p>';
                require 'oferta.php';  
            }
            else
            {
                echo '<center>ID Pojazdu: ',$_POST['carID'],'</center>';
                echo '<center>Tu będzie będzie wniosek</center>';    
            }

        }
    }
else header('Location: index.php?action=home');

?>