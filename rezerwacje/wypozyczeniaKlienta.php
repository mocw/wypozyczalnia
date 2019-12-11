<?php
if(isset($_SESSION['uID'])){
require 'zarzadzaniekontem.php';
require 'includes/dbh.inc.php';
$sql="SELECT u.uidUSers,CONCAT(p.marka,' ',p.model),sm.vin,
CONCAT(so.miejscowosc,' ul.',so.ulica,' ',so.nr_posesji),
CONCAT(sz.miejscowosc,' ul.',sz.ulica,' ',sz.nr_posesji),
w.data_odbioru,w.data_zwrotu,wp.id,u.userID,\"aktualny\",p.cena
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
w.data_odbioru,w.data_zwrotu,wp.id,u.userID,\"zwrócony\",p.cena
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
            <th class="th-sm">PDF</th>
        </tr>
    </thead><tbody>     
    ';
    $l=0;
    while ($row = mysqli_fetch_row($result)){
        $l++;
        if($row[9]=="zwrócony") echo '<tr style="background-color:#34A853">';
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
        //PDF
        echo' 
        <td style="white-space:nowrap;">
        <div id="target'.$l.'" style="display: none"> 
        <p><b>Imie i nazwisko:</b> '.$_SESSION['imie'].' '.$_SESSION['nazwisko'].' 
        <p><b>Pojazd:</b> '.$row[1].'</p>
        <p><b>Numer VIN:</b> '.$row[2].'</p>
        <p><b>Miejsce odbioru:</b> '.$row[3].'</p>
        <p><b>Miejsce zwrotu:</b>  '.$row[4].'</p>
        <p><b>Data odbioru:</b> '.$row[5].'</p>
        <p><b>Data zwrotu:</b>  '.$row[6].'</p>';
        $now = time(); // or your date as well
        $expiry_date = strtotime($row[6]);
        $datediff = $expiry_date - $now;
        $days=round($datediff / (60 * 60 * 24));
        $cena=$row[10];
        $charge=$days*$cena;
        echo '
        <p><b><strong>Naleznosc:</b>  '.$charge.' zl</p></strong>
        </div>
        <center><button class="wniosek" id="cmd'.$l.'" name="accept" value="" type="submit">
        <img src="images/pdf.gif" width="30px" height="25px"></img></button></center>
        </td>
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
    <th>PDF</th>
    </tr>
    </tfoot>
    </table></div>
    ';
}
}
?>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
<script type="text/javascript" src="scripts/generatePDF.js"></script>
<script type="text/javascript" src="scripts/timer.js"></script>