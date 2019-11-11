<?php
if(isset($_SESSION['uID'])){
require 'zarzadzaniekontem.php';
echo 'OK';
} else header('Location: index.php?action=home');

?>