<script>
window.onload = toggleSelect(); // to disable select on load if needed

function toggleSelect()
{
  var checkedValues = [];
  $("input:checkbox[class=messageCheckbox]:checked").each(function(){
    checkedValues.push($(this).val());
});

var chklength = checkedValues.length; 
checkedValues.forEach(function(entry) {
    if(document.getElementById("Diesel").checked==true){
       document.getElementById("Benzyna").disabled = true;
       document.getElementById("Benzyna").checked = false;
    } else document.getElementById("Benzyna").disabled = false;

    if(document.getElementById("Benzyna").checked==true){
       document.getElementById("Diesel").disabled = true;
       document.getElementById("Diesel").checked = false;
    } else document.getElementById("Diesel").disabled = false;
});
}
</script>

<?php
require 'includes/employeepanel.php';
require 'includes/dbh.inc.php';
if(isset($dodajZdj)) echo '<div class="alert alert-danger" role="alert">Dodaj zdjęcie!</div>';
if(isset($success)) echo '<div class="disappear"><div class="alert alert-success" role="alert">Pojazd został dodany!</div></div>';
?>
<div class="container">  
  <form id="contact" action="index.php?action=addCar" method="post" enctype="multipart/form-data">
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
      <input placeholder="Pojemność silnika" name="poj_silnika" type="number" tabindex="4" required>
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