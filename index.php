<?php
$site=(isset($_GET['action'])) ? $_GET['action'] : 'home';
session_start();
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Wypożyczalnia</title>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>
<script type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="scripts/table.js"></script>
<script type="text/javascript" src="scripts/loadLanguage.js"></script>
 <link rel="stylesheet" type="text/css" href="css/style.css" />
 <link rel="stylesheet" type="text/css" href="css/slider.css" />
 <link rel="stylesheet" type="text/css" href="css/loginBar.css" />
 <link rel="stylesheet" type="text/css" href="css/panel_log.css" />
 <link rel="stylesheet" type="text/css" href="css/offer.css" />
 <link rel="stylesheet" type="text/css" href="css/menu.css" />
 <link rel="stylesheet" type="text/css" href="css/formularz.css" />
 <link rel="stylesheet" type="text/css" href="css/alert.css" />
 <link rel="stylesheet" type="text/css" href="css/menuRoot.css" />
 <!-- <link rel="stylesheet" type="text/css" href="css/tabela.css" /> -->
 <link rel="stylesheet" type="text/css" href="css/menu2.css" />
 <link rel="stylesheet" type="text/css" href="css/banner.css" />
 <link rel="stylesheet" type="text/css" href="css/kontakt.css">
 <link rel="stylesheet" type="text/css" href="css/carDetail.css">
 <link rel="stylesheet" type="text/css" href="css/pagination.css">
 <link rel="stylesheet" type="text/css" href="css/profile.css">
 <link rel="stylesheet" type="text/css" href="css/modalpopup.css">
 <link rel="stylesheet" type="text/css" href="css/login.css">
 <link rel="stylesheet" type="text/css" href="css/sortedTable.css">
 <link rel="stylesheet" type="text/css" href="css/modalError.css">
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
    //   echo '
    //   <center></br><b>'.$_SESSION['imie'].' '.$_SESSION['nazwisko'].'</center></b>
    //   ';
    // if($_SESSION['id_klienta']!=NULL && $_SESSION['id_pracownika']==NULL) echo 'Klient</br>';
    // if($_SESSION['isRoot']==1) echo '<b>Administrator</b></br>';
    // if($_SESSION['id_pracownika']!=NULL) echo 'Pracownik na stanowisku: '.$_SESSION['stanowisko'].'';
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
        <li>  <a id="dropdownMenu1" data-toggle="dropdown" class=" dropdown-toggle">Zaloguj się</a>
                    <ul class="dropdown-menu dropdown-menu-right mt-2">
                       <li class="px-3 py-2">
                           <form class="form" role="form" method="POST" action="index.php?action=login" id="logowanie">
                                <div class="form-group">
                                    <input id="userInput" placeholder="Nazwa użytkownika" class="form-control form-control-sm" type="text" required autofocus name="username">
                                </div>
                                <div class="form-group">
                                    <input id="passwordInput" placeholder="Hasło" class="form-control form-control-sm" type="password" required autofocus name="password">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-dark" name="login-submit">Zaloguj się</button>
                                </div>
                                <div class="form-group text-center">
                                <small><center><a href="index.php?action=forgottenpassword">Zapomniałeś hasła?</a></small>
                                </div>
                            </form>
                        </li>
                    </ul></li>';
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
    <div id="container">
    
    <?php
    if(isset($_SESSION['uID'])) require 'includes/check_user_inc.php';
switch($site) {
  case 'home': include 'home.php'; break;
  case 'rejestracja': include 'rejestracja.php'; break;
  case 'logowanie': include 'logowanie.php'; break;
  case 'login' : include 'includes/login.inc.php'; break;
  case 'kontakt' : include 'kontakt.php'; break;
  case 'kontakt.inc' : include 'includes/kontakt.inc.php'; break;
  case 'register' : include 'includes/register.inc.php'; break;
  case 'logout' : include 'includes/logout.inc.php'; break;
  case 'employeepanel' : include 'includes/employeepanel.php'; break;
  case 'oferta' : include 'oferta.php'; break;
  case 'accountmgm' : include 'zarzadzaniekontem.php'; break;
  case 'editData' : include 'includes/edytujDane.php'; break;
  case 'forgottenpassword' : include 'includes/forgottenpassword.php'; break;
  case 'changePassword' : include 'includes/changePassword.php'; break;
  case 'carreserv' : include 'rezerwacje/carreservation.php'; break;
  case 'addCarForm' : include 'carOperations/addCar.php'; break;
  case 'addCar' : include 'includes/add.car.inc.php'; break;
  case 'fillData' : include 'includes/fillData.php'; break;
  case 'fillData_send' : include 'includes/fillData.inc.php'; break;
  case 'panelAdmin' : include 'dlaRoota/panelAdmina.php'; break;
  case 'uprawnienia' : include 'dlaRoota/uprawnienia.php'; break;
  case 'dodajPracownika' : include 'dlaRoota/dodajPracownika.php'; break;
  case 'usunPracownika' : include 'dlaRoota/usunPracownika.php'; break;
  case 'dodajEgzemplarz' : include 'carOperations/dodajEgzemplarz.php'; break;
  case 'flota' : include 'carOperations/flota.php'; break;
  case 'wnioskiKlienta' : include 'rezerwacje/wnioskiKlienta.php'; break;
  case 'wnioskiDlaObslugi' : include 'rezerwacje/wnioskiDlaObslugi.php'; break;
  case 'wypozyczeniaDlaObslugi' : include 'rezerwacje/wypozyczeniaDlaObslugi.php'; break;
  case 'wypozyczeniaKlienta' : include 'rezerwacje/wypozyczeniaKlienta.php'; break;
  case 'filie' : include 'filie.php'; break;
  default:
  echo '<div class="alert alert-danger" role="alert">Nieporawny link!</div>';
  break;
}

?>
    </div>
    <div id="footer">
        <p>&copy 2019 Wszelkie prawa zastrzeżone. <br></p>
    </div>
    </div>
    <div id="facebook_slider_widget" style="display: none"><script type="text/javascript" src="http://webfrik.pl/widget/facebook_slider.html?fb_url=https://www.facebook.com/carthrottle/&amp;fb_width=290&amp;fb_height=590&amp;fb_faces=true&amp;fb_stream=true&amp;fb_header=true&amp;fb_border=false&amp;fb_theme=undefined&amp;chx=787&amp;speed=FAST&amp;fb_pic=sign&amp;position=TOP"></script></div></body>
</html>
