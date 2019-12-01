function showWyposazenie(id){    
        name='pokaz/chowaj'+id;
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