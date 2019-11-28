<?php
if(isset($_SESSION['uID']))
{
    //session_start();
    session_unset();
    session_destroy();
}
header('Location: index.php?action=home');
?>
