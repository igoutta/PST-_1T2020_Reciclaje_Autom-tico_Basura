<?php
include("conexion.php");

/** 
 * Se usa este archivo para el envío de datos a la base de datos
 * a través de la conexión con Arduino
*/
$prueba = $_POST["p"];

$query2 = $_POST["up"];

mysqli_query ($con, $query2);


$query1 = $_POST["in"];

mysqli_query ($con, $query1);

mysqli_close($con);
?>