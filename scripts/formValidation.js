
  
function validateForm() { //REJESTRACJA
    document.getElementById("komunikat").innerHTML = "";
    document.getElementById("nr_tel").style.outline="none";
    document.getElementById("pesel").style.outline="none";
    document.getElementById("dataur").style.outline="none";
    document.getElementById("email").style.outline="none";
    document.getElementById("password").style.outline="none";
    document.getElementById("password_rpt").style.outline="none";
    document.getElementById("nr_tel").style.backgroundColor="white";
    document.getElementById("pesel").style.backgroundColor="white";
    document.getElementById("dataur").style.backgroundColor="white";
    document.getElementById("email").style.backgroundColor="white";
    document.getElementById("password").style.backgroundColor="white";
    document.getElementById("password_rpt").style.backgroundColor="white";

    var isCorrect=true;

    var input = document.getElementById("dataur").value;
    var dateEntered = new Date(input);
    var today = new Date();

  // var email = document.getElementById("email").value;
  var password = document.forms["register"]["password"].value;
  var password_rpt = document.forms["register"]["password_rpt"].value;
   if(password!=password_rpt){
       document.getElementById("komunikat").innerHTML += "<div class=\"error-notice\"><div class=\"oaerror danger\">Hasła nie są zgodne!</div></div>";
       document.getElementById("password").style.backgroundColor="rgba(248, 215, 218, 1)";
       document.getElementById("password").style.outline="2px solid red";
       document.getElementById("password_rpt").style.backgroundColor="rgba(248, 215, 218, 1)";
       document.getElementById("password_rpt").style.outline="2px solid red";
       isCorrect=false;
   }

   var pesel = document.forms["register"]["pesel"].value;
   if(!isValidPesel(pesel)){
       document.getElementById("komunikat").innerHTML += "<div class=\"error-notice\"><div class=\"oaerror danger\">Nieprawidłowy PESEL!</div></div></div>";
       document.getElementById("pesel").style.backgroundColor="rgba(248, 215, 218, 1)";
       document.getElementById("pesel").style.outline="2px solid red";
       isCorrect=false;
   }

   var nr_tel = document.forms["register"]["nr_tel"].value;
    if(nr_tel.length!=9 || isNaN(nr_tel)){
        document.getElementById("komunikat").innerHTML += "<div class=\"error-notice\"><div class=\"oaerror danger\">Nieprawidłowy numer telefonu!</div></div>";
        document.getElementById("nr_tel").style.backgroundColor="rgba(248, 215, 218, 1)";
        document.getElementById("nr_tel").style.outline="2px solid red";
        isCorrect=false;
    }

    if(dateEntered > today){
        document.getElementById("komunikat").innerHTML += "<div class=\"error-notice\"><div class=\"oaerror danger\">Nieprawidłowa data urodzenia!</div></div>";
        document.getElementById("dataur").style.backgroundColor="rgba(248, 215, 218, 1)";
        document.getElementById("dataur").style.outline="2px solid red";
        isCorrect=false;
    }

        if(isCorrect){
            return true;
        } 
        else {
            $("html, body").animate({scrollTop: 0}, 400);
            return false;
        }


  }

  function isValidPesel(pesel) {
    let weight = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
    let sum = 0;
    let controlNumber = parseInt(pesel.substring(10, 11));
    for (let i = 0; i < weight.length; i++) {
        sum += (parseInt(pesel.substring(i, i + 1)) * weight[i]);
    }
    sum = sum % 10;
    return 10 - sum === controlNumber;
}

function calculateYears(dateold, datenew){
    var ynew = datenew.getFullYear();
    var mnew = datenew.getMonth();
    var dnew = datenew.getDate();
    var yold = dateold.getFullYear();
    var mold = dateold.getMonth();
    var dold = dateold.getDate();
    var diff = ynew - yold;
    if(mold > mnew) diff--;
    else
    {
      if(mold == mnew)
      {
        if(dold > dnew) diff--;
      }
    }
    return diff;
}


function validateFormReservation(){
    document.getElementById("komunikat").innerHTML = "";
    var isCorrect=true;
     document.getElementById("dataOdbioru").style.outline="none";
     document.getElementById("dataZwrotu").style.outline="none";

    var inputdataOdbioru = document.forms["rezerwacja"]["data_odbioru"].value;
    var inputdataZwrotu = document.forms["rezerwacja"]["data_zwrotu"].value;

    
     var dataOdbioru = new Date(inputdataOdbioru);
    var dataZwrotu = new Date(inputdataZwrotu);
     var today = new Date();

     if(dataOdbioru<=today || dataZwrotu<=today){
         if(dataOdbioru.getDate()===today.getDate()){
             //empty 
         }
         else {
             isCorrect=false;
         }
     }

     if(dataOdbioru.getTime()===dataZwrotu.getTime()){
         document.getElementById("komunikat").innerHTML += "<div class=\"oaerror warning\">Pojazd może być wypożyczony na co najmniej jeden dzień!</div>";
         return false;
     }

    if(dataZwrotu<dataOdbioru){
         isCorrect=false;
     }

    if(!isCorrect){
       displayReservError();
       return false;
    } 
    else return true;
}

function displayReservError(){
    document.getElementById("komunikat").innerHTML += "<div class=\"error-notice\"><div class=\"oaerror danger\"><strong>Błąd!</strong> Wybierz prawidłową datę odbioru i zwrotu!</div></div>";
    document.getElementById("dataOdbioru").style.outline="2px solid red";
    document.getElementById("dataZwrotu").style.outline="2px solid red";
}


function validateFormPrzyjmij() {
    var data = document.forms["wypozyczenia"]["test"].value;
    var dataOdbioru = new Date(data);
    alert(data);
    document.getElementById("komunikat").innerHTML += "<div class=\"oaerror danger\">Data odbioru będzie !</div>";
    return false;
}