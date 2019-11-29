<link href="https://fonts.googleapis.com/css?family=Coda:800|Lato:300|Open+Sans" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
<script>

</script>

<div id="toClose">
<?php

function pokazInfoSamochod($id,$page,$niezalogowany){
  require 'includes/dbh.inc.php';
                $sql="SELECT * FROM pojazdy WHERE id=$id";
                $query = mysqli_query($conn, $sql);
                $row=mysqli_fetch_row($query);
                $marka=$row[1]; 
                $model=$row[2]; 
                $cena=$row[5];
                $zdjecie=$row[6];
                $imgContent=base64_encode(base64_decode($zdjecie));

                $sql="SELECT wyposazenie.id,wyposazenie.nazwa, wyposazenie.ikona 
                FROM wyposazenie
                JOIN samochody_wyposazenie ON  wyposazenie.id=samochody_wyposazenie.id_wyposazenia
                WHERE samochody_wyposazenie.id_samochodu=$id";
 
                $result = mysqli_query($conn, $sql);
                mysqli_fetch_all($result,MYSQLI_ASSOC);
                

                echo '
                <center>
<div class="caRcard">
  <form method="POST" action="index.php?action=oferta">
  <input type="hidden" name="page" value='.$page.'>
  <button class="green-arrow" type="submit">&#8592;</button>
  </form>
  <div class="item">
    <div class="text">
      <h1 class="car">'.$marka.'</h1>
      <h2 class="car">'.$model.'</h2>
      <span id="price1">'.$cena.' zł za dobę</span>
      <img class="car" src="data:image/png;base64,'.$imgContent.'"/>
    </div>
  </div>
  <div class="item">

    <p class="car"></p><p size="20px"><b>Wyposażenie:</b></p>
    <div class="stock">';
    foreach ($result as $row){
        $img=$row['ikona'];
        $imgContent=base64_encode($img);
        echo'
        <table class="carReserv">
        <tr>
        <td><img class="icon" src="data:image/png;base64,'.$imgContent.'"/></td>
        <td>'.$row['nazwa'].'</td>
        </tr>
        </table>
        ';
    }

    echo '</div></div><br>
    <div>
      

    <form method="POST" action="index.php?action=carreserv">
    <input type="hidden" name="carID" value="'.$id.'">
    <input type="hidden" name="page" value='.$page.'>
    <div><button id="cart" name="wniosek" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">ZAREZERWUJ</button></div>
    </form>
</div></center>                
                '; 
if($niezalogowany==1){
  echo '<script>
  document.getElementById("cart").disabled = true;
  document.getElementById("cart").style.cursor = "not-allowed";
</script>';
}                
}

if(isset($_POST['wniosek-submit'])){
  $SiedzibaOdbior=$_POST['siedzibaOdbior'];
  $SiedzibaZwrot=$_POST['siedzibaZwrot'];
  $dataodbioru=$_POST['data_odbioru'];
  $dataZwrotu=$_POST['data_zwrotu'];
  $idPojazdu=$_POST['carID'];
  $data_odbioru = date("Y-m-d", strtotime($dataodbioru));
  $data_zwrotu = date("Y-m-d", strtotime($dataZwrotu));
  // $month = date('m');
  // $day = date('d');
  // $year = date('Y');
  // $today = $year . '-' . $month . '-' . $day;
  // $dzis=date("Y-m-d", strtotime($today));
  $dzis = date('Y-m-d H:i:s');
  
  $sql="SELECT COUNT(ss.id_pojazdu)
  FROM samochody_siedziby ss 
  JOIN samochody s ON ss.id_pojazdu=s.id
  JOIN pojazdy p ON s.id_samochodu=p.id
  WHERE ss.id_siedziby='$SiedzibaOdbior' AND p.id='$idPojazdu'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_row($result);
  $userID=$_SESSION['uID'];

  // $sql="SELECT CONCAT(miejscowosc,' ul.',ulica, ' ',nr_posesji)  //SPRAWDZA ILE AUT JEST W DANEJ SIEDZIBIE
  // FROM siedziby
  // WHERE id='$SiedzibaOdbior'";
  // $result2 = mysqli_query($conn, $sql);
  // $row2 = mysqli_fetch_row($result2);

  $sql="INSERT INTO wnioski(id_miejsca_odbioru,id_miejsca_zwrotu,data_odbioru,data_zwrotu,id_samochodu,id_uzytkownika,data_zlozenia)
  VALUES(?,?,?,?,?,?,?)";
  $stmt=mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt,$sql);
  mysqli_stmt_bind_param($stmt,"iissiis",$SiedzibaOdbior,$SiedzibaZwrot,$data_odbioru,$data_zwrotu,$idPojazdu,$userID,$dzis);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);


echo '<div class="alert alert-success" role="alert">Wniosek został złożony! Obserwuj <a href="index.php?action=wnioskiKlienta">status</a></div>';
// echo 'Liczba dostępnych pojazdów: ';
// echo $row[0];
//echo ' w ';
//echo $row2[0];
require 'home.php';
}
else if(isset($_POST['wniosek'])){
    //WNIOSEK
$carID=$_POST['carID'];
$page=$_POST['page'];
if(!isset($niezalogowany)) $niezalogowany=0;
pokazInfoSamochod($carID,$page,$niezalogowany);
$sql="SELECT s.id,sm.id,sm.vin,CONCAT(miejscowosc,' ul.',ulica, ' ',nr_posesji) 
FROM siedziby s
JOIN samochody_siedziby ss ON ss.id_siedziby=s.id
JOIN samochody sm ON ss.id_pojazdu=sm.id
JOIN pojazdy p ON sm.id_samochodu=p.id
WHERE sm.id_samochodu='$carID' AND sm.czyDostepny=1
GROUP BY 4";
$result = mysqli_query($conn, $sql);
echo '
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <center><h5 class="modal-title" id="exampleModalLongTitle">Rezerwacja</h5></center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="komunikat"></div> 
<form action="index.php?action=carreserv" method="post">
<input type="hidden" name="page" value="'.$page.'">
<input type="hidden" name="carID" value="'.$carID.'">
</form>
    <div class="container"><form id="contact" name="rezerwacja" onsubmit="return validateFormReservation()" action="index.php?action=carreserv" method="post" enctype="multipart/form-data">
<center><p>Miejsce odbioru</center></p>    
<fieldset>
      <select class="egzemplarze" name="siedzibaOdbior" required autofocus>';
      while ($row = mysqli_fetch_row($result)) {
        $saEgzemplarze=1;
        echo '
        <option value="'.$row[0].'">'.$row[3].'</option>';
      }
      if(!isset($saEgzemplarze)){
       echo '<option>Brak egemplarzy w tej chwili!</option>';
      }      
    echo '</select>
    </fieldset>';
    $sql="SELECT id, CONCAT(miejscowosc,' ul.',ulica, ' ',nr_posesji)
    FROM siedziby";
    $result = mysqli_query($conn, $sql);
    echo '<fieldset>
    <center><p>Miejsce zwrotu</center></p>
    <select class="egzemplarze" name="siedzibaZwrot" required autofocus>';   
    while ($row = mysqli_fetch_row($result)) {
      echo '
      <option value="'.$row[0].'">'.$row[1].'</option>';
      
    }
    $month = date('m');
    $day = date('d');
    $year = date('Y');
    $today = $year . '-' . $month . '-' . $day;   
    echo '</select></fieldset>
    <fieldset><center><p>Data odbioru</center></p>
      <input placeholder="Data odbioru*" id="dataOdbioru"  value="'.$today.'" name="data_odbioru" type="date" tabindex="1" required autofocus>
    </fieldset>
    <fieldset><center><p>Data zwrotu</center></p>
    <input placeholder="Data zwrotu*" id="dataZwrotu"  value="'.$today.'" name="data_zwrotu" type="date" tabindex="1" required autofocus>
  </fieldset>
    <input type="hidden" name="carID" value="'.$carID.'">
    </br></br><button name="wniosek-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
    </form>
    </div></div>
  </div>
</div>
</div>
    '
    ;
    if(!isset($saEgzemplarze)){
      echo '<script>
      document.getElementById("contact-submit").disabled = true;
      document.getElementById("contact-submit").style.cursor = "not-allowed";
      </script>';
     } 

     echo '<script>
     $(\'#exampleModalCenter\').modal({
       show: true
   }); 
     </script>
     ';     
} else if(isset($_POST['carID'])) {  //INFO O AUCIE
  if(isset($_SESSION['uID']) && $isDataFilled==0)
  {             
        $niezalogowany=1;
  }
  else if(!isset($_SESSION['uID'])){
    echo '<div class="alert alert-warning" role="alert">Aby móc zarezerwować pojazd, 
  musisz być zalogowany! <a href="index.php?action=logowanie">Zaloguj się</a></li></div>';
  $niezalogowany=1;
  }
                $page=$_POST["page"];
                $page=$_POST['page'];
                $id=$_POST['carID'];
                if(!isset($niezalogowany)) $niezalogowany=0;
                pokazInfoSamochod($id,$page,$niezalogowany);
    }
    // else if(isset($_POST['closeModal'])) {
    //   $carID=$_POST['carID'];
    //   $page=$_POST['page'];
    //   pokazInfoSamochod($carID,$page);
    // } 
else header('Location: index.php?action=home');

?>
</div>
<script type="text/javascript" src="scripts/formValidation.js"></script>