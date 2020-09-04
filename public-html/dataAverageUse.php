<?php
    include("conexion.php");
    // Es necesario indicar a la base de datos que trabaje con la información en Español
    // debido a que se utilizara para obtener los días de la semana.
    mysqli_query($con, "SET lc_time_names = 'es_ES'");
    // La consulta requiere que se promedien ciertos datos, por lo cual 
    // se realiza inicialmente una consulta interna que se pasa como 
    // tabla en la consulta externa. La consulta interna se agrupa por fecha 
    // mediante GROUP BY, y se obtiene la suma de pesoObjeto, se cuenta los 
    // objetos y se agrega la fecha. Dentro de la consulta externa se agrupa 
    // por el día de la semana dayname(campo) y se ordena por dayofweek(campo)
    // mientras que se obtiene el día de la semana, el promedio del peso y de los objetos desechados.
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