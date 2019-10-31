<?php
$site=(isset($_GET['action'])) ? $_GET['action'] : 'home';
session_start();
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Wypożyczalnia</title>
<script type="text/javascript" src="scripts/scripts.js"></script>
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
</head>
<body>
  <div id="wrapper">
 
    <div id="header" onclick="openPage('index.php?action=home');">
    </div>   
    <div id="top">
    
    <div id="logo">

    </div>
    <div id="menu">
        <ul>        
        <li><a href="index.php?action=home">Strona główna</a></li>
        <?php
        if(!isset($_SESSION['uID'])) echo
        '<li><a href="index.php?action=rejestracja">Zarejestruj się</a></li>
        <li><a href="index.php?action=logowanie">Zaloguj się</a></li>';
        else 
        {
        if($_SESSION['id_pracownika']!=NULL || $_SESSION['isRoot']==1) { 
          echo '<li><a href="index.php?action=employeepanel">Panel pracownika</a></li>';
        } 
        echo '<li><a class="logout" href="index.php?action=logout">Wyloguj się</a></li>';
        echo '<li><a href="index.php?action=accountmgm">Zarządzaj kontem</a></li>';
        }
        ?>
        <li><a href="index.php?action=kontakt">Kontakt</a></li>
        <li><a href="index.php?action=oferta">Oferta</a></li>
        </ul>
    </div>
    </div>
    <div id="container">
    <?php
    if(isset($_SESSION['uID'])) require 'includes/check_user_inc.php';
switch($site) {
  case 'home': include 'home.php'; break;
  case 'rejestracja': include 'rejestracja.php'; break;
  case 'logowanie': include 'logowanie.php'; break;
  case 'login' : include 'includes/login.inc.php'; break;
  case 'kontakt' : include 'kontakt.php'; break;
  case 'register' : include 'includes/register.inc.php'; break;
  case 'logout' : include 'includes/logout.inc.php'; break;
  case 'employeepanel' : include 'includes/employeepanel.php'; break;
  case 'oferta' : include 'oferta.php'; break;
  case 'accountmgm' : include 'zarzadzaniekontem.php'; break;
  case 'forgottenpassword' : include 'includes/forgottenpassword.php'; break;
  case 'remindpassword' : include 'includes/remindpassword.php'; break;
  case 'carreserv' : include 'rezerwacje/carreservation.php'; break;
  case 'addCarForm' : include 'carOperations/addCar.php'; break;
  case 'addCar' : include 'includes/add.car.inc.php'; break;
  case 'fillData' : include 'includes/fillData.php'; break;
  case 'fillData_send' : include 'includes/fillData.inc.php'; break;
  case 'panelAdmin' : include 'dlaRoota/panelAdmina.php'; break;
  case 'uprawnienia' : include 'dlaRoota/uprawnienia.php'; break;
  case 'setPermissions' : include 'dlaRoota/uprawnienia.inc.php'; break;
  case 'dodajPracownika' : include 'dlaRoota/dodajPracownika.php'; break;
  case 'dodajPracownika_inc' : include 'dlaRoota/dodajPracownika_inc.php'; break;
}
?>
    </div>
    <div id="footer">
        <p>&copy 2019 Wszelkie prawa zastrzeżone. <br></p>
    </div>
    </div>
</body>
</html>
