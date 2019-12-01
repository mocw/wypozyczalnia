function showWyposazenie(id){    
       var name='pokaz/chowaj'+id;
        if(document.getElementById(name).innerHTML==="Zwiń"){
            document.getElementById(name).innerHTML="Pokaż wyposażenie";
            name='.carReserv'+id;
            $(name).css('display','none');
        } else {
             document.getElementById(name).innerHTML="Zwiń";
            name='.carReserv'+id;
            $(name).css('display','block');
        }
       
    }

    function showDostepnosc(id){
        var name='pokaz/chowajDostepnosc'+id;
        if(document.getElementById(name).innerHTML==="<p class=\"blink\" style=\"color: green; cursor: pointer;\">Zwiń</p>"){
            document.getElementById(name).innerHTML="<p class=\"blink\" style=\"color: green; cursor: pointer;\">Sprawdź dostępność</p>";
            name='.dostepnosc'+id;
            $(name).css('display','none');
        } else {
             document.getElementById(name).innerHTML="<p class=\"blink\" style=\"color: green; cursor: pointer;\">Zwiń</p>";
            name='.dostepnosc'+id;
            $(name).css('display','block');
        }        
    }