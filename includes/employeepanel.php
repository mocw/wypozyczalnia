<?php
if((isset($_SESSION['uID']) && $_SESSION['id_pracownika']!=NULL) || 
$_SESSION['isRoot']==1)
{
    echo '
    <div id="menu2" >
    <nav class="menu2">
        <ul>
            <li><a href="index.php?action=flota">Flota</a></li>
            <li><a href="index.php?action=wypozyczeniaDlaObslugi">Wypożyczenia</a></li>
            <li><a href="index.php?action=wnioskiDlaObslugi">Wnioski</a></li>';
            if($_GET['action']=='addCarForm'  
            || $_GET['action']=='addCar') echo'<u><b><li><a>Pojazdy+</a></b></u>';
            else echo'<li><a>Pojazdy</a>';
            //<!-- Pierwszy Drop Down -->
           echo '<ul>';
             if($_GET['action']=='addCarForm' 
             || $_GET['action']=='addCar'){
                echo '<u><li><b><a href="index.php?action=addCarForm" name="addCar">Dodaj</a></b></li></u>';
             } else echo '<li><a href="index.php?action=addCarForm" name="addCar">Dodaj</a></li>';
             echo '<li><a href="#">Usuń</a></li>
                <li><a href="#">Egzemplarze</a>
                <ul>
                    <li><a href="index.php?action=dodajEgzemplarz">Dodaj</a></li>
               </li>
            </ul>  
</ul>      
            </li>
            <!-- First Tier Drop Down -->  
        </ul>
    </nav>
</div>
    ';
}
else header('Location: index.php?action=home');
?>

