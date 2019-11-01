<?php
if(isset($_POST['customer-submit-data'])){
    require 'includes/dbh.inc.php';
    $i=0;

    foreach($_POST['names'] as $item){
        $names[$i]=$item;
        $i++;
    }
    
    $i=0;
    foreach($_POST['daty_zatrudnienia'] as $item){
        $daty_zatr[$i]=$item;
        $i++;
    }

    $i=0;
    foreach($_POST['stanowiska'] as $item){
        $stanowiska[$i]=$item;
        $i++;
    }

    for($l=0;$l<$i;$l++){
       $stanowisko=trim($stanowiska[$l]);
        $sql="SELECT id FROM stanowiska WHERE nazwa='$stanowisko'";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_execute($stmt);
        $id=mysqli_stmt_get_result($stmt);
        $row=mysqli_fetch_row($id);
        $id=$row[0];
        $sql="INSERT INTO pracownicy(data_zatr,id_stanowiska) VALUES(?,?)";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"si",$daty_zatr[$l],$id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $last_id = mysqli_insert_id($conn);
        $sql="UPDATE users SET id_pracownika='$last_id' WHERE uidUsers='$names[$l]'";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt); 
    }

    echo '<div class="alert alert-success" role="alert">Sukces!</div>';
    require 'dodajPracownika.php';

} else header('Location: index.php?action=home');

?>