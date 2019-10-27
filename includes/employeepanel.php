<?php
if(isset($_SESSION['uID']) && $_SESSION['czyPracownik']==1)
{
    echo '

    <center><nav class="navigation">
  <ul class="mainmenu">
    <li><a href="">Wypożyczenia</a></li>
    <li><a href="">Wnioski</a></li>
    <li><a class="none">Pojazdy</a>
      <ul class="submenu">
      <li><a href="index.php?action=addCar" name="addCar">Dodaj pojazd</a></li>
        <li><a href="">Dodaj egzemplarz</a></li>
        <li><a href="">Usuń egzemplarz</a></li>
      </ul>
    </li>
  </ul>
</nav></center>
    ';
}
else header('Location: index.php?action=home');
?>