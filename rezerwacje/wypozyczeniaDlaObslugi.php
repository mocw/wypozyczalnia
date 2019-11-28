<?php
function wczytajTabele(){
    require 'includes/dbh.inc.php';
    $sql="SELECT u.uidUSers,CONCAT(p.marka,' ',p.model),sm.vin,
    CONCAT(so.miejscowosc,' ul.',so.ulica,' ',so.nr_posesji),
    CONCAT(sz.miejscowosc,' ul.',sz.ulica,' ',sz.nr_posesji),
    w.data_odbioru,w.data_zwrotu,wp.id,u.userID
    FROM wypozyczenia wp 
    JOIN wnioski w ON wp.id_wniosku=w.id
    JOIN siedziby so ON w.id_miejsca_odbioru=so.id
    JOIN siedziby sz ON w.id_miejsca_zwrotu=sz.id
    JOIN samochody sm ON wp.id_egzemplarza=sm.id
    JOIN pojazdy p ON sm.id_samochodu=p.id
    JOIN users u ON w.id_uzytkownika=u.userID
    ";
     $result = mysqli_query($conn, $sql);
     $row_cnt = mysqli_num_rows($result);
     if($row_cnt>0){
    echo '
    <form method="POST" action="index.php?action=wypozyczeniaDlaObslugi">
    <div class="tableContainer">
        <table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
          <thead class="table-dark">
          <tr>
            <th class="th-sm">Użytkownik</th>
            <th class="th-sm">Samochód</th>
            <th class="th-sm">VIN</th>
            <th class="th-sm">Miejsce odbioru</th>
            <th class="th-sm">Miejsce zwrotu</th>
            <th class="th-sm">Data odbioru</th>
            <th class="th-sm">Data zwrotu</th>
            <th class="th-sm">Przyjmij zwrot</th>
        </tr>
    </thead><tbody> ';

    while ($row = mysqli_fetch_row($result)){
        echo' <tr>
            <form method="POST" action="index.php?action=wypozyczeniaDlaObslugi">
             <td  class="adress">
             <input type="hidden" name="userID" value="'.$row[8].'">
            <button type="submit" class="wniosek2" name="showProfile">'.$row[0].'</button>
            </td></form>
            <td>'.$row[1].'</td>
            <td>'.$row[2].'</td>
            <td>'.$row[3].'</td>
            <td>'.$row[4].'</td>
            <td>'.$row[5].'</td>
            <td>'.$row[6].'</td>
            <td>
            <input type="hidden" name="vin" value="'.$row[2].'">
            <center><button id="przyjmij" class="wniosek" name="przyjmij" value="'.$row[7].'" type="submit">
            <img src="images/positive_tick.gif" width="30px" height="25px"></img></button></center>
            </td>
        ';
    }
    echo '
    </tbody>
  <tfoot class="table-dark">
  <tr>
  <th>Użytkownik</th>
  <th>Samochód</th>
  <th>VIN</th>
  <th>Miejsce odbioru</th>
  <th>Miejsce zwrotu</th>
  <th>Data odbioru</th>
  <th>Data zwrotu</th>
  <th>Przyjmij zwrot</th>
</tr>
  </tfoot>
    </table></div></form>';
    } else {
        $sql="UPDATE samochody 
        SET czyDostepny=1";
        mysqli_query($conn,$sql);
        echo '<div class="alert alert-warning" role="alert">Brak wypożyczeń!</div>'; 
    }
}
if((isset($_SESSION['uID']) && $_SESSION['id_pracownika']!=NULL) || 
(isset($_SESSION['uID']) && $_SESSION['isRoot']==1)){
    require 'includes/employeepanel.php';
    require 'includes/dbh.inc.php';
    if(isset($_POST['przyjmij'])){
        $sql="UPDATE samochody SET czyDostepny=1
        WHERE vin='$_POST[vin]'";
        mysqli_query($conn,$sql);

        $sql="DELETE FROM wypozyczenia WHERE id='$_POST[przyjmij]'";
        mysqli_query($conn,$sql);
        echo '<div class="disappear"><div class="alert alert-success" role="alert">Sukces!</div></div>';
    }
    if(isset($_POST['showProfile'])){
        $id = $_POST["userID"];
        include 'includes/dbh.inc.php';
        $sql="SELECT uidUsers,email,imie,nazwisko,data_ur,id_klienta,nr_tel
        FROM users
        WHERE userID='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        echo '
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="profile">
                <div class="info">
                    <h2 id="info-title">Profil użytkownika '.$row[0].'</h2>
                    <div class="fact">
                        <div class="title">Imie</div>
                        <div class="value">'.$row[2].'</div>
                    </div>
                    <div class="fact">
                        <div class="title">Nazwisko</div>
                        <div class="value">'.$row[3].'</div>
                    </div>
                    <div class="fact">
                        <div class="title">Adres e-mail</div>
                        <div class="value">'.$row[1].'</div>
                    </div>
                    <div class="fact">
                        <div class="title">Data urodzenia</div>
                        <div class="value">'.$row[4].'</div></div>';
                        if($row[5]!=0){
                            echo '
                            <div class="fact">
                            <div class="title">Numer telefonu</div>
                             <div class="value">'.$row[6].'</div></div>
                            ';
    
                            $sql="SELECT nr_dowodu,nr_karty_kredytowej,CONCAT(miejscowosc,' ul.',ulica,' ',nr_domu,
                            CONCAT(' mieszkania nr. ',CASE WHEN nr_mieszkania IS NOT NULL
                                             THEN nr_mieszkania 
                                             ELSE ' brak '
                                             END)
                         )
                         FROM klienci
                         WHERE id='$row[5]'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_row($result);
                        }
                        echo '
                        <div class="fact">
                        <div class="title">Numer dowodu osobistego</div>
                        <div class="value">'.$row[0].'</div></div>
                        <div class="fact">
                            <div class="title">Numer karty kredytowej</div>
                             <div class="value">'.$row[1].'</div></div>
                             <div class="fact">
                            <div class="title">Adres</div>
                             <div class="value">'.$row[2].'</div></div>
                        ';
                    echo '</div>
                </div>
            </div></div></div></div>
        ';
        echo '<script>
        $(\'#exampleModalCenter\').modal({
          show: true
      }); 
        </script>
        '; 
    }
    wczytajTabele();

} else header('Location: index.php?action=home'); 
?>
<script type="text/javascript" src="scripts/await.js"></script>