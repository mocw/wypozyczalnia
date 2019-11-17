<?php
if(isset($_POST['add-car-submit'])){

    if(isset($dodajZdj)) unset($dodajZdj);
    if(isset($success)) unset($success);
    require 'dbh.inc.php';
    $marka=$_POST['marka'];
    $model=$_POST['model'];
    $rok_produkcji=$_POST['rok_produkcji'];
    $cena=$_POST['cena'];
    $poj_silnika=$_POST['poj_silnika'];
    $check = getimagesize($_FILES['image']['tmp_name']);
    if($check === false){
        $dodajZdj=1;
        require 'carOperations/addCar.php';        
    }
        else {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = base64_encode(file_get_contents($image));
            $stmt=mysqli_stmt_init($conn);
            $sql="INSERT INTO pojazdy(marka,model,rok_produkcji,poj_silnika,Cena,zdjecie) VALUES('$marka','$model',
            '$rok_produkcji','$poj_silnika','$cena','$imgContent')";            
            if(!mysqli_query($conn,$sql)) {
                echo '<p class="alert">Błąd SQL!</p>';
                require 'carOperations/addCar.php'; 
                }
                else {
                    $car_id = mysqli_insert_id($conn);
                    foreach($_POST as $key => $name){
                        if($key=="marka" || $key=="model" || $key=="rok_produkcji"
                        || $key=="poj_silnika") continue;
                        if($key=="add-car-submit") break;
                        $sql="INSERT INTO samochody_wyposazenie(id_wyposazenia,id_samochodu) 
                        VALUES('$key','$car_id')";
                        mysqli_query($conn,$sql);
                    }    
                    $success=1;                    
                    require 'carOperations/addCar.php';              
                }
        }

} else header('Location: index.php?action=home');
?>