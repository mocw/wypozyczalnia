<?php
if(isset($_POST['customer-submit'])){
    $cnt=0;
    foreach($_POST as $key => $name){
        if($key=='customer-submit') break;
        $cnt++;
    }

    if($cnt==0){
        echo '<div class="alert alert-success" role="alert">Sukces!</div>';
        require 'dodajPracownika.php';
    }
    else {
    require 'includes/dbh.inc.php';
    $sql="UPDATE users SET id_pracownika=NULL WHERE NOT userID=? AND NOT uidUsers='root'";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
    echo '<div class="alert alert-danger" role="alert">Błąd SQL!</div>';
    require 'dodajPracownika.php';
    }
    else {
        mysqli_stmt_bind_param($stmt,"i",$_SESSION['uID']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);        
        echo '<form method="POST" action="???">
        <table class="table">
        <thead>
        <tr>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Data urodzenia</th>    
            <th>Data zatrudnienia</th>
            <th>Stanowisko</th>        
        </tr>
    </thead>';
        foreach($_POST as $key => $name){
        if($key=='customer-submit') break;
        $sql="SELECT imie,nazwisko,data_ur FROM users WHERE userID=?";
        $stmt=mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"i",$key);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $row=mysqli_fetch_row($result);
        $imie=$row[0];
        $nazwisko=$row[1];
        $data_ur=$row[2];
        echo '<tbody></tr>
        <td>'.$imie.'</td>
        <td>'.$nazwisko.'</td>
        <td>'.$data_ur.'</td>
        <td><input type="date" id="data_zatr" name="data_zatrudnienia"></td>
        <td>
        <select name="stanowisko">';
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
}
} else header('Location: index.php?action=home');
?>