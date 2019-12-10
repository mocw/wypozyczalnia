
<div class='slider' onclick="openPage('index.php?action=oferta');">
  <div class='slide1'></div>
  <div class='slide2'></div>
  <div class='slide3'></div>
  <div class='slide4'></div>
  <div class='slide5'></div>
</div>
<div id="loginResult">
<?php
if(isset($_SESSION['uID'])){
  echo 'Zalogowany!';
}
?>
</div>
