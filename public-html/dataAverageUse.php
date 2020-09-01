<?php
    include("conexion.php");
    mysqli_query($con, "SET lc_time_names = 'es_ES'");
    $query = "SELECT dayname(fecha) as dias, avg(peso) as wprom, avg(amount) as prom from (SELECT fecha, sum(pesoObjeto) as peso, count(*) as amount from RegistroObjeto group by fecha) as tmp group by dayname(fecha) order by dayofweek(fecha) asc";
    $result = mysqli_query($con, $query);
    
    $dias = array();
    $quant = array();
    $peso = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($dias, $row['dias']);
        array_push($quant, (int)$row['wprom']);
        array_push($peso, round($row['prom'],2));
    }
    mysqli_free_result($result);

    mysqli_close($con);
?>