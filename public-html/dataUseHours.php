<?php
    include("conexion.php");

    $query = "SELECT horas, avg(amount) as prom from (SELECT fecha, hour(hora) as horas, count(*) as amount from RegistroObjeto group by fecha, hour(hora) order by fecha asc) as tmp group by horas order by horas asc";
    $result = mysqli_query($con, $query);
    
    $horas = array();
    $objetos = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($horas, $row['horas']);
        array_push($objetos, round($row['prom'],2));
    }
    mysqli_free_result($result);
?>