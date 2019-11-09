<link href="https://fonts.googleapis.com/css?family=Coda:800|Lato:300|Open+Sans" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
<script>
function myFunction() {
  document.getElementById("toClose").style.display = "none";
}
</script>

<div id="toClose">
<?php
if(isset($_POST['wniosek'])){  //WNIOSEK
$carID=$_POST['carID'];
echo 'ID samochodu: '.$carID.' </br>Tu będzie wniosek';
} else if(isset($_POST['carID'])) {  //INFO O AUCIE
    if(!isset($_SESSION['uID']))
    {
        $_SESSION['doZalogowania'] = 1;
        echo '<div class="alert alert-danger" role="alert">Musisz się zalogować!</div>';
        require 'logowanie.php';   
    }
        else
        {
            if($isDataFilled==0)
            {
                echo '<p class="alert alert-danger">Musisz wypełnić dane!</p>';
                require 'oferta.php';  
            }
            else
            {
                require 'includes/dbh.inc.php';
                $id=$_POST['carID'];
                $sql="SELECT * FROM pojazdy WHERE id=$id";
                $query = mysqli_query($conn, $sql);
                $row=mysqli_fetch_row($query);
                $marka=$row[1]; 
                $model=$row[2]; 
                $zdjecie=$row[5];
                $imgContent=base64_encode(base64_decode($zdjecie));

                $sql="SELECT wyposazenie.id,wyposazenie.nazwa, wyposazenie.ikona 
                FROM wyposazenie
                JOIN samochody_wyposazenie ON  wyposazenie.id=samochody_wyposazenie.id_wyposazenia
                WHERE samochody_wyposazenie.id_samochodu=$id";
 
                $result = mysqli_query($conn, $sql);
                mysqli_fetch_all($result,MYSQLI_ASSOC);
                

                echo '
                <center>
<div class="caRcard">
  <span id="green-arrow"><a href="index.php?action=oferta">&#8592;</a></span>
  <div class="item">
    <div class="text">
      <h1 class="car">'.$marka.'</h1>
      <h2 class="car">'.$model.'</h2>
      <span id="price1">Cena w zł</span>
      <img class="car" src="data:image/png;base64,'.$imgContent.'"/>
    </div>
  </div>
  <div class="item">

    <p class="car"></p><p size="20px"><b>Wyposażenie:</b></p>
    <div class="stock">';
    foreach ($result as $row){
        $img=$row['ikona'];
        $imgContent=base64_encode($img);
        echo'
        <table class="carReserv">
        <tr>
        <td><img class="icon" src="data:image/png;base64,'.$imgContent.'"/></td>
        <td>'.$row['nazwa'].'</td>
        </tr>
        </table>
        ';
    }

    echo '</div></div><br>
    <div>
      
    </div><br>
    <div id="quantity">
    </div><br>
    <form method="POST" action="index.php?action=carreserv">
    <input type="hidden" name="carID" value="'.$id.'">
    <div><button id="cart" onclick="myFunction()" name="wniosek">ZŁÓŻ WNIOSEK</button></div>
    </form>
  </div>

</div></center>
                
                '; 
            }

        }
    }
else header('Location: index.php?action=home');

?>
</div>
