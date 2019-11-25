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
    <table class="table">
    <thead>
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
    </thead>';

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
            <center><button class="wniosek" name="przyjmij" value="'.$row[7].'" type="submit">
            <img src="images/positive_tick.gif" width="30px" height="25px"></img></button></center>
            </td>
        ';
    }
    echo '</table></form>';
    } else echo '<div class="alert alert-warning" role="alert">Brak wypożyczeń!</div>'; 
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
        <div class="modal" id="modal-one" aria-hidden="true">
        <div class="modal-dialog">
     <a href="" class="btn-close" aria-hidden="true">×</a>
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
            </div></div</div></div>
        ';
    }
    wczytajTabele();

} else header('Location: index.php?action=home'); 
?>