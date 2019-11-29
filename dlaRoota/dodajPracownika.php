<?php
function loadTable(){
    require 'includes/dbh.inc.php';
    $sql="
    SELECT u.userID,u.uidUsers,u.imie,u.nazwisko,u.pesel,u.data_ur,u.nr_tel,IFNULL(u.id_pracownika,'') id_pracownika,IFNULL(p.data_zatr,'') data_zatr,IFNULL(s.nazwa,'') stanowisko 
    FROM users u 
    LEFT JOIN pracownicy p 
    ON u.id_pracownika=p.id 
    LEFT JOIN stanowiska s 
    oN p.id_stanowiska=s.id 
    WHERE NOT u.uidUsers='root' AND u.id_pracownika IS NULL;
    ";
    $stmt=mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_execute($stmt);
    $users=mysqli_stmt_get_result($stmt);
    mysqli_fetch_all($users,MYSQLI_ASSOC);
    echo '
    <center><p>Z listy użytkowników wybierz tych, których chcesz dodać</p></center>
    <form method="POST" action="index.php?action=dodajPracownika">
    <div class="tableContainer">
    <table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead class="table-dark">
        <tr>
            <th class="th-sm">
            Dodaj
            </th>
            <th class="th-sm">Imię</th>
            <th class="th-sm">Nazwisko</th>
            <th class="th-sm">Pesel</th>
            <th class="th-sm">Data urodzenia</th>
            <th class="th-sm">Numer telefonu</th>
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
            if($id_pracownika!=NULL) {
                echo '<td><input type="checkbox" name="'.$id.'" value="'.$id.'"></td>';
            } else echo '<td><input type="checkbox" name="'.$id.'" value="'.$id.'"></td>';
        } else echo '<td></td>';     
            echo'
            <td><input type="hidden" class="pracownik" disabled name="'.$imie.'" value="'.$imie.'">'.$imie.'</td>
            <td><input type="hidden" class="pracownik" disabled name="'.$nazwisko.'" value="'.$nazwisko.'">'.$nazwisko.'</td>
            <td>'.$pesel.'</td>
            <td><input type="hidden" class="pracownik" disabled name="'.$data_ur.'" value="'.$data_ur.'">'.$data_ur.'</td>
            <td>'.$nr_tel.'</td>
        </tr>
        ';
    }    
echo '</tbody>
<tfoot class="table-dark">
<tr>
<th>
            Dodaj
            </th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Pesel</th>
            <th>Data urodzenia</th>
            <th>Numer telefonu</th>
        </tr>
        </tfoot>
        </table>
</div>
</br><center><input type="submit" class="btn btn-dark" VALUE="Zatwierdź" NAME="customer-submit"></center>
</form>';
}

if(isset($_SESSION['uID']) && $_SESSION['isRoot']==1) {
require 'zarzadzaniekontem.php';
if(isset($_POST['customer-submit-data'])){
    require 'includes/dbh.inc.php';
    $i=0;

    foreach($_POST['names'] as $item){
        $names[$i]=$item;
        $i++;
    }
    
    $i=0;
    foreach($_POST['daty_zatrudnienia'] as $item){
        $daty_zatr[$i]=$item;
        $i++;
    }

    $i=0;
    foreach($_POST['stanowiska'] as $item){
        $stanowiska[$i]=$item;
        $i++;
    }

    for($l=0;$l<$i;$l++){
       $stanowisko=trim($stanowiska[$l]);
        $sql="SELECT id FROM stanowiska WHERE nazwa='$stanowisko'";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_execute($stmt);
        $id=mysqli_stmt_get_result($stmt);
        $row=mysqli_fetch_row($id);
        $id=$row[0];
        $sql="INSERT INTO pracownicy(data_zatr,id_stanowiska) VALUES(?,?)";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"si",$daty_zatr[$l],$id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $last_id = mysqli_insert_id($conn);
        $sql="UPDATE users SET id_pracownika='$last_id' WHERE uidUsers='$names[$l]'";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt); 
    }

    echo '<div class="disappear"><div class="alert alert-success" role="alert">Sukces!</div></div>';

}
if(isset($_POST['customer-submit'])||isset($fillError)){
    $month = date('m');
    $day = date('d');
    $year = date('Y');
    $today = $year . '-' . $month . '-' . $day;
    $cnt=0;
    foreach($_POST as $key => $name){
        if($key=='customer-submit') break;
        if($key=='dtOrderExample_length') continue;
        $cnt++;
    }

    if($cnt==0){
            echo '<div class="alert alert-danger" role="alert">Nikogo nie zaznaczyłeś!</div>';
            loadTable();
    }
    else {
    require 'includes/dbh.inc.php';     
        echo '
        <center><p>Uzypełnij dane</p></center>
        <form id="dodajPrac" method="POST" action="index.php?action=dodajPracownika">
        <div class="tableContainer">
        <table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
          <thead class="table-dark">
          <tr>
            <th class="th-sm">Nazwa użytkownika</th>
            <th class="th-sm">Imię</th>
            <th class="th-sm">Nazwisko</th>
            <th class="th-sm">Data urodzenia</th>    
            <th class="th-sm">Data zatrudnienia</th>
            <th class="th-sm">Stanowisko</th>        
        </tr>
    </thead><tbody>';
        foreach($_POST as $key => $name){
        if($key=='customer-submit') break;
        if($key=='dtOrderExample_length') continue;
        $sql="SELECT uidUsers,imie,nazwisko,data_ur FROM users WHERE userID=?";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"i",$key);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $row=mysqli_fetch_row($result);
        $nick=$row[0];
        $imie=$row[1];
        $nazwisko=$row[2];
        $data_ur=$row[3];
        echo '</tr>
        <td><input type="hidden" class="pracownik" name="names[]" value="'.$nick.'" readonly>'.$nick.'</td>
        <td>'.$imie.'</td>
        <td>'.$nazwisko.'</td>
        <td>'.$data_ur.'</td>
        <td><input type="date" id="data_zatr" name="daty_zatrudnienia[]" value="'.$today.'"></td>
        <td>
        <select name="stanowiska[]">';
        $sql="SELECT nazwa FROM stanowiska";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"i",$key);
        mysqli_stmt_execute($stmt);
        $stanowiska=mysqli_stmt_get_result($stmt);
        mysqli_fetch_all($stanowiska,MYSQLI_ASSOC);
        foreach ($stanowiska as $row) {
        $nazwa=$row['nazwa'];
        echo'<option value="'.$nazwa.'">'.$nazwa.'</option>';
        }
        echo'    
        </select>
        </td>
        </tr>';
    }
    echo'
    </tbody>
    <tfoot class="table-dark">
    <tr>
    <th>Nazwa użytkownika</th>
    <th>Imię</th>
    <th>Nazwisko</th>
    <th>Data urodzenia</th>    
    <th>Data zatrudnienia</th>
    <th>Stanowisko</th>        
</tr></tfoot>
    </table></div>
    </br><center><input type="submit" class="btn btn-dark" VALUE="Zatwierdź" NAME="customer-submit-data"></center>
    </form>';
}
} else {
    loadTable();
    }
} else header('Location: index.php?action=home');
?>
