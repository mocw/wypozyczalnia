<?php
require 'zarzadzaniekontem.php';
require 'includes/dbh.inc.php';
$sql="SELECT u.uidUSers,CONCAT(p.marka,' ',p.model),sm.vin,
CONCAT(so.miejscowosc,' ul.',so.ulica,' ',so.nr_posesji),
CONCAT(sz.miejscowosc,' ul.',sz.ulica,' ',sz.nr_posesji),
w.data_odbioru,w.data_zwrotu,wp.id,u.userID,\"aktualny\"
FROM wypozyczenia wp 
JOIN wnioski w ON wp.id_wniosku=w.id
JOIN siedziby so ON w.id_miejsca_odbioru=so.id
JOIN siedziby sz ON w.id_miejsca_zwrotu=sz.id
JOIN samochody sm ON wp.id_egzemplarza=sm.id
JOIN pojazdy p ON sm.id_samochodu=p.id
JOIN users u ON w.id_uzytkownika=u.userID
WHERE u.userID='$_SESSION[uID]'
UNION
SELECT u.uidUSers,CONCAT(p.marka,' ',p.model),sm.vin,
CONCAT(so.miejscowosc,' ul.',so.ulica,' ',so.nr_posesji),
CONCAT(sz.miejscowosc,' ul.',sz.ulica,' ',sz.nr_posesji),
w.data_odbioru,w.data_zwrotu,wp.id,u.userID,\"zwrócony\"
FROM archiwum_wypozyczen wp  
JOIN wnioski w ON wp.id_wniosku=w.id
JOIN siedziby so ON w.id_miejsca_odbioru=so.id
JOIN siedziby sz ON w.id_miejsca_zwrotu=sz.id
JOIN samochody sm ON wp.id_egzemplarza=sm.id
JOIN pojazdy p ON sm.id_samochodu=p.id
JOIN users u ON w.id_uzytkownika=u.userID
WHERE u.userID='$_SESSION[uID]'"
;

$result = mysqli_query($conn, $sql);
$row_cnt = mysqli_num_rows($result);
if($row_cnt==0){
    echo '<div class="alert alert-warning" role="alert">Nie wypożyczyłeś jeszcze żadnego samochodu!</div>';
}
else {
    echo '
    <div class="tableContainer">
        <table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
          <thead class="table-dark">
          <tr>
            <th class="th-sm">Samochód</th>
            <th class="th-sm">VIN</th>
            <th class="th-sm">Miejsce odbioru</th>
            <th class="th-sm">Miejsce zwrotu</th>
            <th class="th-sm">Data odbioru</th>
            <th class="th-sm">Data zwrotu</th>
            <th class="th-sm">Status</th>
            <th class="th-sm">Pozostały czas</th>
        </tr>
    </thead><tbody>     
    ';
    $l=0;
    while ($row = mysqli_fetch_row($result)){
        $l++;
        if($row[9]=="zwrócony") echo '<tr style="background-color:green">';
        else echo'<tr>';
        echo '
        <td>'.$row[1].'</td>
        <td>'.$row[2].'</td>
        <td>'.$row[3].'</td>
        <td >'.$row[4].'</td>
        <td>'.$row[5].'</td>
        <td id="datazwrotu'.$l.'">'.$row[6].'</td>
        <td>'.$row[9].'</td>';
        if($row[9]!="zwrócony")  echo '<td id="timer'.$l.'"></td>'; //TIMER
        else echo '<td>Pojazd zwrócony</td>'; 
        echo'
        </tr>
        ';
    }
    echo '
    </tbody>
    <tfoot class="table-dark">
    <tr>
    <th>Samochód</th>
    <th>VIN</th>
    <th>Miejsce odbioru</th>
    <th>Miejsce zwrotu</th>
    <th>Data odbioru</th>
    <th>Data zwrotu</th>
    <th>Status</th>
    <th>Pozostały czas</th>
    </tr>
    </tfoot>
    </table></div>
    ';
}
?>

<script type="text/javascript" src="scripts/timer.js"></script>