<?php
if(isset($_SESSION['uID']))
{
    require 'zarzadzaniekontem.php';
    require 'includes/dbh.inc.php';
    $userID=$_SESSION['uID'];
    $sql="SELECT CONCAT(so.miejscowosc, ' ul.',so.ulica,' ',so.nr_posesji),
    CONCAT(sz.miejscowosc, ' ul.',sz.ulica,' ',sz.nr_posesji),
    CONCAT(p.rok_produkcji,' ',p.marka,' ',p.model,' ',p.poj_silnika),
    w.data_odbioru,w.data_zwrotu,w.data_zlozenia,w.status
    FROM wnioski w 
    JOIN siedziby so ON w.id_miejsca_odbioru=so.id
    JOIN siedziby sz ON w.id_miejsca_zwrotu=sz.id
    JOIN pojazdy p ON w.id_samochodu=p.id
    WHERE w.id_uzytkownika='$userID'
    ORDER BY 6,7";
    $result = mysqli_query($conn, $sql);
    $row_cnt = mysqli_num_rows($result);
    if($row_cnt>0){
        echo '
    <table class="table">
    <thead>
        <tr>
            <th>Miejsce odbioru</th>
            <th>Miejsce zwrotu</th>
            <th>Samochód</th>
            <th>Data odbioru</th>
            <th>Data zwrotu</th>
            <th>Data złożenia</th>
            <th>Status</th>
        </tr>
    </thead>';
    while ($row = mysqli_fetch_row($result)){
        if($row[6]=="oczekujacy"){
            echo '<tr class="awaiting">';
        }
        if($row[6]=="zaakceptowany"){
            echo '<tr class="accept">';
        }
        if($row[6]=="odrzucony"){
            echo '<tr class="decline">';
        }
        echo '<td  class="adress">'.$row[0].'</td>
        <td  class="adress">'.$row[1].'</td>
        <td>'.$row[2].'</td>
        <td>'.$row[3].'</td>
        <td>'.$row[4].'</td>
        <td>'.$row[5].'</td>
        <td>'.$row[6].'</td>
        </tr>
        ';       
    }
    echo '</table>
    ';
    }
    else {
        echo '<div class="alert alert-warning" role="alert">Nie złożyłeś jeszcze żadnego wniosku!</div>';
    }
}
?>