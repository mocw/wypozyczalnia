<?php

function wczytajTabele(){
    require 'includes/dbh.inc.php';
    $sql="SELECT w.id,u.uidUsers,CONCAT(so.miejscowosc, ' ul.',so.ulica,' ',so.nr_posesji),
    CONCAT(sz.miejscowosc, ' ul.',sz.ulica,' ',sz.nr_posesji),
    CONCAT(p.rok_produkcji,' ',p.marka,' ',p.model,' ',p.poj_silnika),
    w.data_odbioru,w.data_zwrotu,w.data_zlozenia,u.userID
    FROM wnioski w 
    JOIN siedziby so ON w.id_miejsca_odbioru=so.id
    JOIN siedziby sz ON w.id_miejsca_zwrotu=sz.id
    JOIN pojazdy p ON w.id_samochodu=p.id
    JOIN users u ON w.id_uzytkownika=u.userID
    WHERE w.status='oczekujacy'
    ORDER BY w.data_zlozenia";
    $result = mysqli_query($conn, $sql);
    $row_cnt = mysqli_num_rows($result);
    if($row_cnt>0){
        echo '
        <form method="POST" action="index.php?action=wnioskiDlaObslugi">
        <div class="tableContainer">
        <table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
          <thead class="table-dark">
          <tr>
            <th class="th-sm">Nazwa użytkownika</th>
            <th class="th-sm">Miejsce odbioru</th>
            <th class="th-sm">Miejsce zwrotu</th>
            <th class="th-sm">Samochód</th>
            <th class="th-sm">Data odbioru</th>
            <th class="th-sm">Data zwrotu</th>
            <th class="th-sm">Data złożenia</th>
            <th class="th-sm"></th>
        </tr>
    </thead><tbody>';
    while ($row = mysqli_fetch_row($result)){
        echo '<tr>
        <form method="POST" action="index.php?action=wnioskiDlaObslugi">
        <td  class="adress">
        <input type="hidden" name="userID" value="'.$row[8].'">
        <button type="submit" class="wniosek2" name="showProfile">'.$row[1].'</button>
        </td></form>
        <td  class="adress">'.$row[2].'</td>
        <td>'.$row[3].'</td>
        <td>'.$row[4].'</td>
        <td>'.$row[5].'</td>
        <td>'.$row[6].'</td>
        <td>'.$row[7].'</td>
        <td style="white-space: nowrap;">
        <button class="wniosek" name="accept" value="'.$row[0].'" type="submit">
        <img src="images/positive_tick.gif" width="27px" height="25px"></img></button>
        <button class="wniosek" name="decline" value="'.$row[0].'" type="submit">
        <img src="images/negative_tick.gif" width="27px" height="26px"></img></button>
        </tr>
        ';       
    }
    echo '
    </tbody>
    <tfoot class="table-dark">
    <tr>
    <th>Nazwa użytkownika</th>
    <th>Miejsce odbioru</th>
    <th>Miejsce zwrotu</th>
    <th>Samochód</th>
    <th>Data odbioru</th>
    <th>Data zwrotu</th>
    <th>Data złożenia</th>
    <th></th>
</tr>
</tfoot>
    </table></form></div>
    ';
    }
    else {
        echo '<div class="alert alert-warning" role="alert">Brak wniosków!</div>';
    }
}

function przydzielPojazd($id){
    require 'includes/dbh.inc.php';
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
    ';
        $sql="SELECT id_miejsca_odbioru,id_miejsca_zwrotu,id_uzytkownika,id_samochodu,data_odbioru,data_zwrotu
        FROM wnioski 
        WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $rowD = mysqli_fetch_row($result);
        $idODbior=$rowD[0];
        $idZwrot=$rowD[1];
        $userID=$rowD[2];
        $carID=$rowD[3];
        $dataOdbioru=$rowD[4];
        $dataZwrotu=$rowD[5];
    
        $sql="SELECT s.id,CONCAT('VIN: ',s.vin)
        FROM samochody_siedziby ss
        JOIN samochody s ON ss.id_pojazdu=s.id
        JOIN pojazdy p ON s.id_samochodu=p.id
        WHERE s.id_samochodu='$carID' AND ss.id_siedziby='$idODbior' AND s.czyDostepny=1";  
        $result = mysqli_query($conn, $sql);

        echo '
        <div class="containerForm">
        <form id="contact" action="index.php?action=wnioskiDlaObslugi" method="post" enctype="multipart/form-data">
        <center><b>Przydziel egzemplarz:</b></br></br></center>
        <fieldset>
        <select class="egzemplarze" name="idEgzemplarza" required autofocus>';
          while ($row = mysqli_fetch_row($result)) {
            echo '
            <option value="'.$row[0].'">'.$row[1].'</option>';
          }      
        echo '</select>
        </fieldset>
        <input type="hidden" name="idWniosku" value="'.$id.'">
        </br></br><button name="przydzial-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
        </form>
        </div>
        ';
        echo '
    </div>
</div>
</div></div>';

echo '<script>
$(\'#exampleModalCenter\').modal({
  show: true
}); 
</script>
';  
}

function odrzucWniosek($id){
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
    <div class="containerForm">
    <form id="contact" action="index.php?action=wnioskiDlaObslugi" method="post" enctype="multipart/form-data">
    <center><b>Podaj powód:</b></br></br></center>
    <fieldset>
    <input placeholder="Powód" name="powod" type="text" tabindex="1" required autofocus>
    </fieldset>
    <input type="hidden" name="idWniosku" value="'.$id.'">
    </br></br><button name="odrzuc-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
    </form>
    </div></div>
    </div>
    </div></div>
    ';

    echo '<script>
     $(\'#exampleModalCenter\').modal({
       show: true
   }); 
     </script>
     ';  
}

if((isset($_SESSION['uID']) && $_SESSION['id_pracownika']!=NULL) || 
(isset($_SESSION['uID']) && $_SESSION['isRoot']==1)) {
    require 'includes/employeepanel.php';
    if(isset($_POST['odrzuc-submit'])){
        $wniosekID=$_POST['idWniosku'];
        $powod=$_POST['powod'];
        $sql="INSERT INTO odrzucone_wnioski(id_wniosku,powod)
        VALUES('$wniosekID','$powod')";
        mysqli_query($conn,$sql);

        $sql="UPDATE wnioski SET status='odrzucony'
        WHERE id='$wniosekID'";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt); 
        echo '<div class="disappear"><div class="alert alert-success" role="alert">Wniosek odrzucony!</div></div>';
    }

    if(isset($_POST['przydzial-submit'])){
        require 'includes/dbh.inc.php';
        $sql="SELECT czyDostepny
        FROM samochody
        WHERE id='$_POST[idEgzemplarza]' AND czyDostepny=0";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)!=0){
          echo '<div class="alert alert-danger" role="alert">Samochód już został wypożyczony!</div>';
        } else {
        $sql="INSERT INTO wypozyczenia(id_wniosku,id_egzemplarza) VALUES('$_POST[idWniosku]',
        '$_POST[idEgzemplarza]')";
        mysqli_query($conn,$sql);
        $sql="UPDATE samochody SET czyDostepny=0
        WHERE id='$_POST[idEgzemplarza]'";
        mysqli_query($conn,$sql);
        
        $sql="UPDATE wnioski SET status='zaakceptowany'
        WHERE id='$_POST[idWniosku]'";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt); 
        echo '<div class="disappear"><div class="alert alert-success" role="alert">Wniosek zaakceptowany!</div></div>';
        }        
    }
    if(isset($_POST['accept'])){
        $id=$_POST['accept'];
        przydzielPojazd($id);
    } else if(isset($_POST['decline'])) {
        $id=$_POST['decline'];
        odrzucWniosek($id);
       
    }

    if(isset($_POST['showProfile'])){ //POKAZ PROFIL
        $id = $_POST["userID"];
        include 'includes/pokazProfil.php';           
    } //POKAZ PROFIL-END
   wczytajTabele();
} else {
    header('Location: index.php?action=home'); 
}
?>