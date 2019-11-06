<center><form class="kontakt" method="POST" action="index.php?action=kontakt.inc">
<label for="name" class="kontakt">Imię i nazwisko/ Nazwa Firmy</label>
<input type="text" name="name" class="kontakt" id="name" placeholder="Jan Kowalski/ Nazwa Firmy" required>

<label for="email">Email</label>
<input type="email" name="email" class="kontakt" id="email" placeholder="example@example.com" required>

<label for="temat">Temat</label>
<select id="subject" name="temat" class="form-group form-control">
						<option value="" selected disabled>Wybierz temat</option>
						<option>Wynajem długoterminowy</option>
						<option>Wynajem kilku pojazdów</option>
						<option>Problem z płatnościami</option>
						<option>Inny temat</option>
					   </select>

<label for="message">Wiadomość</label>
<textarea name="message" id="message" placeholder="Wpisz swoją wiadomość" required></textarea>

<label for="captcha">Przepisz kod captcha</label>
<img src="includes/captcha.php" alt="Captcha" id="zdjecie">
<input type="text" name="captcha" id="captcha" required>

<input type="submit" name="kontakt-submit" value="Wyślij">
</form></center>