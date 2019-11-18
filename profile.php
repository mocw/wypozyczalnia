<div id="facebook_slider_widget" style="display: none"><script type="text/javascript" src="http://webfrik.pl/widget/facebook_slider.html?fb_url=https://www.facebook.com/carthrottle/&amp;fb_width=290&amp;fb_height=590&amp;fb_faces=true&amp;fb_stream=true&amp;fb_header=true&amp;fb_border=true&amp;fb_theme=light&amp;chx=787&amp;speed=SLOW&amp;fb_pic=logo&amp;position=RIGHT"></script></div>
<?php
session_start();
if(!(isset($_SESSION['uID']))) header('Location: index.php?action=home'); 
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
    <div id="container">
    <?php
    $id = $_GET["id"];
    include 'includes/dbh.inc.php';
    $sql="SELECT uidUsers,email,imie,nazwisko,data_ur,id_klienta,nr_tel
    FROM users
    WHERE userID='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    echo '
        <div class="profile">
            <div class="info">
                <h2 id="info-title">'.$row[0].'</h2>
                <div class="fact">
                    <div class="title">Imie</div>
                    <div class="value">'.$row[2].'</div>
                </div>
                <div class="fact">
                    <div class="title">Nazwisko</div>
                    <div class="value">'.$row[3].'</div>
                </div>
                <div class="fact">
                    <div class="title">Adres e-mail</div>
                    <div class="value">'.$row[1].'</div>
                </div>
                <div class="fact">
                    <div class="title">Data urodzenia</div>
                    <div class="value">'.$row[4].'</div></div>';
                    if($row[5]!=0 && ($_SESSION['id_pracownika']!=NULL || $_SESSION['isRoot']==1)){
                        echo '
                        <div class="fact">
                        <div class="title">Numer telefonu</div>
                         <div class="value">'.$row[6].'</div></div>
                        ';

                        $sql="SELECT nr_dowodu,nr_karty_kredytowej,CONCAT(miejscowosc,' ul.',ulica,' ',nr_domu,
                        CONCAT(' mieszkania nr. ',CASE WHEN nr_mieszkania IS NOT NULL
                                         THEN nr_mieszkania 
                                         ELSE ' brak '
                                         END)
                     )
                     FROM klienci
                     WHERE id='$row[5]'";
                    }
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_row($result);
                    echo '
                    <div class="fact">
                    <div class="title">Numer dowodu osobistego</div>
                    <div class="value">'.$row[0].'</div></div>
                    <div class="fact">
                        <div class="title">Numer karty kredytowej</div>
                         <div class="value">'.$row[1].'</div></div>
                         <div class="fact">
                        <div class="title">Adres</div>
                         <div class="value">'.$row[2].'</div></div>
                    ';
                echo '</div>
            </div>
        </div>
    ';
?>
    </div>
    <div id="footer">
        <p>&copy 2019 Wszelkie prawa zastrzeżone. <br></p>
    </div>
    </div>
</body>
</html>
