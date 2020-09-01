<?php
    include("conexion.php");

    $query = "SELECT tipo, sum(pesoObjeto) as peso, count(*) as amount from RegistroObjeto inner join Contenedor on RegistroObjeto.id_contenedor=Contenedor.id group by tipo";
    $result = mysqli_query($con, $query);
    
    $tipos = array();
    $cantidad = array();
    $peso = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($tipos, $row['tipo']);
        array_push($cantidad, (int)$row['amount']);
        array_push($peso, round($row['peso'],2));
    }
    mysqli_free_result($result);

    mysqli_close($con);
?>