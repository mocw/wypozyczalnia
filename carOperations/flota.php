<?php
if((isset($_SESSION['uID']) && $_SESSION['id_pracownika']!=NULL) || 
(isset($_SESSION['uID']) && $_SESSION['isRoot']==1)) {
    require 'includes/employeepanel.php';
    require 'includes/dbh.inc.php';
    echo '
    <table class="table">
    <thead>
        <tr>
            <th>Miejscowość</th>
            <th>Ulica</th>
            <th>Numer VIN</th>
            <th>Marka</th>
            <th>Model</th>
            <th>Rok Produkcji</th>
            <th>Pojemność silnika</th>
            <th>Cena za dobę</th>
            <th>Usuń</th>
        </tr>
    </thead>';
    $sql="SELECT miejscowosc,CONCAT(ulica, ' ',nr_posesji),vin,marka,model,rok_produkcji,poj_silnika,cena
    FROM samochody_siedziby ss
    JOIN samochody sm ON ss.id_pojazdu=sm.id
    JOIN siedziby s ON ss.id_siedziby=s.id
    JOIN pojazdy p ON sm.id_samochodu=p.id
    ORDER BY miejscowosc";
    $result = mysqli_query($conn, $sql);
    $l=0;
    while ($row = mysqli_fetch_row($result)) {
        echo '
        <tr>
        <td>'.$row[0].'</td>
        <td>'.$row[1].'</td>
        <td>'.$row[2].'</td>
        <td>'.$row[3].'</td>
        <td>'.$row[4].'</td>
        <td>'.$row[5].'</td>
        <td>'.$row[6].'</td>
        <td>'.$row[7].'</td>
        <td><input type="checkbox">
        </tr>
        ';
    }
    echo '</table>
    ';
} else header('Location: index.php?action=home'); 
?>