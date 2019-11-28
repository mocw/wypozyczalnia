<script>
window.onload = function(){
  document.forms['sukces'].submit();
}

</script>

<?php
function updateData(){
    $_SESSION['email']=$_POST['email'];
    $_SESSION['imie']=$_POST['imie'];
    $_SESSION['nazwisko']=$_POST['nazwisko'];
    $_SESSION['nr_tel']=$_POST['nr_tel'];
}

if(isset($_SESSION['uID'])){
require 'dbh.inc.php';
require 'zarzadzaniekontem.php';
if(isset($_POST['updateSuccess'])) echo '<div class="disappear"><div class="alert alert-success" role="alert">Dane zaktualizowane!</div></div>';
$sql="SELECT * FROM users WHERE userID='$_SESSION[uID]'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$email=$row[3];
$imie=$row[4];
$nazwisko=$row[5];
$pesel=$row[6];
$nr_tel=$row[7];
$sql="SELECT * FROM klienci 
JOIN users ON klienci.id=users.id_klienta";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$nr_dowodu=$row[1];
$nr_karty_kredytowej=$row[2];
$ulica=$row[3];
$miejscowosc=$row[4];
$kod_pocztowy=$row[5];
$nr_mieszkania=$row[6];
$nr_domu=$row[7];

if(isset($_POST['passwordValidation-submit'])){
      $password=$_POST['password'];
      $sql="SELECT * FROM users
      WHERE userID='$_SESSION[uID]'";
      $stmt=mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt,$sql);
      mysqli_stmt_execute($stmt);
      $result=mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      $pwdCheck=password_verify($password,$row['pwdUsers']);
      if($pwdCheck==false) {
            echo '<div class="alert alert-danger" role="alert">Błędne hasło!</div>';
      }
      else{
            $sql="UPDATE users
            SET email='$_POST[email]',imie='$_POST[imie]',nazwisko='$_POST[nazwisko]',nr_tel='$_POST[nr_tel]'
            WHERE userID='$_SESSION[uID]'";
            $stmt=mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
            } else {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                updateData();
            
                if($_SESSION['id_klienta']!=NULL) {
                    $sql="UPDATE klienci
                    SET nr_dowodu='$_POST[nr_dowodu]',nr_karty_kredytowej='$_POST[nr_karty]',ulica='$_POST[ulica]',
                    miejscowosc='$_POST[miejscowosc]',kod_pocztowy='$_POST[kod_pocztowy]',nr_mieszkania='$_POST[numer_mieszkania]',
                    nr_domu='$_POST[numer_domu]'
                    WHERE id=(SELECT id_klienta
                    FROM users
                    WHERE userID='$_SESSION[uID]')";
                    $stmt=mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt,$sql);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
            
                }
                echo '<form name="sukces" method="POST" action="index.php?action=editData">
                <input type="hidden" name="updateSuccess" value="1">
                </form>';
            }
      }
}

if(isset($_POST['editData-submit'])) {
echo '
<div id="toClose">
<div class="container">  
<form id="contact"  class="exceptModal" method="POST" action="index.php?action=editData" accept-charset="UTF-8">
<center><b>Podaj hasło</b></center></br>
<fieldset>
      <input placeholder="Hasło" name="password" type="password" tabindex="1" required autofocus>
</fieldset>
<input type="hidden" name="email" value="'.$_POST['email'].'">
<input type="hidden" name="imie" value="'.$_POST['imie'].'">
<input type="hidden" name="nazwisko" value="'.$_POST['nazwisko'].'">
<input type="hidden" name="nr_tel" value="'.$_POST['nr_tel'].'">
<input type="hidden" name="nr_dowodu" value="'.$_POST['nr_dowodu'].'">
<input type="hidden" name="nr_karty" value="'.$_POST['nr_karty'].'">
<input type="hidden" name="ulica" value="'.$_POST['ulica'].'">
<input type="hidden" name="miejscowosc" value="'.$_POST['miejscowosc'].'">
<input type="hidden" name="kod_pocztowy" value="'.$_POST['kod_pocztowy'].'">
<input type="hidden" name="numer_mieszkania" value="'.$_POST['numer_mieszkania'].'">
<input type="hidden" name="numer_domu" value="'.$_POST['numer_domu'].'">
<fieldset>
      <button name="passwordValidation-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
</fieldset>
</div>
</form>
</div>
';
}
else {
echo '
<div id="toClose">
<div class="container">  
<form id="contact"  class="exceptModal" method="POST" action="index.php?action=editData" accept-charset="character_set">
<center><b>E-mail</b></center></br>
<fieldset>
      <input placeholder="Adres e-mail*" name="email" type="text" tabindex="1" required autofocus
      value="'.$email.'">
</fieldset>
<center><b>Imie</b></center></br>
<fieldset>
      <input placeholder="Imie*" name="imie" type="text" tabindex="1" required autofocus
      value="'.$imie.'">
</fieldset>
<center><b>Nazwisko</b></center></br>
<fieldset>
      <input placeholder="Nazwisko*" name="nazwisko" type="text" tabindex="1" required autofocus
      value="'.$nazwisko.'">
</fieldset>
<center><b>Numer telefonu</b></center></br>
<fieldset>
      <input placeholder="Numer telefonu*" name="nr_tel" type="text" tabindex="1" required autofocus
      value="'.$nr_tel.'">
</fieldset>';
if($_SESSION['id_klienta']!=NULL){
    echo '
    <center><b>Numer dowodu osobistego</b></center></br>
    <fieldset>
          <input placeholder="Numer dowodu osobistego*" name="nr_dowodu" type="text" tabindex="1" required autofocus
          value="'.$nr_dowodu.'">
    </fieldset>
    <center><b>Numer karty kredytowej</b></center></br>
    <fieldset>
          <input placeholder="Numer karty kredytowej*" name="nr_karty" type="text" tabindex="1" required autofocus
          value="'.$nr_karty_kredytowej.'">
    </fieldset>
    <center><b>Ulica</b></center></br>
    <fieldset>
          <input placeholder="Ulica*" name="ulica" type="text" tabindex="1" required autofocus
          value="'.$ulica.'">
    </fieldset>
    <center><b>Miejscowość</b></center></br>
    <fieldset>
          <input placeholder="Miejscowość*" name="miejscowosc" type="text" tabindex="1" required autofocus
          value="'.$miejscowosc.'">
    </fieldset>
    <center><b>Kod pocztowy</b></center></br>
    <fieldset>
          <input placeholder="Kod pocztowy*" name="kod_pocztowy" type="text" tabindex="1" required autofocus
          value="'.$kod_pocztowy.'">
    </fieldset>
    <center><b>Numer mieszkania</b></center></br>
    <fieldset>
          <input placeholder="Numer mieszkania" name="numer_mieszkania" type="number" tabindex="1"
          value="'.$nr_mieszkania.'">
    </fieldset>
    <center><b>Numer domu</b></center></br>
    <fieldset>
          <input placeholder="Numer domu*" name="numer_domu" type="number" tabindex="1" required autofocus
          value="'.$nr_domu.'">
    </fieldset>
    ';
}
echo'
<p style="color:red">* - pola obowiązkowe</p>
<fieldset>
      <button name="editData-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
</fieldset>
</div>
</form>
</div>
';
}
} else header('Location: index.php?action=home');
?>

