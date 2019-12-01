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

// $servername="sql7.freemysqlhosting.net:3306";
// $dbUsername="sql7313386";
// $password="KGvhADhvpb";
// $dbName="sql7313386";

// $conn=mysqli_connect($servername,$dbUsername,$password,$dbName);
// if(!$conn)
// {
//     die("Connection failed: ".mysqli_connect_error());
// }
// else $conn->query("SET NAMES 'utf8'");

?>