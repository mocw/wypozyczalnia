<?php
if(isset($_SESSION['uID']))
{
    echo '
    <div id="menu2" >
    <nav class="menu2">
        <ul>';
        if($_SESSION['isRoot']==1) {
            if($_GET['action']=='panelAdmin' || $_GET['action']=='uprawnienia' || $_GET['action']=='setPermissions'
            || $_GET['action']=='dodajPracownika' || $_GET['action']=='dodajPracownika_inc'
            || $_GET['action']=='dodajPracownika_inc_cd' || $_GET['action']=='usunPracownika' 
            || $_GET['action']=='usunPracownika_inc') 
            echo'<u><li><b><a href="index.php?action=panelAdmin">Panel administracyjny</a></li></b></u>';
            else echo '<li><a href="index.php?action=panelAdmin">Panel administracyjny</a></li>';
        }
           echo'<li><a href="#">Twoje wypożyczenia</a>
            <!-- Pierwszy Drop Down -->    
            </li>';
            if($isDataFilled==1) echo '<li><a href="index.php?action=wnioskiKlienta">Twoje wnioski</a></li>';
            if($_GET['action']=='fillData') echo '<u><b><li><a>Dane+</a></u></b>';
            else echo '<li><a>Dane</a>';
           // <!-- First Tier Drop Down -->  
           echo '<ul>';
            if($isDataFilled==0){
                if($_GET['action']=='fillData') echo '<u><b><li><a href="index.php?action=fillData" style="color:red">Uzupełij</a></li></b></u>';
                else echo '<li><a href="index.php?action=fillData" style="color:red">Uzupełij</a></li>';
            } 
            if($isDataFilled==1) echo '<li><a href="index.php?action=editData">Edytuj</a></li>
            <li><a href="index.php?action=changePassword">Zmień hasło</a></li>';
            echo '</ul>  
        </ul>
        </li>
    </nav>
</div>
    ';
} else header('Location: index.php?action=home');
?>