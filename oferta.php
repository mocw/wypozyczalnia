
<link rel="stylesheet" type="text/css" href="css/grid.css"/>
<link rel="stylesheet" type="text/css" href="css/rollWyposazenie.css"/>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="scripts/grid.js"></script>

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
  echo ' 
  <form method="POST" action="index.php?action=oferta">
  <div class="container"></br>
  <div class="row">';
  $l=0;
  foreach ($cars as $row) {
    $l++;
    $id=$row["id"];
    $marka=$row["marka"];
    $model=$row["model"];
    $poj_silnika=$row["poj_silnika"];
    $rok_produkcji=$row["rok_produkcji"];
    $img=$row["zdjecie"];
    $cena=$row["Cena"];
    $toBox=$marka."&#xa;".$model."&#xa;";
    $imgContent=base64_encode(base64_decode($img));  
    echo'
    <div class="col-md-4"> 
    <figure class="card card-product">
      <div class="img-wrap">
        </br></br>
          <button data-html="true" data-tooltip='.$toBox.' name="carID" class="offerbtn" value='.$id.'>
          <img class="offer" src="data:image/png;base64,'.$imgContent.'"/>
          </button>
          </div>
		<figcaption class="info-wrap">
				<center><h4 class="title">'.$toBox.'</h4></center>
				<center>
          <ul>
            <li>'.$rok_produkcji.'</li>
           <li>'.$poj_silnika.'l. </li>
           <div class="roll'.$l.'" style="cursor:pointer; color: red;" onclick="showWyposazenie('.$l.')"><div id="pokaz/chowaj'.$l.'">Pokaż wyposażenie</div></div>
           ';
           $sql="SELECT wyposazenie.id,wyposazenie.nazwa, wyposazenie.ikona 
           FROM wyposazenie
           JOIN samochody_wyposazenie ON  wyposazenie.id=samochody_wyposazenie.id_wyposazenia
           WHERE samochody_wyposazenie.id_samochodu=$id";

           $result = mysqli_query($conn, $sql);
           mysqli_fetch_all($result,MYSQLI_ASSOC);

           echo '<table class="carReserv'.$l.'" style="display:none" >';
           foreach ($result as $row){
            $img=$row['ikona'];
            $imgContent=base64_encode($img);
            echo'
            <tr>
            <td><img class="icon" src="data:image/png;base64,'.$imgContent.'"/></td>
            <td>'.$row['nazwa'].'</td></tr>
            ';
        }

        echo '</table></center>
        <center>
        <div class="roll'.$l.'" style="cursor:pointer; color: green;" onclick="showDostepnosc('.$l.')"><div id="pokaz/chowajDostepnosc'.$l.'"><p class="blink" style="color: green; cursor: pointer;">Sprawdź dostępność</p></div></div>
        <table class="dostepnosc'.$l.'" style="display:none" >';
        $sql="SELECT CONCAT(miejscowosc,' ul. ',ulica,' nr. ', nr_posesji) as miejsce,vin,marka,model, \"wolny\"
        FROM samochody_siedziby ss 
        JOIN siedziby s ON ss.id_siedziby=s.id 
        JOIN samochody sm ON ss.id_pojazdu=sm.id 
        JOIN pojazdy p ON sm.id_samochodu=p.id 
        WHERE p.id=$id and czyDostepny=1
        GROUP BY 1
        UNION
        SELECT CONCAT(miejscowosc,' ',ulica,' nr. ', nr_posesji) as miejsce,vin,marka,model, data_zwrotu
        FROM wypozyczenia w
        JOIN samochody sm ON w.id_egzemplarza=sm.id
        JOIN wnioski wn ON w.id_wniosku=wn.id
        JOIN pojazdy p ON wn.id_samochodu=p.id
        JOIN siedziby s ON wn.id_miejsca_odbioru=s.id
        WHERE wn.id_samochodu='.$id.'";
        $result = mysqli_query($conn, $sql);
        mysqli_fetch_all($result,MYSQLI_ASSOC);
        foreach ($result as $row){
          echo' <tr>
          <td>'
          .$row['miejsce'].'          
          </td>
          </tr>';
        }
     echo'</table></center>
		</figcaption>
		<div class="bottom-wrap">
			<div class="price-wrap h5">
			<center>	<span class="price-new">'.$cena.' zł</span></center>
			</div> 
		</div> 
	</figure>
</div> 
    ';   
  }
  echo '
  <input type="hidden" name="page" value='.$page.'>
  </form>
  </div>
  </div>';
  echo '
  <div class="pagination">';
  echo '<center><form name="page" method="POST" action="index.php?action=oferta">';
  $currPage=$page;
  $previus=$currPage-1;
  if ($currPage!=1) echo'<button class="page gradient"  name="page" value="'.$previus.'">&laquo;</button>';
  for($page=1;$page<=$number_of_pages;$page++)
  {
    if($page==$currPage) echo'<input type="submit" name="page" class="page active" value="'.$page.'" disabled>';
    else echo'<input type="submit" class="page" name="page" value="'.$page.'">';
  }
  $next=$currPage+1;
  if ($currPage!=$number_of_pages) echo'<button class="page gradient"  name="page" value="'.$next.'">&raquo;</button>';
  echo '</div></form></center>';
}

if(!isset($_POST['page'])){
  $page=1;
} else {
$page=$_POST['page'];
}

if(isset($_POST['carID'])){
        echo '<form method="POST" id="reservForm" action="index.php?action=carreserv">
        <input type="hidden" name="carID" value="'.$_POST['carID'].'">
        <input type="hidden" name="page" value="'.$_POST['page'].'">
        </form>
        <script type="text/javascript">
        document.getElementById("reservForm").submit();
        </script>
        ';
} else {
  if(!isset($_SESSION['uID'])){
    echo '<div class="alert alert-warning" role="alert">Aby móc zarezerwować pojazd, 
  musisz być zalogowany! <a href="index.php?action=logowanie">Zaloguj się</a></li></div>';
  } 
  showCars($page);
}
?>