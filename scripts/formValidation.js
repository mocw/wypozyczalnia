function validateForm() {
    document.getElementById("komunikat").innerHTML = "";
    document.getElementById("nr_tel").style.outline="none";
    document.getElementById("pesel").style.outline="none";
    document.getElementById("nr_tel").style.backgroundColor="white";
    document.getElementById("pesel").style.backgroundColor="white";

    var pesel = document.forms["register"]["pesel"].value;
    if(!isValidPesel(pesel)){
        document.getElementById("komunikat").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\">Nieprawidłowy PESEL!</div>";
        document.getElementById("pesel").style.backgroundColor="rgba(248, 215, 218, 1)";
        document.getElementById("pesel").style.outline="2px solid red";
        return false;
    }

    var nr_tel = document.forms["register"]["nr_tel"].value;
    if(nr_tel.length!=9 || isNaN(nr_tel)){
        document.getElementById("komunikat").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\">Nieprawidłowy numer telefonu!</div>";
        document.getElementById("nr_tel").style.backgroundColor="rgba(248, 215, 218, 1)";
        document.getElementById("nr_tel").style.outline="2px solid red";
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