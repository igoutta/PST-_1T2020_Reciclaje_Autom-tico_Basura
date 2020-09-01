<?php
    include("conexion.php");
    mysqli_query($con, "SET lc_time_names = 'es_ES'");

    $query = "SELECT date_format(fecha, '%M-%y') as mes, count(*) as cuenta from RegistroObjeto inner join Contenedor on RegistroObjeto.id_contenedor=Contenedor.id  where Contenedor.tipo = 'papel' group by date_format(fecha, '%M-%y') order by fecha asc";
    $result = mysqli_query($con, $query);
    
    $meses = array();
    $cuenta = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($meses, $row['mes']);
        array_push($cuenta, (int)$row['cuenta']);
    }
    mysqli_free_result($result);

    $query2 = "SELECT year(fecha), month(fecha), count(*) as cuenta from RegistroObjeto inner join Contenedor on RegistroObjeto.id_contenedor=Contenedor.id  where tipo = 'metal' group by EXTRACT(YEAR_MONTH FROM fecha) order by fecha asc";
    $result2 = mysqli_query($con, $query2);

    $cuenta2 = array();
    while ($row2= mysqli_fetch_array($result2)) {
        array_push($cuenta2, (int)$row2['cuenta']);
    }
    mysqli_free_result($result2);

    mysqli_close($con);
?>