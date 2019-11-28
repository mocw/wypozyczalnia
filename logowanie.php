<?php
if(!isset($_SESSION['uID'])){
    echo
 '<div class="logwrapper">
<form class="form-signin" method="POST" action="index.php?action=login" id="logowanie">       
<h2 class="form-signin-heading">Zaloguj się</h2>
<input type="text" class="form-control" name="username" placeholder="Nazwa użytkownika" required="" autofocus="" />
<input type="password" class="form-control" name="password" placeholder="Hasło" required=""/>      
<div id="lower">
<center></br><p><a href="index.php?action=forgottenpassword">Zapomniałeś hasła?</a></p>
<p>Nie masz konta? <a href="index.php?action=rejestracja">Zarejestruj się!</a></p></center>
</div>
<button name="login-submit" class="btn btn-lg btn-primary btn-block" type="submit">Login</button>   
</form>
</div>';
} 
else  header('Location: index.php?action=home');
?>