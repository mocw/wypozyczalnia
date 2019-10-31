<?php
if(isset($_SESSION['uID']) && $_SESSION['isRoot']==1){
    require 'includes/dbh.inc.php';
    $sql="
    SELECT u.userID,u.uidUsers,u.imie,u.nazwisko,u.pesel,u.data_ur,u.nr_tel,IFNULL(u.id_pracownika,'') id_pracownika,IFNULL(p.data_zatr,'') data_zatr,IFNULL(s.nazwa,'') stanowisko 
    FROM users u 
    LEFT JOIN pracownicy p 
    ON u.id_pracownika=p.id 
    LEFT JOIN stanowiska s 
    oN p.id_stanowiska=s.id 
    WHERE NOT u.uidUsers='root'
    ";
    $stmt=mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_execute($stmt);
    $users=mysqli_stmt_get_result($stmt);
    mysqli_fetch_all($users,MYSQLI_ASSOC);
    echo '
    <form method="POST" action="index.php?action=dodajPracownika_inc">
    <table class="table">
    <thead>
        <tr>
            <th>
            Pracownik
            </th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Pesel</th>
            <th>Data urodzenia</th>
            <th>Numer telefonu</th>
            <th>Data zatrudnienia</th>
            <th>Stanowisko</th>
        </tr>
    </thead> ';
    foreach ($users as $row) {
        $id=$row['userID'];
        $username=$row['uidUsers'];
        $imie=$row['imie'];
        $nazwisko=$row['nazwisko'];
        $pesel=$row['pesel'];
        $data_ur=$row['data_ur'];
        $nr_tel=$row['nr_tel'];
        $id_pracownika=$row['id_pracownika'];
        $data_zatr=$row['data_zatr'];
        $stanowisko=$row['stanowisko'];
        echo '
        <tbody>
        <tr>';
        if($row['userID']!=$_SESSION['uID'])
        {
            if($id_pracownika!=NULL) {
                echo '<td><input type="checkbox" name="'.$id.'" value="'.$id.'" checked></td>';
            } else echo '<td><input type="checkbox" name="'.$id.'" value="'.$id.'"></td>';
        } else echo '<td></td>';     
            echo'
            <td><input type="text" class="pracownik" name="'.$imie.'" disabled value="'.$imie.'"></td>
            <td><input type="text" class="pracownik" name="'.$nazwisko.'" disabled value="'.$nazwisko.'"></td>
            <td>'.$pesel.'</td>
            <td><input type="text" class="pracownik" name="'.$data_ur.'" disabled value="'.$data_ur.'"></td>
            <td>'.$nr_tel.'</td>
            <td>'.$data_zatr.'</td>
            <td>'.$stanowisko.'</td>
        </tr>
        </tbody>';
    }    
echo '</table>
</br><center><input type="submit" VALUE="Zatwierdź" NAME="customer-submit"></center>
</form>';
} else header('Location: index.php?action=home');
?>
