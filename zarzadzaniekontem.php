<?php
if(isset($_SESSION['uID']))
{
    echo '
    <div id="cssmenu">
    <ul>
       <li><a href="#">Twoje wypożyczenia</a></li>
       <li class="active"><a href="">Dane</a>
          <ul>';
             if($isDataFilled==0) echo '<li><b><a href="index.php?action=fillData">Uzupełnij</a></b>';
          echo'<li><a href="">Edytuj</a>
             </li>            
          </ul>
       </li>
    </ul>
    </div>
    ';
    echo '<center>Witaj ',$_SESSION['imie']," ",$_SESSION['nazwisko'],'</center>';
    if($_SESSION['czyPracownik']==1) echo '<center></br>Pracownik!</center>';   
    else echo '<center>Jesteś klientem!</center>';
} else header('Location: index.php?action=home');
?>