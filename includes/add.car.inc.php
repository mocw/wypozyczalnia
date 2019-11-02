<?php
if(isset($_POST['add-car-submit'])){

    if(isset($dodajZdj)) unset($dodajZdj);
    if(isset($success)) unset($success);
    require 'dbh.inc.php';
    $marka=$_POST['marka'];
    $model=$_POST['model'];
    $rok_produkcji=$_POST['rok_produkcji'];
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
            $sql="INSERT INTO pojazdy(marka,model,rok_produkcji,poj_silnika,zdjecie) VALUES('$marka','$model',
            '$rok_produkcji','$poj_silnika','$imgContent')";            
            if(!mysqli_query($conn,$sql)) {
                echo '<p class="alert">Błąd SQL!</p>';
                require 'carOperations/addCar.php'; 
                }
                else {
                    $success=1;                    
                    require 'carOperations/addCar.php';              
                }    
        }

} else header('Location: index.php?action=home');
?>