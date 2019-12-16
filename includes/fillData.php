<?php
if(isset($_SESSION['uID']) && $isDataFilled==0) {
      require 'zarzadzaniekontem.php';
    echo '
    <div id="komunikat"></div>
    <div class="containerForm">  
<form id="contact"  class="exceptModal" method="POST" onsubmit="return validateForm()" action="index.php?action=fillData_send" accept-charset="character_set">
<fieldset>
      <input placeholder="Numer dowodu osobistego*" name="nr_dowodu" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Numer karty kredytowej*" name="nr_karty" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Ulica*" name="ulica" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Miejscowość*" name="miejscowosc" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Kod pocztowy*" name="kod_pocztowy" pattern="^[0-9]{2}-[0-9]{3}$" type="text" tabindex="1" required autofocus>
</fieldset>
<fieldset>
      <input placeholder="Numer mieszkania" name="numer_mieszkania" type="number" tabindex="1">
</fieldset>
<fieldset>
      <input placeholder="Numer domu*" name="numer_domu" type="number" tabindex="1" required autofocus>
</fieldset>
<p style="color:red">* - pola obowiązkowe</p>
<fieldset>
      <button name="fillData-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
</fieldset>
</div>
</form>
    ';
} else header('Location: index.php?action=home');

?>
<script type="text/javascript" src="scripts/fillDataValidation.js"></script>