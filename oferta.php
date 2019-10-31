<?php
require 'includes/dbh.inc.php';
if(!isset($_SESSION['uID'])) echo '<div class="alert alert-warning" role="alert">Aby móc zarezerwować pojazd, 
musisz być zalogowany! <a href="index.php?action=logowanie">Zaloguj się</a></li></div>';

$sql="SELECT * FROM pojazdy";
$stmt=mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt,$sql);
mysqli_stmt_execute($stmt);
$cars=mysqli_stmt_get_result($stmt);
mysqli_fetch_all($cars,MYSQLI_ASSOC);
echo '  <div class="box">
<div class="demo">
<form method="POST" action="index.php?action=carreserv">
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
        <img src="data:image/png;base64,'.$imgContent.'"/>
      </button>
    </center>
    </div>
  </li>
  ';
}
echo '</ul>
</form>
</div>
</div>';
?>