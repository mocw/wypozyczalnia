<?php
require 'includes/dbh.inc.php';
if(!isset($_SESSION['uID'])) echo '<div class="alert alert-warning" role="alert">Aby móc zarezerwować pojazd, 
musisz być zalogowany! <a href="index.php?action=logowanie">Zaloguj się</a></li></div>';

if(!isset($_POST['page'])){
  $page=1;
} else {
$page=$_POST['page'];
}
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
        <img class="offer" src="data:image/png;base64,'.$imgContent.'"/>
      </button>
    </center>
    </div>
  </li>
  ';
}
echo '</ul>
<input type="hidden" name="page" value='.$page.'>
</form>
</div>
</div>';
echo '
<div id="pcontainer">
<div class="pagination">';
echo '<center><form name="page" method="POST" action="index.php?action=oferta">';
$currPage=$page;
$previus=$currPage-1;
if ($currPage!=1) echo'<button class="prevnext" name="page" value="'.$previus.'">&laquo;</button>';
for($page=1;$page<=$number_of_pages;$page++)
{
  if($page==$currPage) echo'<input type="submit" name="page" class="active" value="'.$page.'" disabled>';
  else echo'<input type="submit" name="page" value="'.$page.'">';
}
$next=$currPage+1;
if ($currPage!=$number_of_pages) echo'<button class="prevnext" name="page" value="'.$next.'">&raquo;</button>';
echo '</div></div></form></center>';
?>