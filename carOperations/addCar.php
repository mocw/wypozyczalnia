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
    <p>Wybierz zdjęcie </br></br><input type="file" id="carImg" name="image" accept="image/png, image/jpeg"></p>
  <button name="add-car-submit" type="submit" id="contact-submit" data-submit="...Sending">Zatwierdź</button>
    </fieldset>
  </form>
</div>