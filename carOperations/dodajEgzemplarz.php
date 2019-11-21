<?php
function loadForm(){

    require 'includes/dbh.inc.php';
    echo '
    <div class="container">  
  <form id="contact"  class="exceptModal" action="index.php?action=dodajEgzemplarz" method="post" enctype="multipart/form-data">
    <fieldset>
      <input placeholder="Numer VIN" name="vin" type="text" tabindex="1" required autofocus>
    </fieldset>
    <center><p><b>Wybierz pojazd</b></p></center>
    ';
    $sql="SELECT id,CONCAT(rok_produkcji, ' ',marka,' ',model,' ',poj_silnika)
    FROM pojazdy";
    $result = mysqli_query($conn, $sql);
    echo '<fieldset><center><select name="pojazd" class="egzemplarze">';
    while ($row = mysqli_fetch_row($result)) {
        echo '
        <option value="'.$row[0].'">'.$row[1].'</option>';
    }
    echo '</select></center></fieldset>
    <center><p><b>Wybierz siedzibę</b></p></center>';
    $sql="SELECT id, CONCAT(miejscowosc, ' ul.',ulica,' nr.',nr_posesji)
    FROM siedziby";
    $result = mysqli_query($conn, $sql);
    echo '<fieldset><select name="siedziba" class="egzemplarze">';
    while ($row = mysqli_fetch_row($result)) {
        echo '
        <option value="'.$row[0].'">'.$row[1].'</option>';
    }
    echo '</select></fieldset>';
    echo '</br></br><button name="add-egzemplarz-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
    </fieldset>
    </form>
    </div>';
}

if((isset($_SESSION['uID']) && $_SESSION['id_pracownika']!=NULL) || ($_SESSION['isRoot']==1)) {
    require 'includes/employeepanel.php';
    if(isset($_POST['add-egzemplarz-submit'])){
        $sql="SELECT vin FROM samochody
        WHERE vin='$_POST[vin]'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)>0){
            echo '<div class="alert alert-danger" role="alert">Ten pojazd już istnieje!</div>';
        }
        else {
            $vin=$_POST['vin'];
            $idSamochodu=$_POST['pojazd'];
            $idSiedziby=$_POST['siedziba'];
            $sql="INSERT INTO samochody(vin,id_samochodu) VALUES('$vin','$idSamochodu')";
            mysqli_query($conn,$sql);
            $last_id = mysqli_insert_id($conn);
            $sql="INSERT INTO samochody_siedziby(id_pojazdu,id_siedziby) VALUES('$last_id','$idSiedziby')";
            mysqli_query($conn,$sql);  
            echo '<div class="disappear"><div class="alert alert-success" role="alert">Pojazd dodany!</div></div>';           
        }
    }
        loadForm();
} else header('Location: index.php?action=home');
?>
