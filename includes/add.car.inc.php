<?php
if(isset($_POST['add-car-submit']) && $_SESSION['czyPracownik']==1 ){
    error_reporting(0);
    require 'dbh.inc.php';
    $marka=$_POST['marka'];
    $model=$_POST['model'];
    $rok_produkcji=$_POST['rok_produkcji'];
    $poj_silnika=$_POST['poj_silnika'];
    $check = getimagesize($_FILES['image']['tmp_name']);
    if($check === false){
        require 'carOperations/addCar.php';  
        echo '<script language="javascript">';
        echo 'alert("Dodaj zdjęcie!")';
        echo '</script>';        
    }
        else {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = base64_encode(file_get_contents($image));
            $stmt=mysqli_stmt_init($conn);
            $sql="INSERT INTO pojazdy(marka,model,rok_produkcji,poj_silnika,zdjecie) VALUES('$marka','$model',
            '$rok_produkcji','$poj_silnika','$imgContent')";            
            if(!mysqli_query($conn,$sql)) {
                echo '<p class="alert">Błąd SQL!</p>';
                require 'carOperations/addCar.php'; 
                }
                else {                    
                    require 'carOperations/addCar.php'; 
                    echo '<script language="javascript">';
                    echo 'alert("Pojazd został dodany!")';
                    echo '</script>';                 
                } 
            //mysqli_stmt_close($stmt);
            //mysqli_close($conn);       
        }
error_reporting(1);
} else header('Location: index.php?action=home');
?>