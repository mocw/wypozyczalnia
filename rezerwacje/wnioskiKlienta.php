<?php
if(isset($_SESSION['uID']))
{
    require 'zarzadzaniekontem.php';
    require 'includes/dbh.inc.php';
    $userID=$_SESSION['uID'];
    $sql="SELECT CONCAT(so.miejscowosc, ' ul.',so.ulica,' ',so.nr_posesji),
    CONCAT(sz.miejscowosc, ' ul.',sz.ulica,' ',sz.nr_posesji),
    CONCAT(p.rok_produkcji,' ',p.marka,' ',p.model,' ',p.poj_silnika),
    w.data_odbioru,w.data_zwrotu,w.data_zlozenia,w.status,coalesce(ow.powod,' ')
    FROM wnioski w 
    JOIN siedziby so ON w.id_miejsca_odbioru=so.id
    JOIN siedziby sz ON w.id_miejsca_zwrotu=sz.id
    JOIN pojazdy p ON w.id_samochodu=p.id
    LEFT JOIN odrzucone_wnioski ow ON ow.id_wniosku=w.id
    WHERE w.id_uzytkownika='$userID'
    ORDER BY 6 desc";
    $result = mysqli_query($conn, $sql);
    $row_cnt = mysqli_num_rows($result);
    if($row_cnt>0){
        echo '
        <div class="tableContainer">
        <table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
          <thead class="table-dark">
          <tr>
            <th class="th-sm">Miejsce odbioru</th>
            <th class="th-sm">Miejsce zwrotu</th>
            <th class="th-sm">Samochód</th>
            <th class="th-sm">Data odbioru</th>
            <th class="th-sm">Data zwrotu</th>
            <th class="th-sm">Data złożenia</th>
            <th class="th-sm">Status</th>
            <th class="th-sm">Dodatkowe informacje</th>
        </tr>
    </thead><tbody> ';
    while ($row = mysqli_fetch_row($result)){
        if($row[6]=="oczekujacy"){
            echo '<tr>';
        }
        if($row[6]=="zaakceptowany"){
            echo '<tr style="background-color:green;">';
        }
        if($row[6]=="odrzucony"){
            echo '<tr style="background-color:red;">';
        }
        echo '<td  class="adress">'.$row[0].'</td>
        <td  class="adress">'.$row[1].'</td>
        <td>'.$row[2].'</td>
        <td>'.$row[3].'</td>
        <td>'.$row[4].'</td>
        <td>'.$row[5].'</td>
        <td>'.$row[6].'</td>
        <td>'.$row[7].'</td>
        </tr>
        ';       
    }
    echo '
    </tbody>
  <tfoot class="table-dark">
  <th>Miejsce odbioru</th>
            <th>Miejsce zwrotu</th>
            <th>Samochód</th>
            <th>Data odbioru</th>
            <th>Data zwrotu</th>
            <th>Data złożenia</th>
            <th>Status</th>
            <th>Dodatkowe informacje</th>
    </tfoot>
    </table></div>
    ';
    }
    else {
        echo '<div class="alert alert-warning" role="alert">Nie złożyłeś jeszcze żadnego wniosku!</div>';
    }
} else header('Location: index.php?action=home'); 
?>