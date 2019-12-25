function makeTimer() {
        var rows = document.getElementById("dtOrderExample").getElementsByTagName("tr").length;
        rows-=2;
        for(i=1;i<=rows;i++){
          var dataZw="datazwrotu"+i;
          var xd = document.getElementById (dataZw).innerText;
          var endTime = new Date(xd);			
        endTime = (Date.parse(endTime) / 1000);    
        var now = new Date();
        now = (Date.parse(now) / 1000);    
        var timeLeft = endTime - now;    
        var days = Math.floor(timeLeft / 86400); 
        var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
        var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
        var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));    
        if (hours < "10") { hours = "0" + hours; }
        if (minutes < "10") { minutes = "0" + minutes; }
        if (seconds < "10") { seconds = "0" + seconds; }        
          document.getElementById("timer"+i).innerHTML = "";
          if(days<=0){
            if(days==-1) document.getElementById("timer"+i).innerHTML +="<div class=\"blink\">ZWROT DZISIAJ</div>";	       
            else document.getElementById("timer"+i).innerHTML +="<div class=\"blink\">"+ days + "d " + hours + "h " + minutes + "m " + seconds + "s </div>";	       
          } 
          else {
            document.getElementById("timer"+i).innerHTML += days + "d " + hours + "h " + minutes + "m " + seconds + "s ";	       
          }
        } 
    }
    
    setInterval(function() { makeTimer(); }, 1000);