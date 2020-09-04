<?php
    include("conexion.php");
    
    // La consulta que se requiere realizar tiene como objetivo obtener
    // el promedio de objetos acumulados en un día según la hora. De modo
    // que se realiza una consulta interna donde se cuentan los objetos
    // y se agrupan los datos por cada fecha y hora. Nótese que se agrupa
    // según la hora del día en la consulta interna. Luego en la consulta 
    // externa se agrupa por las horas del día y según la cantidad se 
    // obtiene el promedio con avg(). Finalamente, se guardan los
    // resultados en dos variables.
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