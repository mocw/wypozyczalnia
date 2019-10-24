<?php
if(isset($_POST['car'])) {
    if(!isset($_SESSION['uID']))
    {
        $_SESSION['doZalogowania'] = 1;
        header('Location: index.php?action=logowanie');
    }
        else
        {
            echo '</br>OK';
            echo $_POST['car'];
    
        }
    }
else header('Location: index.php?action=home');

?>