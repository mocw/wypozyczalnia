<?php
 include 'includes/dbh.inc.php';
 $sql="SELECT uidUsers,email,imie,nazwisko,data_ur,id_klienta,nr_tel
 FROM users
 WHERE userID='$id'";
 $result = mysqli_query($conn, $sql);
 $row = mysqli_fetch_row($result);
 echo '
 <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
 <div class="modal-content">
   <div class="modal-header">
   <h4>Pokaż profil</h4>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>
   <div class="modal-body">
     <div class="profile">
         <div class="info">
             <h2 id="info-title">Profil użytkownika '.$row[0].'</h2>
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
     </div></div</div></div></div></div>
 ';
 echo '<script>
 $(\'#exampleModalCenter\').modal({
   show: true
}); 
 </script>
 '; 


?>