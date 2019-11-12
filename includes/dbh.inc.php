<?php
$servername="localhost";
$dbUsername="root";
$password="";
$dbName="wypozyczalnia";

$conn=mysqli_connect($servername,$dbUsername,$password,$dbName);
if(!$conn)
{
    die("Connection failed: ".mysqli_connect_error());
}
else $conn->query("SET NAMES 'utf8'");

// $servername="db4free.net";
// $dbUsername="wypozyhost";
// $password="wypozyczalnia";
// $dbName="wypozyczalniadb";

// $conn=mysqli_connect($servername,$dbUsername,$password,$dbName);
// if(!$conn)
// {
//     die("Connection failed: ".mysqli_connect_error());
// }
// else $conn->query("SET NAMES 'utf8'");

?>