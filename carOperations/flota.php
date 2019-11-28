<?php
if((isset($_SESSION['uID']) && $_SESSION['id_pracownika']!=NULL) || 
(isset($_SESSION['uID']) && $_SESSION['isRoot']==1)) {
    require 'includes/employeepanel.php';
    require 'includes/dbh.inc.php';
    echo '
    <div class="tableContainer">
        <table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
          <thead class="table-dark">
          <tr>
            <th class="th-sm">Miejscowość</th>
            <th class="th-sm">Ulica</th>
            <th class="th-sm">Numer VIN</th>
            <th class="th-sm">Marka</th>
            <th class="th-sm">Model</th>
            <th class="th-sm">Rok Produkcji</th>
            <th class="th-sm">Pojemność silnika</th>
            <th class="th-sm">Cena za dobę</th>
            <th class="th-sm">Status</th>
            <th class="th-sm">Usuń</th>
        </tr>
    </thead><tbody>';
    $sql="SELECT miejscowosc,CONCAT(ulica, ' ',nr_posesji),vin,marka,model,rok_produkcji,poj_silnika,cena,czyDostepny,
    CASE 
    WHEN czyDostepny=0 THEN 'wypożyczony'
    WHEN czyDostepny=1 THEN 'dostępny'
    ELSE 'Brak informacji'
    END 
    FROM samochody_siedziby ss
    JOIN samochody sm ON ss.id_pojazdu=sm.id
    JOIN siedziby s ON ss.id_siedziby=s.id
    JOIN pojazdy p ON sm.id_samochodu=p.id
    ORDER BY miejscowosc";
    $result = mysqli_query($conn, $sql);
    $l=0;
    while ($row = mysqli_fetch_row($result)) {
        if($row[9]=="wypożyczony"){
            echo '<tr style="background-color:red;">';
        }
        else echo '<tr>';
        echo '
        <td>'.$row[0].'</td>
        <td>'.$row[1].'</td>
        <td>'.$row[2].'</td>
        <td>'.$row[3].'</td>
        <td>'.$row[4].'</td>
        <td>'.$row[5].'</td>
        <td>'.$row[6].'</td>
        <td>'.$row[7].'</td>
        <td>'.$row[9].'</td>
        <td><input type="checkbox">
        </tr>
        ';
    }
    echo '
    </tbody>
    <tfoot class="table-dark">
    <tr>
    <th>Miejscowość</th>
    <th>Ulica</th>
    <th>Numer VIN</th>
    <th>Marka</th>
    <th>Model</th>
    <th>Rok Produkcji</th>
    <th>Pojemność silnika</th>
    <th>Cena za dobę</th>
    <th>Status</th>
    <th>Usuń</th>
</tr>
    </tfoot>
    </table></div>
    ';
} else header('Location: index.php?action=home'); 
?>