<link href="https://fonts.googleapis.com/css?family=Coda:800|Lato:300|Open+Sans" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
<script>
function myFunction() {
  //document.getElementById("toClose").style.display = "none";
}
</script>

<div id="toClose">
<?php
function showCars($page){
  require 'includes/dbh.inc.php';
  $results_per_page=6;
  $this_page_first_result=($page-1)*$results_per_page;
  
  $sql="SELECT * FROM pojazdy";
  $stmt=mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt,$sql);
  mysqli_stmt_execute($stmt);
  $cars=mysqli_stmt_get_result($stmt);
  $number_of_results=mysqli_num_rows($cars); 
  $number_of_pages=ceil($number_of_results/$results_per_page);
  
  $sql="SELECT * FROM pojazdy LIMIT ".$this_page_first_result.','.$results_per_page;
  $stmt=mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt,$sql);
  mysqli_stmt_execute($stmt);
  $cars=mysqli_stmt_get_result($stmt);
  mysqli_fetch_all($cars,MYSQLI_ASSOC);
  echo '  <div class="box">
  <div class="demo">
  <ul class="list">';
  foreach ($cars as $row) {
    $id=$row["id"];
    $marka=$row["marka"];
    $model=$row["model"];
    $poj_silnika=$row["poj_silnika"];
    $rok_produkcji=$row["rok_produkcji"];
    $img=$row["zdjecie"];
    $toBox=$marka."&#xa;".$model."&#xa;"."Silnik:".$poj_silnika."&#xa;"."$rok_produkcji";
    $imgContent=base64_encode(base64_decode($img));
  
    echo'
    <li class="list-item">
      <div class="list-content">
        <center>
          <button data-html="true" data-tooltip='.$toBox.' name="carID" class="offerbtn" value='.$id.'>
          <img class="offer" src="data:image/png;base64,'.$imgContent.'"/>
        </button>
      </center>
      </div>
    </li>
    ';
  }
  echo '</ul>';
}

function pokazInfoSamochod($id,$page){
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
      
    </div><br>
    <div id="quantity">
    </div><br>
    <form method="POST" action="index.php?action=carreserv">
    <input type="hidden" name="carID" value="'.$id.'">
    <input type="hidden" name="page" value='.$page.'>
    <div><button id="cart" onclick="myFunction()" name="wniosek">ZAREZERWUJ</button></div>
    </form>
  </div>
</div></center>                
                '; 
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
pokazInfoSamochod($carID,$page);
$sql="SELECT s.id,sm.id,sm.vin,CONCAT(miejscowosc,' ul.',ulica, ' ',nr_posesji) 
FROM siedziby s
JOIN samochody_siedziby ss ON ss.id_siedziby=s.id
JOIN samochody sm ON ss.id_pojazdu=sm.id
JOIN pojazdy p ON sm.id_samochodu=p.id
WHERE sm.id_samochodu='$carID' AND sm.czyDostepny=1
GROUP BY 4";
$result = mysqli_query($conn, $sql);
echo '<div class="modal" id="modal-one" aria-hidden="true">
<div class="modal-dialog">
<form action="index.php?action=carreserv" method="post">
<input type="hidden" name="page" value="'.$page.'">
<input type="hidden" name="carID" value="'.$carID.'">
<a href="" class="btn-close" aria-hidden="true">
<button  class="wniosek" type="submit" name="closeModal">
X
</button></a>
</form>
    <div class="modal-body"><div class="container"><form id="contact" action="index.php?action=carreserv" method="post" enctype="multipart/form-data">
<center><p>Miejsce odbioru</center></p>    
<fieldset>
      <select class="egzemplarze" name="siedzibaOdbior" required autofocus>';
      while ($row = mysqli_fetch_row($result)) {
        echo '
        <option value="'.$row[0].'">'.$row[3].'</option>';
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
      <input placeholder="Data odbioru*"  value="'.$today.'" name="data_odbioru" type="date" tabindex="1" required autofocus>
    </fieldset>
    <fieldset><center><p>Data zwrotu</center></p>
    <input placeholder="Data zwrotu*"  value="'.$today.'" name="data_zwrotu" type="date" tabindex="1" required autofocus>
  </fieldset>
    <input type="hidden" name="carID" value="'.$carID.'">
    </br></br><button name="wniosek-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
    </form>
    </div></div></div></div>
    '
    ;
} else if(isset($_POST['carID'])) {  //INFO O AUCIE
      $page=$_POST["page"];
    if(!isset($_SESSION['uID']))
    {
        $_SESSION['doZalogowania'] = 1;
        showCars($page);
        echo '
        <form method="POST" action="index.php?action=oferta">
         <input type="hidden" name="page" value='.$page.'>
        <div class="modal" id="modal-one" aria-hidden="true">
        <div class="modal-dialog">
        <a href="" class="btn-close" aria-hidden="true">
        <button type="submit" class="wniosek" >
        X
        </button></a></form>
        </br></br></br><div class="alert alert-danger" role="alert">Musisz się zalogować!</div>';
        require 'logowanie.php';   
        echo '</div></div>';
    }
        else
        {
            if($isDataFilled==0)
            {                
                echo '<p class="alert alert-danger">Musisz wypełnić dane!</p>';
                require 'oferta.php';  
            }
            else
            {
                $page=$_POST['page'];
                $id=$_POST['carID'];
                pokazInfoSamochod($id,$page);
            }

        }
    }
    else if(isset($_POST['closeModal'])) {
      $carID=$_POST['carID'];
      $page=$_POST['page'];
      pokazInfoSamochod($carID,$page);
    } 
else header('Location: index.php?action=home');

?>
</div>
