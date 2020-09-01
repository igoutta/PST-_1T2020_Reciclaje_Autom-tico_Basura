<?php
include("conexion.php");

$prueba = $_POST["p"];

$query2 = $_POST["up"];

mysqli_query ($con, $query2);


$query1 = $_POST["in"];

mysqli_query ($con, $query1);

mysqli_close($con);
?>





