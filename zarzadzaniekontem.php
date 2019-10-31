<?php
if(isset($_SESSION['uID']))
{
    echo '
    <div id="menu2" >
    <nav class="menu2">
        <ul>';
        if($_SESSION['isRoot']==1) echo'<li><a href="index.php?action=panelAdmin">Panel administracyjny</a></li>';
           echo'<li><a href="#">Twoje wypożyczenia</a>
            <!-- Pierwszy Drop Down -->    
            </li>
            <li><a href="#">Dane</a>
            <!-- First Tier Drop Down -->  
            <ul>';
            if($isDataFilled==0) echo '<li><a href="#">Uzupełij</a></li>';
            echo '<li><a href="#">Edytuj</a></li>
            </ul>  
        </ul>
        </li>
    </nav>
</div>
    ';
} else header('Location: index.php?action=home');
?>