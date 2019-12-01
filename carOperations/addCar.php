<script>
window.onload = toggleSelect(); // to disable select on load if needed

function toggleSelect(){
  var checkedValues = [];
  $("input:checkbox[class=messageCheckbox]:checked").each(function(){
    checkedValues.push($(this).val());
});

var chklength = checkedValues.length; 
checkedValues.forEach(function(entry) {
    if(document.getElementById("Diesel").checked==true){  //JESLI ZAZNACZONY DIESEL ODZNACZA BENZYNA
       document.getElementById("Benzyna").disabled = true;
       document.getElementById("Benzyna").checked = false;
    } else document.getElementById("Benzyna").disabled = false;

    if(document.getElementById("Benzyna").checked==true){ //JESLI PB TO ODZNACZA DIESLA
       document.getElementById("Diesel").disabled = true;
       document.getElementById("Diesel").checked = false;
    } else document.getElementById("Diesel").disabled = false;

    if(document.getElementById("Benzyna").checked==true){ //JESLI PB TO ODZNACZA DIESLA
       document.getElementById("Diesel").disabled = true;
       document.getElementById("Diesel").checked = false;
    } else document.getElementById("Diesel").disabled = false;

    if(document.getElementById("Skrzynia manualna").checked==true){ //JESLI MANUAL TO ODZNACZA AUTOMAT
       document.getElementById("Skrzynia automatyczna").disabled = true;
       document.getElementById("Skrzynia automatyczna").checked = false;
    } else document.getElementById("Skrzynia automatyczna").disabled = false;

    if(document.getElementById("Skrzynia automatyczna").checked==true){ //JESLI AUTOMAT TO ODZNACZA MANUAL
       document.getElementById("Skrzynia manualna").disabled = true;
       document.getElementById("Skrzynia manualna").checked = false;
    } else document.getElementById("Skrzynia manualna").disabled = false;
});
}
</script>

<?php
require 'includes/employeepanel.php';
require 'includes/dbh.inc.php';
if(isset($dodajZdj)) echo '<div class="alert alert-danger" role="alert">Dodaj zdjęcie!</div>';
if(isset($success)) echo '<div class="disappear"><div class="alert alert-success" role="alert">Pojazd został dodany!</div></div>';
?>
<div class="containerForm">  
  <form id="contact"  class="exceptModal" action="index.php?action=addCar" method="post" enctype="multipart/form-data">
    <fieldset>
      <input placeholder="Marka" name="marka" type="text" tabindex="1" required autofocus>
    </fieldset>
    <fieldset>
      <input placeholder="Model" name="model" type="text" tabindex="2" required>
    </fieldset>
    <fieldset>
      <input placeholder="Rok produkcji" name="rok_produkcji" name type="number" tabindex="3" required>
    </fieldset>
    <fieldset>
      <input placeholder="Pojemność silnika" name="poj_silnika" type="number" step="0.1" tabindex="4" required>
    </fieldset>
    <fieldset>
      <input placeholder="Cena za dobę" name="cena" type="number" step="0.01" tabindex="5" required>
    </fieldset>
    <fieldset>
    <p>Wybierz zdjęcie </br></br><input type="file" id="carImg" name="image" accept="image/*"></p>
    <?php
    $sql="SELECT nazwa,id FROM wyposazenie";
    $stmt=mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_execute($stmt);
    $wyposazenia=mysqli_stmt_get_result($stmt);
    mysqli_fetch_all($wyposazenia,MYSQLI_ASSOC);
    echo '<center><b>Wybierz wyposażenie:</b></center>';
    foreach ($wyposazenia as $row) {
    $nazwa=$row['nazwa'];
    $id=$row['id'];
    echo'<input type="checkbox" class="messageCheckbox" name="'.$id.'" id="'.$nazwa.'" value="'.$nazwa.'" 
    onclick="toggleSelect()">'.$nazwa.''.'</br>';
    }
    ?>
  </br></br><button name="add-car-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
    </fieldset>
  </form>
</div>