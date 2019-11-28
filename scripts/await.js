var rows = document.getElementById("dtOrderExample").getElementsByTagName("tr").length;
rows-=2;
console.log("rows:",rows);

 setTimeout(
    function() {
      var i;
      console.log("TE:",rows);
      for(i=1;i<=rows;i++){
        document.getElementById('przyjmij'+i).disabled = false;
      }
    }, 3000);

