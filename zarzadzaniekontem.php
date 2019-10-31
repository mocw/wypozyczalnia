<?php
if(isset($_SESSION['uID']))
{
    echo '
    <div id="cssmenu">
    <ul>';
    if($_SESSION['isRoot']==1) echo '<li><a href="index.php?action=panelAdmin">Panel administracyjny</a></li>';
      echo'
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
    if($_SESSION['id_pracownika']!=NULL) echo '<center></br>Pracownik!</center>';   
    else echo '<center>Klient!</center>';
} else header('Location: index.php?action=home');
?>