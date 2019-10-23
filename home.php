<?php
if(!isset($_SESSION['uID'])) echo '<center>Jesteś wylogowany! </center>';
else 
{
    echo '<center>Jesteś zalogowany! Witaj ',$_SESSION['imie']," ",$_SESSION['nazwisko'],'</center>';
    if($_SESSION['czyPracownik']==1) echo '<center></br>Pracownik!</center>';   
}
?>
<article id="slider">
    <input class="slider" type="radio" name="slider" id="slide1" checked />
    <input class="slider"  type="radio" name="slider" id="slide2" />
    <input class="slider"  type="radio" name="slider" id="slide3" />
    <input class="slider" type="radio" name="slider" id="slide4" />
    <input class="slider" type="radio" name="slider" id="slide5" />
    <div id="slides">
        <div id="overflow">
            <div class="inner">
                <article>
                    <img src="http://lorempixel.com/600/400/food" />
                </article>
                <article>
                    <img src="http://lorempixel.com/600/400/" />
                </article>
                <article>
                    <img src="http://lorempixel.com/600/400/sports" />
                </article>
                <article> 
                    <img src="http://lorempixel.com/600/400/cats" />
                </article>
                <article>
                    <img src="http://lorempixel.com/600/400/fashion" />
                </article>
            </div>
        </div>
    </div>
    
    <div id="active">
        <label class="slider" for="slide1"></label>
        <label class="slider" for="slide2"></label>
        <label class="slider" for="slide3"></label>
        <label class="slider" for="slide4"></label>
        <label class="slider" for="slide5"></label>
    </div>
</article>