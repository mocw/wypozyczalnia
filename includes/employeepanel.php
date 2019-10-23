<?php
if(isset($_SESSION['uID']) && $_SESSION['czyPracownik']==1)
{
    echo '<center>Tu będzie panel pracownika</center>';
}
else header('Location: index.php?action=home');
?>