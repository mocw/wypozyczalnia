function validateForm(){
    document.getElementById("komunikat").innerHTML= "";
    var nr_dowodu=$("input[name='nr_dowodu']").val();
    var kod_pocztowy=$("input[name='kod_pocztowy']").val();
    var flag=true;
    if(!validateDO(nr_dowodu)){
        document.getElementById("komunikat").innerHTML += "<div class=\"error-notice\"><div class=\"oaerror danger\">Numer dowodu " + nr_dowodu +
        " jest nieprawidłowy!</div></div>";
        flag=false;
    }

    if(flag){
        return true;
    } else {
        $("html, body").animate({scrollTop: 0}, 400);
        return false;
    }    
}


function validateDO(numer)
{
//Check length
if (numer == null || numer.length != 9)
return false;
 
numer = numer.toUpperCase();
letterValues = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
function getLetterValue(letter){
return letterValues.indexOf(letter)
}
 
//Check seria
for (i=0; i<3; i++)
if (getLetterValue(numer[i]) < 10 || numer[i] == 'O' || numer == 'Q')
return false;
//Check numbers
for (i=3; i<9; i++)
if (getLetterValue(numer[i]) < 0 || getLetterValue(numer[i]) > 9)
return false;
 
//sprawdz cyfre kontrolna
sum = 7 * getLetterValue(numer[0]) +
3 * getLetterValue(numer[1]) +
1 * getLetterValue(numer[2]) +
7 * getLetterValue(numer[4]) +
3 * getLetterValue(numer[5]) +
1 * getLetterValue(numer[6]) +
7 * getLetterValue(numer[7]) +
3 * getLetterValue(numer[8]);
sum %= 10;
if (sum != getLetterValue(numer[3]))
return false;
 
return true;
}
