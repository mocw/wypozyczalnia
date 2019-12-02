<?php
require 'dbh.inc.php';
if(isset($_SESSION['uID'])){
    if($_SESSION['id_klienta']==NULL 
    && $_SESSION['uUID']!='root') {
       if($_GET['action']==='oferta' || $_GET['action']==='home' || 
       $_GET['action']==='carreserv') echo '<div class="alert alert-warning" role="alert"><a href="index.php?action=fillData">Uzupełnij swoje dane</a>, aby móc
        zarezerwować pojazd!</div>';
        $isDataFilled=0;
    } else {
        $isDataFilled=1;
    }
}
else header('Location: index.php?action=home');

?>