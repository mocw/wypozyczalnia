<?php
$month = date('m');
$day = date('d');
$year = date('Y');
$today = $year . '-' . $month . '-' . $day;
if(isset($_POST['customer-submit'])||isset($fillError)){
    $cnt=0;
    foreach($_POST as $key => $name){
        if($key=='customer-submit') break;
        $cnt++;
    }

    if($cnt==0){
        echo '<div class="alert alert-danger" role="alert">Nikogo nie zaznaczyłeś!</div>';
        require 'dodajPracownika.php';
    }
    else {
    require 'zarzadzaniekontem.php';
    require 'includes/dbh.inc.php';     
        echo '<form id="dodajPrac" method="POST" action="index.php?action=dodajPracownika_inc_cd">
        <table class="table">
        <thead>
        <tr>
            <th>Nazwa użytkownika</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Data urodzenia</th>    
            <th>Data zatrudnienia</th>
            <th>Stanowisko</th>        
        </tr>
    </thead>';
        foreach($_POST as $key => $name){
        if($key=='customer-submit') break;
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
        echo '<tbody></tr>
        <td><input type="text" class="pracownik" name="names[]" value="'.$nick.'" readonly></td>
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
        </tr>
        </tbody>';
    }
    echo'
    </table>
    </br><center><input type="submit" VALUE="Zatwierdź" NAME="customer-submit-data"></center>
    </form>';
}
} else header('Location: index.php?action=home');
?>