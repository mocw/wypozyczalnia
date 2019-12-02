<?php
function wczytajTabele(){
    require 'includes/dbh.inc.php';
    echo '<div id="komunikat"></div>';
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
    <form method="POST" name="wypozyczenia" id="wypozyczenia" action="index.php?action=wypozyczeniaDlaObslugi" onsubmit="return validateFormPrzyjmij()">
    <div class="tableContainer">
        <table id="dtOrderExample" data-sort-name="name" data-sort-order="desc" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
          <thead class="table-dark">
          <tr>
            <th class="th-sm">Użytkownik</th>
            <th class="th-sm">Samochód</th>
            <th class="th-sm">VIN</th>
            <th class="th-sm">Miejsce odbioru</th>
            <th class="th-sm">Miejsce zwrotu</th>
            <th class="th-sm">Data odbioru</th>
            <th class="th-sm" data-field="name">Data zwrotu</th>
            <th class="th-sm">Przyjmij zwrot</th>
            <th class="th-sm">Czas do zwrotu</th>
        </tr>
    </thead><tbody>';

    $l=0;
    while ($row = mysqli_fetch_row($result)){ // TMR
        $l++;
        echo' <tr>
            <form id="profile" method="POST" action="index.php?action=wypozyczeniaDlaObslugi">
             <td  class="adress">
             <input type="hidden" name="userID" value="'.$row[8].'">
            <button type="submit" class="wniosek2" name="showProfile">'.$row[0].'</button>
            </td></form>
            <td>'.$row[1].'</td>
            <td>'.$row[2].'</td>
            <td>'.$row[3].'</td>
            <td>'.$row[4].'</td>
            <td>'.$row[5].'</td>
            <td id="datazwrotu'.$l.'">'.$row[6].'
            </td>
            <td>
            <center><button id="przyjmij'.$l.'" class="wniosek" name="przyjmij" value="'.$row[7].'" type="submit" disabled>
            <img src="images/positive_tick.gif" width="30px" height="25px"></img></button></center>
            </td>
            <td id="timer'.$l.'">
            </td>
            </tr>
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
  <th data-field="name">Data zwrotu</th>
  <th>Przyjmij zwrot</th>
  <th>Czas do zwrotu</th>
</tr>
  </tfoot>
    </table></div></form>';
    } else {
        // $sql="UPDATE samochody 
        // SET czyDostepny=1";
        // mysqli_query($conn,$sql);
        echo '<div class="alert alert-warning" role="alert">Brak wypożyczeń!</div>'; 
    }
}
if((isset($_SESSION['uID']) && $_SESSION['id_pracownika']!=NULL) || 
(isset($_SESSION['uID']) && $_SESSION['isRoot']==1)){
    require 'includes/employeepanel.php';
    require 'includes/dbh.inc.php';
    if(isset($_POST['przyjmij'])){
        $wID=$_POST['przyjmij'];
         $today=date("Y-m-d");
        $sql="SELECT w.data_zwrotu 
        FROM wypozyczenia wp
        JOIN wnioski w ON wp.id_wniosku=w.id
        WHERE wp.id='$wID'";
        $result = mysqli_query($conn, $sql);
        $row= mysqli_fetch_row($result);
        $data_zw=$row[0];

         if($data_zw>$today){  //MODAL YES NO
            echo '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                     <center>UWAGA</center>
                    </div>
                    <div class="modal-body">
                     Termin jeszcze nie minął. Czy chcesz przyjąć zwrot?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                        <form method="POST" action="index.php?action=wypozyczeniaDlaObslugi">
                        <input type="hidden" name="idWniosku" value='.$wID.'>                        
                        <button class="btn btn-success btn-ok" type="submit" name="potwierdz-zwrot">Potwierdź</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
          ';
          

            echo '<script>
        $(\'#confirm-delete\').modal({
          show: true
      }); 
        </script>
        '; 
         }
          else {
         $sql="SELECT vin
         FROM wypozyczenia w
         JOIN samochody s ON w.id_egzemplarza=s.id
         WHERE w.id='$_POST[przyjmij]'";
         $result = mysqli_query($conn, $sql);
         $row= mysqli_fetch_row($result);
         $vin=$row[0];          
           $sql="UPDATE samochody SET czyDostepny=1
           WHERE vin='$vin'";
           mysqli_query($conn,$sql);

           $sql="INSERT INTO archiwum_wypozyczen(id_wniosku,id_egzemplarza) 
            SELECT id_wniosku,id_egzemplarza
            FROM wypozyczenia 
            WHERE id='$_POST[przyjmij]'";
            mysqli_query($conn,$sql);

           $sql="DELETE FROM wypozyczenia WHERE id='$_POST[przyjmij]'";
           mysqli_query($conn,$sql);
           echo '<div class="disappear"><div class="alert alert-success" role="alert">Sukces!</div></div>';
          }
        echo '<script type="text/javascript" src="scripts/modalConfirm.js"></script>';
    }
    if(isset($_POST['showProfile'])){
        $id = $_POST["userID"];
        include 'includes/pokazProfil.php';  
       
    }

    if(isset($_POST['potwierdz-zwrot'])){
            $sql="SELECT vin
            FROM wypozyczenia w
            JOIN samochody s ON w.id_egzemplarza=s.id
            WHERE w.id='$_POST[idWniosku]'";
            $result = mysqli_query($conn, $sql);
            $row= mysqli_fetch_row($result);
            $vin=$row[0];          
            $sql="UPDATE samochody SET czyDostepny=1
            WHERE vin='$vin'";
            mysqli_query($conn,$sql);

            $sql="INSERT INTO archiwum_wypozyczen(id_wniosku,id_egzemplarza) 
            SELECT id_wniosku,id_egzemplarza
            FROM wypozyczenia 
            WHERE id='$_POST[idWniosku]'";
            mysqli_query($conn,$sql);
   
            $sql="DELETE FROM wypozyczenia WHERE id='$_POST[idWniosku]'";
            mysqli_query($conn,$sql);
            echo '<div class="disappear"><div class="alert alert-success" role="alert">Sukces!</div></div>';
    }
    wczytajTabele();

} else header('Location: index.php?action=home'); 
?>
<script type="text/javascript" src="scripts/await.js"></script>
<script type="text/javascript" src="scripts/timer.js"></script>
<script type="text/javascript" src="scripts/formValidation.js"></script>