<div id="facebook_slider_widget" style="display: none"><script type="text/javascript" src="http://webfrik.pl/widget/facebook_slider.html?fb_url=https://www.facebook.com/carthrottle/&amp;fb_width=290&amp;fb_height=590&amp;fb_faces=true&amp;fb_stream=true&amp;fb_header=true&amp;fb_border=true&amp;fb_theme=light&amp;chx=787&amp;speed=SLOW&amp;fb_pic=logo&amp;position=RIGHT"></script></div>
<?php
function wczytajFormularz(){
  require 'includes/dbh.inc.php';
      $code=$_GET['passwordCode'];
      $sql="SELECT code FROM passwordCodes WHERE code=?";
      $stmt=mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt,$sql);
      mysqli_stmt_bind_param($stmt,"s",$code);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck=mysqli_stmt_num_rows($stmt);
      if($resultCheck!=1)
      {
      echo '<div class="alert alert-danger" role="alert">Błąd!</div>';
      }
      else{
        $sql="SELECT userID FROM passwordCodes WHERE code='$code'";
        $query=mysqli_query($conn, $sql);
        $row=mysqli_fetch_row($query);
        $id=$row[0];
  
        echo
        '<center><form method="POST" action="./resetPassword.php?passwordCode='.$code.'">
        <label for="username">Podaj nowe hasło:</label>
        <input type="password" id="password" name="newPassword" required autofocus>
        <label for="username">Powtórz hasło:</label>
        <input type="password" id="password" name="newpassword_rpt" required autofocus>
        <input type="hidden" name="userID" value="'.$id.'">
        <div id="lower">
        </br><input type="submit" name="setNewPassowrd-submit" value="Zatwierdź"></center>
        </div>
        </form>
        ';
      }  
}
session_start();
if((isset($_SESSION['uID']))) header('Location: index.php?action=home'); 
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Wypożyczalnia</title>
<script type="text/javascript" src="scripts/scripts.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <link rel="stylesheet" type="text/css" href="css/style.css" />
 <link rel="stylesheet" type="text/css" href="css/slider.css" />
 <link rel="stylesheet" type="text/css" href="css/panel_log.css" />
 <link rel="stylesheet" type="text/css" href="css/offer.css" />
 <link rel="stylesheet" type="text/css" href="css/menu.css" />
 <link rel="stylesheet" type="text/css" href="css/formularz.css" />
 <link rel="stylesheet" type="text/css" href="css/alert.css" />
 <link rel="stylesheet" type="text/css" href="css/menuRoot.css" />
 <link rel="stylesheet" type="text/css" href="css/tabela.css" />
 <link rel="stylesheet" type="text/css" href="css/menu2.css" />
 <link rel="stylesheet" type="text/css" href="css/banner.css" />
 <link rel="stylesheet" type="text/css" href="css/kontakt.css">
 <link rel="stylesheet" type="text/css" href="css/carDetail.css">
 <link rel="stylesheet" type="text/css" href="css/pagination.css">
 <link rel="stylesheet" type="text/css" href="css/profile.css">
 <link rel="icon" type="image/ico" href="images/favicon.gif" >
</head>
<body>
  <div id="wrapper">
 
    <div id="header" onclick="openPage('index.php?action=home');">
    </div>   
    <div id="top">
    
    <div id="logo">
    <?php 
    if(isset($_SESSION['uID'])){
      echo '
      <center></br></br><b>'.$_SESSION['imie'].' '.$_SESSION['nazwisko'].'</center></b>
      ';
    if($_SESSION['id_klienta']!=NULL && $_SESSION['id_pracownika']==NULL) echo 'Klient</br>';
    if($_SESSION['isRoot']==1) echo '<b>Administrator</b></br>';
    if($_SESSION['id_pracownika']!=NULL) echo 'Pracownik na stanowisku: '.$_SESSION['stanowisko'].'';
    }
    ?>
    </div>
    <div id="menu">
        <ul>        
        <!-- <li><a href="index.php?action=home">Strona główna</a></li> -->
        <?php
        if(!isset($_SESSION['uID'])){
          echo
        '<li><a href="index.php?action=rejestracja">Zarejestruj się</a></li>
        <li><a href="index.php?action=logowanie">Zaloguj się</a></li>';
        } 
        else 
        {
        if($_SESSION['id_pracownika']!=NULL || $_SESSION['isRoot']==1) { 
          echo '<li><a href="index.php?action=employeepanel">Panel pracownika</a></li>';
        } 
        echo '<li><a class="logout" href="index.php?action=logout">Wyloguj się</a></li>';
        echo '<li><a href="index.php?action=accountmgm">Zarządzaj kontem</a></li>';
        }
        echo '<li><a href="index.php?action=oferta">Oferta</a></li>';
        ?>
        <li><a href="index.php?action=kontakt">Kontakt</a></li>
        <li><a href="index.php?action=filie">Filie</a></li>
        </ul>
    </div>
    </div>
    <div id="container"> <!-- BEGIN -->
    <?php
    if(isset($_POST['setNewPassowrd-submit'])){  //SET NEW PASSWORD
      $newpassword=$_POST['newPassword'];
      $newpassword_rpt=$_POST['newpassword_rpt'];
      $id=$_POST['userID'];
      require 'includes/dbh.inc.php';
  if(strcmp($newpassword,$newpassword_rpt))
   {
      echo '<div class="alert alert-danger" role="alert">Hasła nie są zgodne!</div>';
      wczytajFormularz();
   }
   else {      
      $sql="UPDATE users SET pwdUsers=? 
      WHERE userID=?";
      $stmt=mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt,$sql);
      $hashedPwd=password_hash($newpassword,PASSWORD_DEFAULT);
      mysqli_stmt_bind_param($stmt,"si",$hashedPwd,$id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
  
      $sql="DELETE FROM passwordcodes 
      WHERE userID=?";
      $stmt=mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt,$sql);
      mysqli_stmt_bind_param($stmt,"i",$id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      echo '<div class="alert alert-success" role="alert">Hało zostało zmienione!</div>';
      echo'
      <div class="slider" onclick="openPage(\'index.php?action=oferta\');">
    <div class="slide1"></div>
    <div class="slide2"></div>
    <div class="slide3"></div>
    <div class="slide4"></div>
    <div class="slide5"></div>
</div>
      ';
    }
   } else { //END SET NEW PASSWORD
      wczytajFormularz();
    }
    
    ?>
    </div>  <!-- END -->
    <div id="footer">
        <p>&copy 2019 Wszelkie prawa zastrzeżone. <br></p>
    </div>
    </div>
</body>
</html>
