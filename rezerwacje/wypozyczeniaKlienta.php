<?php
if(isset($_SESSION['uID'])){
require 'zarzadzaniekontem.php';
require 'includes/dbh.inc.php';
$sql="SELECT u.uidUSers,CONCAT(p.marka,' ',p.model),sm.vin,
CONCAT(so.miejscowosc,' ul.',so.ulica,' ',so.nr_posesji),
CONCAT(sz.miejscowosc,' ul.',sz.ulica,' ',sz.nr_posesji),
w.data_odbioru,w.data_zwrotu,wp.id,u.userID,\"aktualny\",p.cena,k.miejscowosc,k.ulica,k.nr_mieszkania,u.pesel
FROM wypozyczenia wp 
JOIN wnioski w ON wp.id_wniosku=w.id
JOIN siedziby so ON w.id_miejsca_odbioru=so.id
JOIN siedziby sz ON w.id_miejsca_zwrotu=sz.id
JOIN samochody sm ON wp.id_egzemplarza=sm.id
JOIN pojazdy p ON sm.id_samochodu=p.id
JOIN users u ON w.id_uzytkownika=u.userID
JOIN klienci k ON u.id_klienta=k.id
WHERE u.userID='$_SESSION[uID]'
UNION
SELECT u.uidUSers,CONCAT(p.marka,' ',p.model),sm.vin,
CONCAT(so.miejscowosc,' ul.',so.ulica,' ',so.nr_posesji),
CONCAT(sz.miejscowosc,' ul.',sz.ulica,' ',sz.nr_posesji),
w.data_odbioru,w.data_zwrotu,wp.id,u.userID,\"zwrócony\",p.cena,k.miejscowosc,k.ulica,k.nr_mieszkania,u.pesel
FROM archiwum_wypozyczen wp  
JOIN wnioski w ON wp.id_wniosku=w.id
JOIN siedziby so ON w.id_miejsca_odbioru=so.id
JOIN siedziby sz ON w.id_miejsca_zwrotu=sz.id
JOIN samochody sm ON wp.id_egzemplarza=sm.id
JOIN pojazdy p ON sm.id_samochodu=p.id
JOIN users u ON w.id_uzytkownika=u.userID
JOIN klienci k ON u.id_klienta=k.id
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
        </br></br>Stronami niniejszej umowy sa:
        <p><b>1. </b> Wypozyczalnia samochodow
        <p>Filia w: '.$row[3].'</p>
        <p>NIP:  848-138-84-23</p>
        <p>Zwany dalej Wypozyczajacy</p>
        <p><b>2. </b> '.$_SESSION['imie'].' '.$_SESSION['nazwisko'].'
        <p>ul. '.$row[12].' '.$row[13].'</p>
        <p>PESEL: '.$row[14].'</p>
        <p>Zwany dalej Pozyczajacy</p>
        </br></br></br>
        <p style="line-height: 1.5;  font-size: 18px"><b>1.</b>  Pozyczajacy wypozycza samochod osobowy marki '.$row[1].' o numerze vin '.$row[2].' na czas od 
        '.$row[5].' do '.$row[6].'</p>
        <p style="line-height: 1.5;  font-size: 18px"><b>2.</b> Zwrot wypozyczonego samochodu musi nastapic w nieprzekraczalnym terminie do godz. 21.30</p>';
        $date_reception = strtotime($row[5]); 
        $expiry_date = strtotime($row[6]);
        $datediff = $expiry_date - $date_reception;
        $days=round($datediff / (60 * 60 * 24))+1;
        $cena=$row[10];
        $charge=$days*$cena;
        echo '<p style="line-height: 1.5;  font-size: 18px"><b>3.</b> Za  wypozyczenie  samochodu,  pozyczajacy  
        uiszcza  oplate  w wysokosci <strong>'.$charge.'</strong> zlotych</p>
        <p style="line-height: 1.5;  font-size: 18px"><b>4.</b> Przedmiotowy samochod jest w pelni sprawny.</p>';
        echo '
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