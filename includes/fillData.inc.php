<?php
if(isset($_POST['fillData-submit'])) {
require 'dbh.inc.php';
$nr_dowodu=$_POST['nr_dowodu'];
$nr_karty=$_POST['nr_karty'];
$ulica=$_POST['ulica'];
$miejscowosc=$_POST['miejscowosc'];
$kod_pocztowy=$_POST['kod_pocztowy'];
$nr_mieszkania=$_POST['numer_mieszkania'];
$nr_domu=$_POST['numer_domu'];
$sql="INSERT INTO klienci(nr_dowodu,nr_karty_kredytowej,ulica,
miejscowosc,kod_pocztowy,nr_mieszkania,nr_domu) VALUES(?,?,?,?,?,?,?)";
$stmt=mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql))
{
echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
require 'fillData.php';
}
else {
    mysqli_stmt_bind_param($stmt,"sssssss",$nr_dowodu,$nr_karty,$ulica,$miejscowosc,$kod_pocztowy, //NAJPIERW DO BAZY Z KLIENTAMI
    $nr_mieszkania,$nr_domu);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $id = mysqli_insert_id($conn);
    $uID=$_SESSION['uID'];
    $sql="UPDATE users SET id_klienta=? WHERE userID=?";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
    echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
    require 'fillData.php';
    }
    else {
        mysqli_stmt_bind_param($stmt,"ii",$id,$uID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $_SESSION['id_klienta']=$id;
        $isDataFilled=1;
        echo '<div class="alert alert-success" role="alert">Dane wypełnione!</div>';
        header('Location: index.php?action=accountmgm');
    }
}
} else header('Location: index.php?action=home');
?>