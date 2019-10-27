<?php
if(isset($_SESSION['uID']) && $_SESSION['czyPracownik']==1)
{
    echo '
    <div id="cssmenu">
    <ul>
       <li><a href="#">Wypożyczenia</a></li>
       <li class="active"><a href="">Pojazdy</a>
          <ul>
             <li><a href="index.php?action=addCarForm" name="addCar">Dodaj</a>
             </li>
             <li><a href="#Product 1">Usuń</a>
             </li>
             <li><a>Egzemplarze</a>
                <ul>
                   <li><a href="#">Dodaj</a></li>
                   <li><a href="#">Usuń</a></li>
                </ul>
             </li>
          </ul>
       </li>
       <li><a href="#">Wnioski</a></li>
    </ul>
    </div>
    ';
}
else header('Location: index.php?action=home');
?>


<!--
    <center><nav class="navigation">
  <ul class="mainmenu">
    <li><a href="">Wypożyczenia</a></li>
    <li><a href="">Wnioski</a></li>
    <li><a class="none">Pojazdy</a>
      <ul class="submenu">
      <li><a href="index.php?action=addCarForm" name="addCar">Dodaj pojazd</a></li>
        <li><a href="">Dodaj egzemplarz</a></li>
        <li><a href="">Usuń egzemplarz</a></li>
      </ul>
    </li>
  </ul>
</nav></center>
-->
