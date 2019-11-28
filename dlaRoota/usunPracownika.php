<?php
if(isset($_SESSION['uID']) && $_SESSION['isRoot']==1){
require 'zarzadzaniekontem.php';
if(isset($_POST['customer-delete-submit'])){
    $cnt=0;
    foreach($_POST as $key => $name){
        if($key=='customer-delete-submit') break;
        $cnt++;
    }
    if($cnt==0){
        echo '<script language="javascript">alert("Nikogo nie zaznaczyłeś!")</script>';
    }
    else {
        require 'includes/dbh.inc.php';    
        foreach($_POST as $key => $name){
        if($key=='customer-delete-submit') break;
        $sql="SELECT id_pracownika FROM users WHERE userID=?";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"i",$key);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $row=mysqli_fetch_row($result);
        $id_pracownika=$row[0];
        $sql="UPDATE users
        SET id_pracownika=NULL
        WHERE userID=?";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"i",$key);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $sql="DELETE FROM pracownicy
        WHERE id='$id_pracownika'";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        }    
    echo '<div class="disappear"><div class="alert alert-success" role="alert">Sukces!</div></div>';
    }
}

require 'includes/dbh.inc.php';
    $sql="
    SELECT u.userID,u.uidUsers,u.imie,u.nazwisko,u.pesel,u.data_ur,u.nr_tel,IFNULL(u.id_pracownika,'') id_pracownika,IFNULL(p.data_zatr,'') data_zatr,IFNULL(s.nazwa,'') stanowisko 
    FROM users u 
    LEFT JOIN pracownicy p 
    ON u.id_pracownika=p.id 
    LEFT JOIN stanowiska s 
    oN p.id_stanowiska=s.id 
    WHERE NOT u.uidUsers='root' AND u.id_pracownika IS NOT NULL;
    ";
    $stmt=mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_execute($stmt);
    $users=mysqli_stmt_get_result($stmt);
    mysqli_fetch_all($users,MYSQLI_ASSOC);
    echo '
    <center><p>Z listy pracowników wybierz tych, których chcesz usunąć</p></center>
    <form method="POST" action="index.php?action=usunPracownika">
    <div class="tableContainer">
    <table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="th-sm">
            Usuń
            </th>
            <th class="th-sm">Imię</th>
            <th class="th-sm">Nazwisko</th>
            <th class="th-sm">Pesel</th>
            <th class="th-sm">Data urodzenia</th>
            <th class="th-sm">Numer telefonu</th>
            <th class="th-sm">Data zatrudnienia</th>
            <th class="th-sm">Stanowisko</th>
        </tr>
    </thead><tbody>';
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
        <tr>';
        if($row['userID']!=$_SESSION['uID'])
        {
           echo '<td><input type="checkbox" name="'.$id.'" value="'.$id.'"></td>';
        } else echo '<td></td>';     
            echo'
            <td><input type="text" class="pracownik" name="'.$imie.'" disabled value="'.$imie.'"></td>
            <td><input type="text" class="pracownik" name="'.$nazwisko.'" disabled value="'.$nazwisko.'"></td>
            <td>'.$pesel.'</td>
            <td><input type="text" class="pracownik" name="'.$data_ur.'" disabled value="'.$data_ur.'"></td>
            <td>'.$nr_tel.'</td>
            <td>'.$data_zatr.'</td>
            <td>'.$stanowisko.'</td>
        </tr>';
    }    
echo '
</tbody>
<tfoot>
<tr>
<th>
Usuń
</th>
<th>Imię</th>
<th>Nazwisko</th>
<th>Pesel</th>
<th>Data urodzenia</th>
<th>Numer telefonu</th>
<th>Data zatrudnienia</th>
<th>Stanowisko</th>
</tr>
</tfoot>
</table></div>
</br><center><input type="submit" VALUE="Zatwierdź" NAME="customer-delete-submit"></center>
</form>';

} else header('Location: index.php?action=home');
?>