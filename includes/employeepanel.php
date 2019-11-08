<?php
if((isset($_SESSION['uID']) && $_SESSION['id_pracownika']!=NULL) || 
$_SESSION['isRoot']==1)
{
    echo '
    <div id="menu2" >
    <nav class="menu2">
        <ul>
            <li><a href="#">Wypożyczenia</a></li>';
            if($_GET['action']=='addCarForm') echo'<u><b><li><a>Pojazdy+</a></b></u>';
            else echo'<li><a>Pojazdy</a>';
            //<!-- Pierwszy Drop Down -->
           echo '<ul>';
             if($_GET['action']=='addCarForm'){
                echo '<u><li><b><a href="index.php?action=addCarForm" name="addCar">Dodaj</a></b></li></u>';
             } else echo '<li><a href="index.php?action=addCarForm" name="addCar">Dodaj</a></li>';
             echo '<li><a href="#">Usuń</a></li>
                <li><a href="#">Egzemplarze</a>
                <ul>
                    <li><a href="#">Dodaj</a></li>
                    <li><a href="#">Usuń</a>
               </li>
            </ul>  
</ul>      
            </li>
            <li><a href="#">Wnioski</a>
            <!-- First Tier Drop Down -->  
            </li>
        </ul>
    </nav>
</div>
    ';
}
else header('Location: index.php?action=home');
?>

